<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'car_id', 'customer_id', 'start_date', 'end_date', 'total',
        'total_amount', 'commission_amount',
        'extra_options', 'status', 'contact_number',  'slug', 'image', 'is_active', 'sort_order',
    ];
    protected $casts = [
          'total_amount' => 'decimal:2',
          'commission_amount' => 'decimal:2',
          'start_date' => 'datetime',
          'end_date' => 'datetime',
          'is_active' => 'boolean',
      ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function bookingCommissions(): HasMany
    {
        return $this->hasMany(BookingCommission::class);
    }
    
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function getMainImageAttribute($value)
    {
        if (!$value) {
            return asset('images/default.png'); // صورة افتراضية
        }

        // لو القيمة URL كامل (http/https)
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        // لو بتبدأ بـ /storage أو storage -> رجّعها كاملة
        if (str_starts_with($value, '/storage') || str_starts_with($value, 'storage')) {
            return asset(ltrim($value, '/'));
        }

        // غير كده يبقى مجرد اسم ملف
        return asset('storage/cars/' . $value);
    }

    /**
       * حساب وتطبيق العمولات تلقائيًا
       */
      public function applyCommissions()
      {
          $car = $this->car;

          // البحث عن العمولات النشطة لـ plate_type المحدد
          $commissions = Commission::where('plate_type', $car->plate_type)
              ->where('is_active', true)
              ->get();

          $totalCommission = 0;
          $commissionRecords = [];

          foreach ($commissions as $commission) {
              $amount = $commission->type === 'percentage'
                  ? ($this->total_amount * $commission->value / 100)
                  : $commission->value;

              if ($commission->applies_to === 'both') {
                  // تقسيم العمولة بين المشتري والبائع
                  $buyerAmount = $amount / 2;
                  $sellerAmount = $amount / 2;

                  $commissionRecords[] = [
                      'commission_id' => $commission->id,
                      'amount' => $buyerAmount,
                      'applies_to' => 'buyer',
                  ];
                  $commissionRecords[] = [
                      'commission_id' => $commission->id,
                      'amount' => $sellerAmount,
                      'applies_to' => 'seller',
                  ];

                  $totalCommission += $amount;
              } else {
                  // تطبيق العمولة على المستخدم المحدد
                  $commissionRecords[] = [
                      'commission_id' => $commission->id,
                      'amount' => $amount,
                      'applies_to' => $commission->applies_to,
                  ];

                  $totalCommission += $amount;
              }
          }

          // تخزين سجلات العمولات
          foreach ($commissionRecords as $record) {
              $bookingCommission = $this->bookingCommissions()->create($record);

              // تخزين عمولة الموقع في جدول منفصل
              SiteCommission::create([
                  'booking_commission_id' => $bookingCommission->id,
                  'amount' => $bookingCommission->amount,
                  'applies_to' => $bookingCommission->applies_to,
                  'description' => 'Site commission for booking ' . $this->id,
              ]);
          }

          // تحديث إجمالي العمولات
          $this->commission_amount = $totalCommission;
          $this->save();

          // خصم العمولات من المحافظ
          $this->deductCommissionsFromWallets();
      }

      /**
       * خصم العمولات من المحافظ
       */
      private function deductCommissionsFromWallets()
      {
          foreach ($this->bookingCommissions as $bookingCommission) {
              $userId = $bookingCommission->applies_to === 'buyer' 
                  ? $this->user_id 
                  : $this->car->user_id;

              $wallet = Wallet::where('user_id', $userId)->first();

              if ($wallet && $wallet->balance >= $bookingCommission->amount) {
                  $wallet->balance -= $bookingCommission->amount;
                  $wallet->save();

                  $wallet->transactions()->create([
                      'amount' => -$bookingCommission->amount,
                      'type' => 'commission',
                      'status' => 'completed',
                      'slug' => Str::slug('commission-booking-' . $this->id . '-' . $bookingCommission->id . '-' . uniqid()),
                      'is_active' => true,
                  ]);
              } else {
                  // لو الرصيد مش كافي، ممكن نرفض الحجز أو نرسل تنبيه
                  \Log::warning("Insufficient balance for commission deduction", [
                      'booking_id' => $this->id,
                      'commission_id' => $bookingCommission->id,
                      'user_id' => $userId,
                      'required_amount' => $bookingCommission->amount,
                      'available_balance' => $wallet?->balance ?? 0,
                  ]);
              }
          }
      }

      protected static function boot()
      {
          parent::boot();

          static::creating(function ($model) {
              if (empty($model->slug)) {
                  $baseSlug = Str::slug('booking-' . uniqid());
                  $slug = $baseSlug;
                  $count = 1;

                  while (static::where('slug', $slug)->exists()) {
                      $slug = $baseSlug . '-' . $count++;
                  }

                  $model->slug = $slug;
              }
          });

          static::created(function ($model) {
              $model->applyCommissions();
          });
      }
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use App\Models\Commission;
use App\Models\BookingCommission;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'car_id', 'customer_id', 'start_date', 'end_date', 'total',
        'total_amount', 'commission_amount',
        'extra_options', 'status', 'contact_number', 'seller_amount', 'base_price',  'slug', 'image', 'is_active', 'sort_order',
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
     * حساب العمولات وتخزينها
     */


    // public function applyCommissions()
    // {
    //     $carPlateType = $this->car->plate_type;
    //     $basePrice = $this->base_price ?? $this->total; // لو عندك حقل base_price

    //     $commissions = Commission::where('plate_type', $carPlateType)
    //         ->where('is_active', true)
    //         ->get();

    //     $totalCommission = 0;
    //     $buyerPays = $basePrice;
    //     $sellerReceives = $basePrice;

 
    //     foreach ($commissions as $commission) {
    //         $amount = $commission->type === 'percentage'
    //             ? ($basePrice * $commission->value / 100)
    //             : $commission->value;

    //         // 👇 هنا بنحدد الأطراف
    //         $appliesToList = $commission->applies_to === 'both'
    //             ? ['buyer', 'seller']
    //             : [$commission->applies_to];

    //         foreach ($appliesToList as $appliesTo) {
    //             BookingCommission::updateOrCreate(
    //                 [
    //                     'booking_id'    => $this->id,
    //                     'commission_id' => $commission->id,
    //                     'applies_to'    => $appliesTo,   // ✅ مش بنخزن both
    //                 ],
    //                 [
    //                     'amount' => $amount,
    //                 ]
    //             );
    //             SiteCommission::updateOrCreate(
    //                 [
    //                     'booking_commission_id' => $bookingCommission->id,
    //                     'applies_to'            => $appliesTo,
    //                 ],
    //                 [
    //                     'amount'      => $amount,
    //                     'description' => "Site commission for booking {$this->id}",
    //                 ]
    //             );

    //             if ($appliesTo === 'seller') {
    //                 $sellerReceives -= $amount;
    //             } elseif ($appliesTo === 'buyer') {
    //                 $buyerPays += $amount;
    //             }

    //             $totalCommission += $amount;
    //         }
    //     }



    //     $this->update([
    //         'commission_amount' => $totalCommission,
    //         'base_price' => $basePrice,
    //         'total' => $buyerPays,            // اللي العميل هيدفعه
    //         'seller_amount' => $sellerReceives // اللي البائع هياخده
    //     ]);
    // }


    public function applyCommissions()
    {
        $carPlateType = $this->car->plate_type;
        $basePrice = $this->base_price ?? $this->total; // لو عندك حقل base_price

        $commissions = Commission::where('plate_type', $carPlateType)
            ->where('is_active', true)
            ->get();

        $totalCommission = 0;
        $buyerPays = $basePrice;
        $sellerReceives = $basePrice;

        foreach ($commissions as $commission) {
            $amount = $commission->type === 'percentage'
                ? ($basePrice * $commission->value / 100)
                : $commission->value;

            // 👇 هنا بنحدد الأطراف
            $appliesToList = $commission->applies_to === 'both'
                ? ['buyer', 'seller']
                : [$commission->applies_to];

            foreach ($appliesToList as $appliesTo) {
                // ✅ خزنا BookingCommission في متغير
                $bookingCommission = BookingCommission::updateOrCreate(
                    [
                        'booking_id'    => $this->id,
                        'commission_id' => $commission->id,
                        'applies_to'    => $appliesTo,   // مش بنخزن both
                    ],
                    [
                        'amount' => $amount,
                    ]
                );

                // ✅ إنشاء SiteCommission مربوط بالـ BookingCommission
                SiteCommission::updateOrCreate(
                    [
                        'booking_commission_id' => $bookingCommission->id,
                        'applies_to'            => $appliesTo,
                    ],
                    [
                        'amount'      => $amount,
                        'description' => "Site commission for booking {$this->id}",
                    ]
                );

                if ($appliesTo === 'seller') {
                    $sellerReceives -= $amount;
                } elseif ($appliesTo === 'buyer') {
                    $buyerPays += $amount;
                }

                $totalCommission += $amount;
            }
        }

        $this->update([
            'commission_amount' => $totalCommission,
            'base_price'        => $basePrice,
            'total'             => $buyerPays,       // اللي العميل هيدفعه
            'seller_amount'     => $sellerReceives,  // اللي البائع هياخده
        ]);
    }







    /**
     * خصم العمولات من المحافظ
     */
    public function deductCommissionsFromWallets()
    {
        foreach ($this->bookingCommissions as $commission) {
            if ($commission->applies_to === 'seller') {
                $sellerWallet = Wallet::firstOrCreate(
                    ['user_id' => $this->car->user_id],
                    ['balance' => 0, 'is_active' => true, 'slug' => 'wallet-' . $this->car->user_id]
                );

                $sellerWallet->decrement('balance', $commission->amount);

                Transaction::create([
                    'wallet_id' => $sellerWallet->id,
                    'amount' => -$commission->amount,
                    'type' => 'commission',
                    'status' => 'completed',
                    'slug' => 'commission-seller-' . $commission->id . '-' . now()->timestamp,
                    'is_active' => true,
                ]);
            }

            if ($commission->applies_to === 'buyer') {
                $buyerWallet = Wallet::firstOrCreate(
                    ['user_id' => $this->customer_id],
                    ['balance' => 0, 'is_active' => true, 'slug' => 'wallet-' . $this->customer_id]
                );

                $buyerWallet->decrement('balance', $commission->amount);

                Transaction::create([
                    'wallet_id' => $buyerWallet->id,
                    'amount' => -$commission->amount,
                    'type' => 'commission',
                    'status' => 'completed',
                    'slug' => 'commission-buyer-' . $commission->id . '-' . now()->timestamp,
                    'is_active' => true,
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

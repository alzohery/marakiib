<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Relations\BelongsTo;
  use Illuminate\Database\Eloquent\Relations\HasMany;
  use Illuminate\Database\Eloquent\SoftDeletes;
  use Illuminate\Support\Str;

  class Booking extends Model
  {
      use SoftDeletes;

      protected $fillable = [
          'user_id', 'car_id', 'total_amount', 'commission_amount',
          'status', 'start_date', 'end_date', 'slug', 'is_active', 'sort_order',
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

      public function car(): BelongsTo
      {
          return $this->belongsTo(Car::class);
      }

      public function bookingCommissions(): HasMany
      {
          return $this->hasMany(BookingCommission::class);
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
      }
  }
  ?>
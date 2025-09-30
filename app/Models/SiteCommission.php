<?php

   namespace App\Models;

   use Illuminate\Database\Eloquent\Model;
   use Illuminate\Database\Eloquent\Relations\BelongsTo;

   class SiteCommission extends Model
   {
       protected $fillable = [
           'booking_commission_id',
           'amount',
           'applies_to',
           'description',
       ];

       protected $casts = [
           'amount' => 'decimal:2',
       ];

       public function bookingCommission(): BelongsTo
       {
           return $this->belongsTo(BookingCommission::class);
       }
   }
   ?>
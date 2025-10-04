<?php

   namespace App\Models;

   use Illuminate\Database\Eloquent\Model;
   use Illuminate\Database\Eloquent\Relations\BelongsTo;
   use Illuminate\Database\Eloquent\Relations\HasOne;

   class BookingCommission extends Model
   {
       protected $fillable = ['booking_id', 'commission_id', 'amount', 'applies_to'];

       protected $casts = [
           'amount' => 'decimal:2',
       ];

       public function booking(): BelongsTo
       {
           return $this->belongsTo(Booking::class);
       }

       public function commission(): BelongsTo
       {
           return $this->belongsTo(Commission::class);
       }

       public function siteCommission(): HasOne
       {
           return $this->hasOne(SiteCommission::class);
       }

       /**
        * الحصول على المستخدم المعني بالعمولة
        */
       public function appliesToUser()
       {
           return $this->applies_to === 'buyer' 
               ? $this->booking->customer 
               : $this->booking->car->user;
       }

       /**
        * الحصول على محفظة المستخدم المعني بالعمولة
        */
       public function appliesToWallet()
       {
           $user = $this->appliesToUser();
           return $user ? $user->wallet : null;
       }
   }
   ?>
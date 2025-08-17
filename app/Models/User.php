<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles; // إضافة Spatie HasRoles


class User extends Authenticatable implements MustVerifyEmail // أضف MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles; // إضافة HasRoles

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    protected $fillable = [
  
        'name', 'email', 'password', 'role', 'phone_number', 'address', 'latitude', 'longitude',
        'driving_license_image', 'car_license_image', 'car_license_expiry_date',
        'commercial_registration_number', 'provider', 'provider_id', 'avatar', 'status',
        'slug', 'image', 'is_active', 'sort_order',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'car_license_expiry_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the OTPs for the user.
     */
    public function otps()
    {
        return $this->hasMany(Otp::class);
    }
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }


    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

}
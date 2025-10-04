<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'api';
    // protected $guard_name = 'web'; // مهم جداً

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone_number', 'address',
        'latitude', 'longitude',
        'driving_license_image', 'car_license_image', 'car_license_expiry_date',
        'commercial_registration_number',
        'provider', 'provider_id',
        'avatar', 'status', 'slug', 'image',
        'is_active', 'sort_order',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'car_license_expiry_date' => 'date',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    // Accessor for avatar
    public function getAvatarAttribute($value)
    {
        return $value ? url(Storage::url($value)) : null;
    }

    // Accessor for image
    public function getImageAttribute($value)
    {
        return $value ? url(Storage::url($value)) : null;
    }

    // Accessor for driving_license_image
    public function getDrivingLicenseImageAttribute($value)
    {
        return $value ? url(Storage::url($value)) : null;
    }

    // Accessor for car_license_image
    public function getCarLicenseImageAttribute($value)
    {
        return $value ? url(Storage::url($value)) : null;
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
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

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function favorites()
    {
        return $this->belongsToMany(Car::class, 'favorites', 'user_id', 'car_id')->withTimestamps();
    }

    // public function canAccessPanel(\Filament\Panel $panel): bool
    // {
    //     return $this->hasRole('admin');
    // }


}
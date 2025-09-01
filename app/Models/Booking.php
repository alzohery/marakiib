<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'car_id', 'customer_id', 'start_date', 'end_date', 'total',
        'extra_options', 'status', 'contact_number', 'gender', 'slug', 'image', 'is_active', 'sort_order',
    ];
    protected $casts = [
        'extra_options' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
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
}

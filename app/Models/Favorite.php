<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Favorite extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'car_id', 'slug', 'image', 'is_active', 'sort_order'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($favorite) {
            // إنشاء slug فريد باستخدام user_id + car_id + timestamp لتجنب التكرار
            $favorite->slug = \Str::slug('user-' . $favorite->user_id . '-car-' . $favorite->car_id . '-' . now()->timestamp);
        });
    }
}

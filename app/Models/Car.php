<?php
namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use Translatable, SoftDeletes;

    public $translatedAttributes = ['name', 'insurance_type', 'usage_nature', 'description', 'meta_title', 'meta_description', 'image_alt'];
    protected $fillable = [
        'user_id', 'car_type_id', 'model', 'color', 'main_image', 'extra_images',
        'engine_type', 'slug', 'plate_type', 'rental_price', 'availability_start',
        'availability_end', 'long_term_guarantee', 'pickup_delivery', 'is_active', 'sort_order',
    ];
    protected $casts = ['extra_images' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function carType()
    {
        return $this->belongsTo(CarType::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'car_category');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'car_tag');
    }

    public function options()
    {
        return $this->belongsToMany(OptionValue::class, 'car_options');
    }

    public function extraOptions()
    {
        return $this->belongsToMany(ExtraOption::class, 'car_extra_options');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function translations()
    {
        return $this->hasMany(CarTranslation::class);
    }

}
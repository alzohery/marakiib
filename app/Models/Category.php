<?php
namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use Translatable, SoftDeletes;

    public $translatedAttributes = ['name', 'description', 'meta_title', 'meta_description', 'image_alt'];
    protected $fillable = ['slug', 'image', 'is_active', 'sort_order'];

    protected $appends = ['image_url'];

    public function cars()
    {
        return $this->belongsToMany(Car::class, 'car_category');
    }

    // Accessor لعرض رابط الصورة كامل
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/default.png'); // صورة افتراضية
        }

        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        if (str_starts_with($this->image, '/storage') || str_starts_with($this->image, 'storage')) {
            return asset(ltrim($this->image, '/'));
        }

        return asset('storage/categories/' . $this->image);
    }
}

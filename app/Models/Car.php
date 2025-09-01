<?php
namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Car extends Model
{
    use Translatable, SoftDeletes, Searchable;
    
    public $translatedAttributes = ['name', 'insurance_type', 'usage_nature', 'description', 'meta_title', 'meta_description', 'image_alt'];
    // protected $fillable = [
    //     'user_id', 'car_type_id', 'model', 'color', 'main_image', 'extra_images',
    //     'engine_type', 'slug', 'plate_type', 'rental_price', 'availability_start',
    //     'availability_end', 'long_term_guarantee', 'pickup_delivery', 'is_active', 'sort_order',
    // ];
    protected $fillable = [
        'user_id',
        'car_type_id',
        'model',

        'color',
        'main_image',
        'extra_images',
        'engine_type',
        'slug',
        'plate_type',
        'rental_price',
        'availability_start',
        'availability_end',
        'long_term_guarantee',
        'pickup_delivery',
        'latitude',
        'longitude',
        'is_active',
        'sort_order',
        'name',
        'insurance_type',
        'usage_nature',
        'description',
        'meta_title',
        'meta_description',
        'image_alt',
    ];
    protected $casts = ['extra_images' => 'array'];
    protected $guard_name = 'api';
    public $translatable = [
        'name',
        'slug',
        'insurance_type',
        'usage_nature',
        'description',
        'meta_title',
        'meta_description',
        'image_alt',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favourites()
    {
        return $this->belongsTo(Favorite::class);
    }

    public function carType()
    {
        return $this->belongsTo(CarType::class);
    }

    public function reviews()
{
    return $this->hasMany(Review::class, 'car_id');
}
    

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'car_tag');
    }

    // public function options()
    // {
    //     return $this->belongsToMany(OptionValue::class, 'car_options');
    // }
    public function options()
    {
        return $this->belongsToMany(ExtraOption::class, 'car_extra_options', 'car_id', 'extra_option_id');
    }
    
    public function extraOptions()
    {
        return $this->belongsToMany(ExtraOption::class, 'car_extra_options');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();
        $array['name'] = $this->name;
        $array['description'] = $this->description;
        $array['meta_title' ] = $this->meta_title;
        // Add other searchable fields
        return $array;
    }

    

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', $value)
                    ->orWhere('slug', $value)
                    ->firstOrFail();
    }

// في موديل Car
    public function features()
    {
        return $this->hasManyThrough(
            Feature::class,
            FeatureValue::class,
            'id',          // foreign key on feature_values table
            'id',          // foreign key on features table
            null,          // local key on cars table
            'feature_id'   // local key on feature_values table
        );
    }

    public function translations()
    {
        return $this->hasMany(CarTranslation::class);
    }


    public function featureValues()
    {
        return $this->belongsToMany(FeatureValue::class, 'car_feature_values')
                    ->with(['translations', 'feature.translations']);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'car_category');
    }

    // car url
    // protected $appends = ['main_image_url', 'extra_images_urls'];

    

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




    public function getExtraImagesUrlsAttribute()
    {
        if (!$this->extra_images || !is_array($this->extra_images)) {
            return [];
        }

        return collect($this->extra_images)->map(function ($img) {
            if (filter_var($img, FILTER_VALIDATE_URL)) {
                return $img;
            }
            return asset('storage/cars/' . $img);
        })->toArray();
    }


}
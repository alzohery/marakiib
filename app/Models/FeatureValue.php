<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class FeatureValue extends Model
{
    protected $fillable = ['feature_id', 'slug', 'image', 'is_active', 'sort_order'];

    public function translations()
    {
        return $this->hasMany(FeatureValueTranslation::class);
    }

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }

    public function cars()
    {
        return $this->belongsToMany(Car::class, 'car_feature_values');
    }

protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        if (empty($model->slug)) {
            $baseSlug = \Str::slug(request('values.*.value.en', 'value-' . uniqid()));
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

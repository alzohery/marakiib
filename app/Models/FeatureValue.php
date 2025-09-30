<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class FeatureValue extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['value', 'description'];

    protected $fillable = [
        'feature_id',
        'slug',
        'image',
        'is_active',
        'sort_order',
    ];

    // 🔹 علاقة مع الـ Feature
    public function feature(): BelongsTo
    {
        return $this->belongsTo(Feature::class);
    }

    // 🔹 علاقة مع الـ Cars (Pivot table: car_feature_values)
    public function cars(): BelongsToMany
    {
        return $this->belongsToMany(Car::class, 'car_feature_values');
    }

    // 🔹 إنشاء slug تلقائي
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $defaultLocale = config('app.locale');

                $baseSlug = Str::slug(
                    $model->translateOrNew($defaultLocale)->value ?? 'value-' . uniqid()
                );

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

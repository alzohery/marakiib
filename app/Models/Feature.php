<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Feature extends Model
{
    protected $fillable = ['slug', 'type', 'image', 'is_required', 'is_active', 'sort_order'];

    

   
    public function translations()
    {
        return $this->hasMany(FeatureTranslation::class);
    }

    public function values()
    {
        return $this->hasMany(FeatureValue::class);
    }

    

    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        if (empty($model->slug)) {
            // خُد الاسم من الريكوست (بالإنجليزي مثلاً)
            $baseSlug = \Str::slug(request('name.en', 'feature-' . uniqid()));
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

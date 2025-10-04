<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use Translatable;

    protected $fillable = ['slug', 'is_active', 'sort_order'];

    public $translatedAttributes = ['title', 'content', 'meta_title', 'meta_description', 'meta_keywords', 'image', 'image_alt'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    public function translations()
    {
        return $this->hasMany(AboutTranslation::class);
    }

}
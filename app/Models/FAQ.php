<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'faqs';
    protected $fillable = ['slug', 'is_active', 'sort_order'];

    public $translatedAttributes = [
        'title', 'content', 'meta_title', 'meta_description', 
        'meta_keywords', 'image', 'image_alt'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // اضبط اسم العمود هنا
    public $translationForeignKey = 'faq_id';
}


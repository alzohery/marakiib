<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Terms extends Model
{
    use Translatable;

    protected $table = 'terms'; // الجدول الأساسي
    protected $fillable = ['slug', 'is_active', 'sort_order'];

    public $translatedAttributes = [
        'title',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'image',
        'image_alt'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function translations()
    {
        return $this->hasMany(TermsTranslation::class, 'terms_id'); 
        // لاحظ الاسم هنا TermTranslation (مفرد) مش TermsTranslation
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermsTranslation extends Model
{
    protected $table = 'term_translations'; // 👈 اسم الجدول زي ما في migration
    protected $fillable = [
        'title',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'image',
        'image_alt'
    ];

    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FAQTranslation extends Model
{
    protected $table = 'faq_translations';
    protected $fillable = ['title', 'content', 'meta_title', 'meta_description', 'meta_keywords', 'image', 'image_alt'];

    public $timestamps = false;
    public function faq()
    {
        return $this->belongsTo(FAQ::class, 'faq_id'); // ← force foreign key
    }
    
}
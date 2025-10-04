<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactTranslation extends Model
{
    protected $fillable = ['title', 'content', 'meta_title', 'meta_description', 'meta_keywords', 'image', 'image_alt'];

    public $timestamps = false;
}
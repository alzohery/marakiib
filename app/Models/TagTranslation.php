<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagTranslation extends Model
{
    protected $fillable = ['name', 'description', 'meta_title', 'meta_description', 'image_alt'];
    public $timestamps = false;
}

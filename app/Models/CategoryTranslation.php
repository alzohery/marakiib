<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    protected $fillable = ['name', 'description', 'meta_title', 'meta_description', 'image_alt'];
    public $timestamps = false;
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraOptionTranslation extends Model
{
    protected $fillable = ['name', 'description', 'meta_title', 'meta_description', 'image_alt'];
    public $timestamps = false;
}

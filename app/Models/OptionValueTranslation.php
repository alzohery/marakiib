<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionValueTranslation extends Model
{
    protected $fillable = ['value', 'description', 'meta_title', 'meta_description', 'image_alt'];
    public $timestamps = false;
}

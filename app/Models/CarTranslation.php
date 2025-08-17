<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarTranslation extends Model
{
    protected $fillable = ['name', 'insurance_type', 'usage_nature', 'description', 'meta_title', 'meta_description', 'image_alt'];
    public $timestamps = false;
}

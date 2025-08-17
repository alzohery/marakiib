<?php
namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarType extends Model
{
    use Translatable, SoftDeletes;

    public $translatedAttributes = ['name', 'description', 'meta_title', 'meta_description', 'image_alt'];
    protected $fillable = ['slug', 'image', 'icon_svg', 'is_active', 'sort_order'];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
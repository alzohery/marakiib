<?php
namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OptionValue extends Model
{
    use Translatable, SoftDeletes;

    public $translatedAttributes = ['value', 'description', 'meta_title', 'meta_description', 'image_alt'];
    protected $fillable = ['option_id', 'slug', 'image', 'is_active', 'sort_order'];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function cars()
    {
        return $this->belongsToMany(Car::class, 'car_options');
    }
}

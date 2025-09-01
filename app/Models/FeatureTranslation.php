<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureTranslation extends Model
{
    protected $fillable = ['feature_id', 'locale', 'name', 'description'];

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureValueTranslation extends Model
{
    protected $fillable = ['feature_value_id', 'locale', 'value', 'description'];

    public function featureValue()
    {
        return $this->belongsTo(FeatureValue::class);
    }
}

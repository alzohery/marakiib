<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Support extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'email', 'subject', 'message', 'status', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->slug = Str::slug($model->subject . '-' . now()->timestamp . '-' . Str::random(6));
    //     });
    // }
}
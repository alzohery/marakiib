<?php

   namespace App\Models;

   use Astrotomic\Translatable\Translatable;
   use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
   use Illuminate\Database\Eloquent\Model;

   class Commission extends Model implements TranslatableContract
   {
       use Translatable;

       public $translatedAttributes = ['description'];

       protected $fillable = ['plate_type', 'type', 'value', 'applies_to', 'is_active'];

       protected $casts = [
           'value' => 'decimal:2',
           'is_active' => 'boolean',
       ];
   }
   ?>
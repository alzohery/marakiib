<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class CommissionTranslation extends Model
    {
        protected $table = 'commission_translations';
        public $timestamps = true;

        protected $fillable = ['commission_id', 'locale', 'description'];

        public function commission()
        {
            return $this->belongsTo(Commission::class);
        }
    }
?>
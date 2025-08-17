<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = ['wallet_id', 'amount', 'type', 'status', 'slug', 'image', 'is_active', 'sort_order'];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}

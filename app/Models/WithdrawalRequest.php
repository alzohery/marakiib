<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WithdrawalRequest extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'amount', 'status', 'slug', 'image', 'is_active', 'sort_order'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

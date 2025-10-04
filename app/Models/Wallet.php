<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Wallet extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'balance', 'slug', 'image', 'is_active', 'sort_order'];

    protected $casts = [
        'balance' => 'decimal:2',
        'is_active' => 'boolean',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $baseSlug = Str::slug('wallet-' . $model->user_id . '-' . now()->timestamp);
                $slug = $baseSlug;
                $count = 1;

                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }

                $model->slug = $slug;
            }
        });
    }
}

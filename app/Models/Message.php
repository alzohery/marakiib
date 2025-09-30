<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Message extends Model
{
    use HasFactory, SoftDeletes;

    // protected $fillable = ['booking_id', 'sender_id', 'receiver_id', 'message', 'slug', 'image', 'is_active', 'sort_order'];
    protected $fillable = ['conversation_id', 'booking_id', 'sender_id', 'receiver_id', 'message', 'slug', 'image', 'is_active','read_at', 'sort_order'];
    protected $casts = [
        'read_at' => 'datetime',
    ];

    //  هل الرسالة مقروءة؟
    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    // 🟢 Mark message as read
    public function markAsRead()
    {
        if (!$this->isRead()) {
            $this->update(['read_at' => now()]);
        }
    }

    // العلاقات
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // public function sender()
    // {
    //     return $this->belongsTo(User::class, 'sender_id');
    // }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $baseSlug = Str::slug('msg-' . Str::uuid());
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

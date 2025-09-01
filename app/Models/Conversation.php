<?php
namespace App\Models;
use App\Models\User;
use App\Models\Message;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use SoftDeletes;

    protected $fillable = ['user1_id', 'user2_id', 'last_message_id', 'is_active', 'sort_order'];

    public function user1()
    {
        return $this->belongsTo(User::class, 'user1_id');
    }

    // علاقة مع المرسل الثاني
    public function user2()
    {
        return $this->belongsTo(User::class, 'user2_id');
    }

    // آخر رسالة
    public function lastMessage()
    {
        return $this->belongsTo(Message::class, 'last_message_id');
    }

    // كل الرسائل في المحادثة
    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id');
    }

    // حساب عدد الرسائل غير المقروءة لمستخدم معين
    public function unreadCountForUser($userId)
    {
        return $this->messages()
            ->where('receiver_id', $userId)
            ->whereNull('read_at')
            ->count();
    }

    // public function messages()
    // {
    //     return $this->hasMany(Message::class);
    // }

    public function getMainImageAttribute($value)
    {
        if (!$value) {
            return asset('images/default.png'); // صورة افتراضية
        }

        // لو القيمة URL كامل (http/https)
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        // لو بتبدأ بـ /storage أو storage -> رجّعها كاملة
        if (str_starts_with($value, '/storage') || str_starts_with($value, 'storage')) {
            return asset(ltrim($value, '/'));
        }

        // غير كده يبقى مجرد اسم ملف
        return asset('storage/cars/' . $value);
    }
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'car_id', 'customer_id', 'start_date', 'end_date', 'total',
        'extra_options', 'status', 'contact_number', 'gender', 'slug', 'image', 'is_active', 'sort_order',
    ];
    protected $casts = ['extra_options' => 'array'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}

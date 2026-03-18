<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'total', 'status', 'payment_method', 'payment_data'
    ];

    protected $casts = [
        'payment_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber()
    {
        return 'ORD-' . now()->format('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
    }
}

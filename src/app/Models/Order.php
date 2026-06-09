<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'buyer_user_id',
        'item_id',
        'payment_method',
        'order_status',
        'ordered_at',
    ];

    protected $casts = [
        'ordered_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'buyer_user_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function orderAddress()
    {
        return $this->hasOne(OrderAddress::class);
    }
}

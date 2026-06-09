<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    protected $table = 'orders_addresses';

    protected $fillable = [
        'order_id',
        'postal_code',
        'address',
        'building_name',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

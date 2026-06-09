<?php

namespace App\Models;

use App\Models\Favorite;
use App\Models\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'item_condition',
        'brand_name',
        'description',
        'price',
        'image_path',
        'is_sold',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'item_categories');
    }
}

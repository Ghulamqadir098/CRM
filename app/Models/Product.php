<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'category',
        'stock_quantity',
    ];
    public function cartItems()
    {
        return $this->morphMany(CartItem::class, 'itemable');
    }
    public function orderItems()
    {
        return $this->morphMany(OrderItem::class, 'itemable');
    }
    public function getImageAttribute($value)
    {
        if ($value == null) return null;
        return url($value); // Or: asset($value)
    }
}

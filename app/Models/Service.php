<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'description', 'price', 'image', 'duration'];
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

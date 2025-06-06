<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['user_id','cart_id','status'];
    public function user()
    {
        return $this->belongsTo(Customer::class);
    }
    public function cart(){
        return $this->belongsTo(Cart::class);
    }
    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
}

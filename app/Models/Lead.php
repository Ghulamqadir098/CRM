<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'message','status', 'user_id', 'source'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

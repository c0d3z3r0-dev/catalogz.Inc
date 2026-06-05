<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['token', 'client_id'];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

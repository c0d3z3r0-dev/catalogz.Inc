<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'client_id',
        'customer_phone',
        'status',
        'total',
        'paynow_poll_url',
        'paynow_reference',
        'pin_hash',
    ];

    protected $hidden = ['pin_hash'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

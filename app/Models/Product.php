<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'description',
        'price',
        'image_path',
        'is_available',
        'sort_order',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

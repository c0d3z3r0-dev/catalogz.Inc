<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Client extends Model
{
    protected $fillable = [
        'name', 'slug', 'whatsapp_number', 'email', 'logo_path', 'primary_color',
        'is_active', 'address', 'city', 'contact_email', 'background_color',
        'font_family', 'custom_css', 'api_token', 'merchant_token',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function generateApiToken(): string
    {
        $token = Str::random(60);
        $this->api_token = hash('sha256', $token);
        $this->save();
        return $token;
    }

    public function generateMerchantToken(): string
    {
        $token = Str::random(60);
        $this->merchant_token = hash('sha256', $token);
        $this->save();
        return $token;
    }
}

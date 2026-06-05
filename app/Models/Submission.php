<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'business_name', 'whatsapp_number', 'email',
        'address', 'city', 'contact_email', 'notes',
    ];

    public function products()
    {
        return $this->hasMany(SubmissionProduct::class);
    }
}

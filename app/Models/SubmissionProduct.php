<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionProduct extends Model
{
    protected $fillable = ['submission_id', 'image_path', 'product_name', 'product_price'];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}

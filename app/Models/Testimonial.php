<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    //
    protected $fillable = ['business_id', 'name', 'description', 'rating'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'business_id',
        'type',
        'title',
        'description',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}

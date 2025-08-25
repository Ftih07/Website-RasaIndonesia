<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    protected $fillable = [
        'business_id',
        'amount',
        'status',
        'payout_date',
        'description',
    ];

    protected $casts = [
        'payout_date' => 'datetime',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}

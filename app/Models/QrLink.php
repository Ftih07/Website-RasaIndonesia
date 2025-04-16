<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrLink extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}

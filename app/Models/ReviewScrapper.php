<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewScrapper extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'address',
        'phone',
        'website',
        'rating',
        'reviews',
        'maps_url',
        'additional_data',
    ];
    
    protected $casts = [
        'additional_data' => 'array',
    ];
}
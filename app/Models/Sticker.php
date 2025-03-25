<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sticker extends Model
{
    use HasFactory;

    protected $fillable = ['business_id', 'unique_code', 'pdf_path'];

    public function business()
    {
        return $this->belongsTo(\App\Models\Business::class);
    }    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryBusiness extends Model
{
    //
    protected $fillable = ['business_id', 'title', 'image'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}

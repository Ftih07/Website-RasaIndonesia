<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'business_id',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function scopeOwnedByBusiness($query, $businessId)
    {
        return $query->where('business_id', $businessId);
    }
}

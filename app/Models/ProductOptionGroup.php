<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOptionGroup extends Model
{
    protected $fillable = [
        'business_id',
        'name',
        'is_required',
        'max_selection',
    ];

    public function options()
    {
        return $this->hasMany(ProductOption::class, 'product_option_groups_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_option_group_product')
            ->withPivot(['is_required', 'max_selection']);
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

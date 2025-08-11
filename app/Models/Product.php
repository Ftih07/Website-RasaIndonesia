<?php

namespace App\Models; // Defines the namespace of this model, following Laravel's MVC structure

use Illuminate\Database\Eloquent\Model; // Imports the base Eloquent Model class

class Product extends Model
{
    // Specifies the attributes that are mass assignable
    protected $fillable = [
        'business_id',
        'name',
        'image',
        'type',
        'desc',
        'variants',
        'serving',
        'price',
        'max_distance',
        'is_sell',
    ];

    /**
     * Define a relationship where a product belongs to a business.
     * This means that each product is associated with a single business.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function business()
    {
        return $this->belongsTo(Business::class); // Defines a one-to-many inverse relationship
    }

    protected $casts = [
        'variants' => 'array',
        'is_sell' => 'boolean',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function optionGroups()
    {
        return $this->belongsToMany(ProductOptionGroup::class, 'product_option_group_product', 'product_id', 'product_option_groups_id');
    }
}

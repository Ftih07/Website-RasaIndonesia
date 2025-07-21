<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    protected $fillable = [
        'product_option_groups_id',
        'name',
        'price', // tambahkan ini
    ];

    public function group()
    {
        return $this->belongsTo(ProductOptionGroup::class, 'product_option_groups_id');
    }
}

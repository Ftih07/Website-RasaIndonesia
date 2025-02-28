<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GalleryBusiness
 *
 * Represents a gallery item associated with a specific business.
 *
 * @package App\Models
 */
class GalleryBusiness extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['business_id', 'title', 'image'];

    /**
     * Get the business that owns the gallery item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}

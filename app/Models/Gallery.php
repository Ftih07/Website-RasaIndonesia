<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Trait for generating model factories (for testing/seeding).
use Illuminate\Database\Eloquent\Model; // Base Eloquent Model class.
use Illuminate\Database\Eloquent\SoftDeletes; // Trait to enable soft deletion functionality.

/**
 * Class Gallery
 *
 * This Eloquent Model represents the 'galleries' table in the database.
 * It is used to store individual gallery items, typically containing an image
 * and a title. It also supports soft deletion, meaning records are not
 * permanently removed but rather marked as deleted.
 */
class Gallery extends Model
{
    // Use the SoftDeletes trait.
    // This enables the "soft delete" feature for this model. Instead of permanently
    // removing a record from the database, it sets a timestamp in the 'deleted_at' column.
    // This allows for easy restoration of records and maintaining historical data.
    use SoftDeletes;

    // Use the HasFactory trait.
    // This trait provides a convenient way to generate new model instances for testing
    // and database seeding purposes using model factories.
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * These fields can be safely filled using mass assignment (e.g., `Gallery::create([...])`).
     * Laravel's mass assignment protection prevents malicious input from setting unintended
     * attributes on your model. Only attributes listed here can be filled using this method.
     *
     * @var array
     */
    protected $fillable = [
        'title', // The title or caption for the gallery item.
        'image'  // The path or URL to the image file for this gallery item.
    ];
}

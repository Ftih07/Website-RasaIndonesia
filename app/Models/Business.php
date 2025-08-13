<?php

namespace App\Models;

use Illuminate\Support\Str; // Facade for string manipulation, used here for slug generation.
use Illuminate\Database\Eloquent\Model; // Base Eloquent Model class.
use Illuminate\Database\Eloquent\SoftDeletes; // Trait to enable soft deletion functionality.

/**
 * Class Business
 *
 * This Eloquent Model represents the 'businesses' table in the database.
 * It provides a structured way to interact with the business records,
 * including defining relationships with other models and handling data mutations.
 */
class Business extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * These fields can be safely filled via mass assignment (e.g., `Business::create([...])` or `->fill([...])->save()`).
     * It's a security feature in Laravel to prevent unintended attribute modifications.
     * Add any database column that you want to be mass assignable here.
     *
     * @var array
     */
    protected $fillable = [
        'type_id',          // Foreign key for the business type.
        'qr_link_id',       // Foreign key for associated QR link.
        'food_category_id', // Foreign key for the primary food category.
        'name',             // Name of the business.
        'slug',             // URL-friendly unique identifier for the business.
        'country',          // Country where the business is located.
        'city',             // City where the business is located.
        'description',      // Detailed description of the business.
        'logo',             // Path or URL to the business logo.
        'address',          // Physical address of the business.
        'iframe_url',       // URL for an embedded iframe (e.g., Google Maps).
        'open_hours',       // Business opening and closing hours.
        'services',         // Services offered by the business.
        'menu',             // Link or details about the business menu.
        'media_social',     // Links to the business's social media profiles.
        'location',         // General location text.
        'contact',          // Contact information (e.g., email, whatsapp).
        'latitude',         // Geographical latitude coordinate.
        'longitude',        // Geographical longitude coordinate.
        'unique_code',      // A unique identifier code for the business.
        'document',         // Path or reference to related documents.
        'order',            // Information related to ordering (e.g., ubereast, doordash).
        'reserve',          // Information related to reservations.
        'user_id',
        'is_verified',
        'is_open'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * This property defines how certain attributes should be converted when they are retrieved from
     * or set on the model. For example, 'array' means the attribute will be automatically
     * JSON encoded/decoded when interacting with the database.
     *
     * @var array
     */
    protected $casts = [
        'open_hours'   => 'array',    // Casts 'open_hours' JSON string to a PHP array.
        'services'     => 'array',    // Casts 'services' JSON string to a PHP array.
        'media_social' => 'array',    // Casts 'media_social' JSON string to a PHP array.
        'contact'      => 'array',    // Casts 'contact' JSON string to a PHP array.
        'order'        => 'array',    // Casts 'order' JSON string to a PHP array.
        'reserve'      => 'array',    // Casts 'reserve' JSON string to a PHP array.
    ];

    /**
     * Get the galleries associated with the business.
     *
     * Defines a one-to-many relationship where a Business can have many GalleryBusiness entries.
     * The foreign key 'business_id' on the 'gallery_businesses' table is used to link them.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function galleries()
    {
        return $this->hasMany(GalleryBusiness::class, 'business_id');
    }

    /**
     * Get the testimonials associated with the business.
     *
     * Defines a one-to-many relationship where a Business can have many Testimonial entries.
     * The foreign key 'business_id' on the 'testimonials' table is used to link them.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function testimonials()
    {
        return $this->hasMany(Testimonial::class, 'business_id');
    }

    /**
     * Get the products associated with the business.
     *
     * Defines a one-to-many relationship where a Business can have many Product entries.
     * By default, Laravel assumes the foreign key 'business_id' on the 'products' table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the type of the business.
     *
     * Defines a many-to-one (inverse of one-to-many) relationship where a Business belongs to one Type.
     * The foreign key 'type_id' on the 'businesses' table links to the 'types' table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    /**
     * Get the food categories associated with the business.
     *
     * Defines a many-to-many relationship where a Business can belong to many FoodCategories,
     * and a FoodCategory can belong to many Businesses.
     * The relationship is managed via a pivot table 'business_food_category'.
     * 'business_id' is the foreign key for this model on the pivot table.
     * 'food_category_id' is the foreign key for the related model on the pivot table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function food_categories()
    {
        return $this->belongsToMany(FoodCategory::class, 'business_food_category', 'business_id', 'food_category_id');
    }

    /**
     * Get the QR Link associated with the business.
     *
     * Defines a many-to-one (inverse of one-to-many) relationship where a Business belongs to one QrLink.
     * By default, Laravel assumes the foreign key 'qr_link_id' on the 'businesses' table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function qrLink()
    {
        return $this->belongsTo(\App\Models\QrLink::class);
    }

    /**
     * Get the average rating of the business based on its associated testimonials.
     *
     * This is an Eloquent "Accessor". When you try to access `$business->average_rating`,
     * this method will be automatically called to calculate and return the value.
     * It sums up all 'rating' values from related testimonials and divides by the count.
     * Returns 0 if there are no testimonials to avoid division by zero.
     *
     * @return float
     */
    public function getAverageRatingAttribute(): float
    {
        // Calculates the average rating from testimonials.
        // The `?? 0` ensures that if there are no testimonials (and thus `avg()` returns null),
        // the method returns 0 instead.
        return $this->testimonials->avg('rating') ?? 0;
    }

    /**
     * The "booted" method of the model.
     *
     * This method is called once when the model is initialized. It's a good place to
     * register global scopes, event listeners, or other one-time setup tasks for the model.
     */
    protected static function booted(): void
    {
        static::creating(function ($business) {
            $business->slug = Str::slug($business->name . '-' . uniqid());
        });

        static::updating(function ($business) {
            // Cek kalau nama berubah
            if ($business->isDirty('name')) {
                $business->slug = Str::slug($business->name . '-' . uniqid());
            }
        });
    }

    /**
     * Accessor to calculate the completeness status of the business profile.
     * This method evaluates several key attributes and relationships to determine
     * how complete the business's information is, returning a human-readable status string.
     *
     * @return string The completeness status (e.g., 'Complete', 'Good', 'Incomplete', 'Needs Work').
     */
    public function getCompletenessStatusAttribute(): string
    {
        // Initialize a score counter for completed fields.
        $score = 0;
        // Define the total number of criteria used to determine completeness.
        $total = 8;

        // Check if the 'name' attribute is filled.
        if ($this->name) {
            $score++;
        }

        // Check if the 'address' attribute is filled.
        if ($this->address) {
            $score++;
        }

        // Check if the 'type_id' attribute (indicating a business type is assigned) is filled.
        if ($this->type_id) {
            $score++;
        }

        // Check if the 'contact' attribute is an array and contains at least one entry.
        // The 'contact' attribute is likely stored as JSON in the database and cast to an array.
        if (is_array($this->contact) && count($this->contact) > 0) {
            $score++;
        }

        // Check if the 'logo' attribute (presumably a path to an image) is filled.
        if ($this->logo) {
            $score++;
        }

        // Check if the 'description' attribute is filled.
        if ($this->description) {
            $score++;
        }

        // Check if the 'open_hours' attribute is an array and contains at least one entry.
        // Similar to 'contact', this is likely a JSON-cast array.
        if (is_array($this->open_hours) && count($this->open_hours) > 0) {
            $score++;
        }

        // Check if the business has any related products.
        // The 'products()' method refers to an Eloquent relationship (e.g., hasMany).
        if ($this->products()->count() > 0) {
            $score++;
        }

        // Calculate the percentage of completeness based on the score and total criteria.
        $percentage = ($score / $total) * 100;

        // Determine the completeness status string based on the calculated percentage.
        // 'match (true)' is used for cleaner conditional logic similar to a switch statement.
        return match (true) {
            $percentage >= 90 => 'Complete',     // 90% or more: Complete
            $percentage >= 70 => 'Good',         // 70% to 89%: Good
            $percentage >= 50 => 'Incomplete',   // 50% to 69%: Incomplete
            default => 'Needs Work'              // Less than 50%: Needs Work
        };
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productOptionGroups()
    {
        return $this->hasMany(ProductOptionGroup::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function optionGroups()
    {
        return $this->hasMany(\App\Models\ProductOptionGroup::class);
    }
}

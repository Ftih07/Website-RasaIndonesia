<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Trait for generating fake model instances (for testing/seeding).
use Illuminate\Database\Eloquent\Model;              // Base Eloquent Model class.

/**
 * Class FoodCategory
 *
 * This Eloquent Model represents a `food_categories` table in the database.
 * It is used to define and manage different categories of food (e.g., "Italian", "Japanese", "Fast Food")
 * that can be associated with various businesses.
 *
 * @package App\Models
 */
class FoodCategory extends Model
{
    // Use the HasFactory trait to enable model factories, useful for testing and seeding data.
    use HasFactory;

    /**
     * The table associated with the model.
     * By default, Eloquent assumes the table name is the plural form of the model name.
     * In this case, 'food_categories' matches the default convention for 'FoodCategory'.
     *
     * @var string
     */
    protected $table = 'food_categories'; // Explicitly defined, though often optional if following convention.

    /**
     * The attributes that are mass assignable.
     * This array specifies which columns can be filled using mass assignment (e.g., `FoodCategory::create(['title' => 'Desserts'])`).
     *
     * @var array<int, string>
     */
    protected $fillable = ['title']; // Only the 'title' attribute can be mass assigned.

    /**
     * Define the many-to-many relationship with the Business model.
     * A FoodCategory can belong to many Businesses, and a Business can have many FoodCategories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function businesses()
    {
        // Define a many-to-many relationship using belongsToMany.
        // The arguments specify:
        // 1. Business::class: The related model (the other side of the relationship).
        // 2. 'business_food_category': The name of the intermediate pivot table.
        // 3. 'food_category_id': The foreign key on the pivot table that refers to *this* model's (FoodCategory) primary key.
        // 4. 'business_id': The foreign key on the pivot table that refers to the *other* model's (Business) primary key.
        return $this->belongsToMany(Business::class, 'business_food_category', 'food_category_id', 'business_id');
    }

    // --- Other common model properties/methods you might find here ---

    /**
     * The attributes that should be hidden for serialization.
     * (e.g., 'password', 'remember_token')
     * @var array
     */
    // protected $hidden = [];

    /**
     * The attributes that should be cast.
     * (e.g., 'email_verified_at' => 'datetime')
     * @var array
     */
    // protected $casts = [];

    /**
     * Default attribute values.
     * (e.g., ['status' => 'active'])
     * @var array
     */
    // protected $attributes = [];
}

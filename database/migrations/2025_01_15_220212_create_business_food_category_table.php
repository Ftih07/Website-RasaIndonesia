<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('business_food_category', function (Blueprint $table) {
            // Creates an auto-incrementing primary key column 'id'
            $table->id();

            // Defines a foreign key 'business_id' that references the 'id' column in 'businesses' table
            // When a referenced business is deleted, all related records will also be deleted (cascadeOnDelete)
            $table->foreignId('business_id')->constrained('businesses')->cascadeOnDelete();

            // Defines a foreign key 'food_category_id' that references the 'id' column in 'food_categories' table
            // When a referenced food category is deleted, all related records will also be deleted (cascadeOnDelete)
            $table->foreignId('food_category_id')->constrained('food_categories')->cascadeOnDelete();

            // Adds 'created_at' and 'updated_at' timestamp columns to track record creation and updates
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_food_category');
    }
};

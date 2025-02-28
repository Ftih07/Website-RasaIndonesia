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
        Schema::create('gallery_businesses', function (Blueprint $table) {
            // Creates an auto-incrementing primary key column 'id'
            $table->id();

            // Defines a foreign key 'business_id' that references the 'id' column in 'businesses' table
            // When a referenced business is deleted, all related gallery records will also be deleted (cascadeOnDelete)
            $table->foreignId('business_id')->constrained('businesses')->cascadeOnDelete();

            // Defines a string column 'title' to store the title of the gallery image
            $table->string('title');

            // Defines a string column 'image' to store the image path or URL
            $table->string('image');

            // Adds 'created_at' and 'updated_at' timestamp columns to track record creation and updates
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_businesses');
    }
};

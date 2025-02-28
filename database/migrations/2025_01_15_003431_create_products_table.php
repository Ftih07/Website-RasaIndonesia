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
        Schema::create('products', function (Blueprint $table) {
            // Creates an auto-incrementing primary key column 'id'
            $table->id();

            // Defines a foreign key 'business_id' that references the 'id' column in 'businesses' table
            // When a referenced business is deleted, all related products will also be deleted (cascadeOnDelete)
            $table->foreignId('business_id')->constrained('businesses')->cascadeOnDelete();

            // Defines a string column 'name' to store the product name
            $table->string('name');

            // Defines a string column 'image' to store the image path or URL of the product
            $table->string('image');

            // Defines an enum column 'type' to categorize the product as either 'food' or 'drink'
            $table->enum('type', ['food', 'drink']);

            // Defines a nullable string column 'serving' to store additional serving details (optional field)
            $table->string('serving')->nullable();

            // Defines a decimal column 'price' with a precision of 10 digits in total and 2 decimal places
            $table->decimal('price', 10, 2);

            // Adds 'created_at' and 'updated_at' timestamp columns to track record creation and updates
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

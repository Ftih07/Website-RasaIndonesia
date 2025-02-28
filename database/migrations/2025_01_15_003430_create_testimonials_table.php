<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.w
     */
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('business_id')->constrained('businesses')->cascadeOnDelete(); // Foreign key to businesses table
            $table->foreignId('testimonial_user_id')->constrained('testimonial_users')->cascadeOnDelete(); // Foreign key to testimonial_users table
            $table->string('name'); // Name of the person giving the testimonial
            $table->text('description'); // Testimonial text
            $table->integer('rating')->unsigned(); // Rating (e.g., 1-5 stars)
            $table->timestamps(); // Created at & Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};

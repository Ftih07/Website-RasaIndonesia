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
        // Creates the testimonial_users table
        Schema::create('testimonial_users', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('username')->unique(); // Unique username for authentication
            $table->string('password'); // Encrypted password
            $table->string('profile_picture')->nullable(); // Optional profile picture
            $table->timestamps(); // Created at & Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonial_users');
    }
};

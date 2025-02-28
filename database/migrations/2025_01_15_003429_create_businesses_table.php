<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * This method creates the businesses table with various attributes.
     */
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('type_id')->constrained('types')->cascadeOnDelete(); // Foreign key to types table
            $table->string('name'); // Business name
            $table->text('description'); // Business description
            $table->string('logo')->nullable(); // Optional logo
            $table->text('address'); // Business address
            $table->string('iframe_url', 500); // Embedded map URL
            $table->json('open_hours'); // JSON field for open hours
            $table->json('services'); // JSON field for services offered
            $table->string('menu')->nullable(); // Optional menu URL or path
            $table->json('media_social'); // JSON field for social media links
            $table->string('location')->nullable(); // Optional location description
            $table->json('contact'); // JSON field for contact details
            $table->timestamps(); // Created at & Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     * Drops the businesses table if it exists.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};

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
        Schema::table('businesses', function (Blueprint $table) {
            // Modifies the 'description' column to allow NULL values
            $table->text('description')->nullable()->change();
            
            // Modifies the 'address' column to allow NULL values
            $table->text('address')->nullable()->change();
            
            // Modifies the 'iframe_url' column with a max length of 500 and allows NULL values
            $table->string('iframe_url', 500)->nullable()->change();
            
            // Modifies the 'open_hours' column to allow NULL values, stored as JSON
            $table->json('open_hours')->nullable()->change();
            
            // Modifies the 'services' column to allow NULL values, stored as JSON
            $table->json('services')->nullable()->change();
            
            // Modifies the 'media_social' column to allow NULL values, stored as JSON
            $table->json('media_social')->nullable()->change();
            
            // Modifies the 'contact' column to allow NULL values, stored as JSON
            $table->json('contact')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            // Reverts the 'description' column to NOT NULL
            $table->text('description')->nullable(false)->change();
            
            // Reverts the 'address' column to NOT NULL
            $table->text('address')->nullable(false)->change();
            
            // Reverts the 'iframe_url' column to NOT NULL with a max length of 500
            $table->string('iframe_url', 500)->nullable(false)->change();
            
            // Reverts the 'open_hours' column to NOT NULL, stored as JSON
            $table->json('open_hours')->nullable(false)->change();
            
            // Reverts the 'services' column to NOT NULL, stored as JSON
            $table->json('services')->nullable(false)->change();
            
            // Reverts the 'media_social' column to NOT NULL, stored as JSON
            $table->json('media_social')->nullable(false)->change();
            
            // Reverts the 'contact' column to NOT NULL, stored as JSON
            $table->json('contact')->nullable(false)->change();
        });
    }
};

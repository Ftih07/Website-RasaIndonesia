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
        Schema::table('testimonials', function (Blueprint $table) {
            // Makes 'business_id' column nullable to allow testimonials without a business reference
            $table->foreignId('business_id')->nullable()->change();
            
            // Makes 'testimonial_user_id' column nullable to allow anonymous testimonials
            $table->foreignId('testimonial_user_id')->nullable()->change();
            
            // Makes 'description' column nullable to allow empty testimonial descriptions
            $table->text('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            // Reverts 'business_id' column back to NOT NULL
            $table->foreignId('business_id')->nullable(false)->change();
            
            // Reverts 'testimonial_user_id' column back to NOT NULL
            $table->foreignId('testimonial_user_id')->nullable(false)->change();
            
            // Reverts 'description' column back to NOT NULL
            $table->text('description')->nullable(false)->change();
        });
    }
};

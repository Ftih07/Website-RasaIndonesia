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
            // Adds a nullable 'latitude' column with decimal type (10 digits total, 8 decimal places)
            // Placed after the 'location' column for better organization
            $table->decimal('latitude', 10, 8)->nullable()->after('location');
            
            // Adds a nullable 'longitude' column with decimal type (11 digits total, 8 decimal places)
            // Placed after the 'latitude' column for consistency
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            // Removes the 'latitude' and 'longitude' columns when rolling back the migration
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};

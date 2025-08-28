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
        // migration: virtual_pickup_locations
        Schema::create('virtual_pickup_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('virtual_business_id')->constrained('businesses')->cascadeOnDelete();
            $table->foreignId('pickup_business_id')->constrained('businesses')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('virtual_pickup_locations');
    }
};

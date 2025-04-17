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
        Schema::create('review_scrappers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Unnamed Business');  // Tambahkan default value
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string( 'website')->nullable();
            $table->string('rating')->nullable();
            $table->text('reviews')->nullable();
            $table->string('maps_url');
            $table->json('additional_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_scrappers');
    }
};

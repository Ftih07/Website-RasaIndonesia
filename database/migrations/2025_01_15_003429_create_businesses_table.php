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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->constrained('types')->cascadeOnDelete();
            $table->string('name');
            $table->text('description');
            $table->string('logo')->nullable();
            $table->text('address');
            $table->string('iframe_url', 500);
            $table->json('open_hours');
            $table->json('services');
            $table->string('menu')->nullable(); 
            $table->json('media_social');
            $table->string('location')->nullable();
            $table->json('contact');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};

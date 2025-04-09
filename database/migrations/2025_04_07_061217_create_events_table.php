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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('place_name');
            $table->string('street_name');

            $table->timestamp('start_time')->useCurrent(); // default: now()
            $table->timestamp('end_time')->useCurrent();   // default: now()
            $table->string('date_events')->nullable(); 

            $table->string('type_events');
            $table->string('image_events');
            $table->text('desc');
            $table->json('contact_organizer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

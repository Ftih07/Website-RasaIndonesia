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
            //
            $table->text('description')->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->string('iframe_url', 500)->nullable()->change();
            $table->json('open_hours')->nullable()->change();
            $table->json('services')->nullable()->change();
            $table->json('media_social')->nullable()->change();
            $table->json('contact')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            //
            $table->text('description')->nullable(false)->change();
            $table->text('address')->nullable(false)->change();
            $table->string('iframe_url', 500)->nullable(false)->change();
            $table->json('open_hours')->nullable(false)->change();
            $table->json('services')->nullable(false)->change();
            $table->json('media_social')->nullable(false)->change();
            $table->json('contact')->nullable(false)->change();
        });
    }
};

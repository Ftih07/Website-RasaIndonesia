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
            $table->json('order')->nullable()->after('menu'); // Contoh kolom baru
            $table->json('reserve')->nullable()->after('order'); // Contoh kolom baru
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            //
            $table->dropColumn('order');
            $table->dropColumn('reserve');
        });
    }
};

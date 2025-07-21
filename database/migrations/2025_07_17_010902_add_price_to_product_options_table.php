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
        Schema::table('product_options', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0)->nullable()->after('name'); // Tambahan harga jika dipilih
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_options', function (Blueprint $table) {
            //
        });
    }
};

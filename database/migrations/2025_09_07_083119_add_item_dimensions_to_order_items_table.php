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
        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('weight_actual', 10, 2)->nullable()->after('quantity');     // kg per item
            $table->decimal('volume', 15, 2)->nullable()->after('weight_actual');            // cm³ per item
            $table->decimal('weight_volumetric', 10, 2)->nullable()->after('volume'); // kg per item
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('weight_actual', 'volume', 'weight_volumetric');
        });
    }
};

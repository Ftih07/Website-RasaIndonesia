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
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('total_weight_actual', 10, 2)->nullable()->after('tax');
            $table->decimal('total_volume', 15, 2)->nullable()->after('total_weight_actual');
            $table->decimal('total_weight_volumetric', 10, 2)->nullable()->after('total_volume');
            $table->decimal('chargeable_weight', 10, 2)->nullable()->after('total_weight_volumetric');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('total_weight_actual', 'total_volume', 'total_weight_volumetric', 'chargeable_weight');
        });
    }
};

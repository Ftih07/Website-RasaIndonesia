<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->enum('shipping_type', ['flat', 'per_km', 'flat_plus_per_km'])->default('flat')->after('address');
            $table->decimal('flat_rate', 8, 2)->default(0)->after('shipping_type');
            $table->decimal('per_km_rate', 8, 2)->default(0)->after('flat_rate');
            $table->decimal('per_km_unit', 8, 2)->default(1)->after('per_km_rate');
        });
    }

    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn(['shipping_type', 'flat_rate', 'per_km_rate', 'per_km_unit']);
        });
    }
};

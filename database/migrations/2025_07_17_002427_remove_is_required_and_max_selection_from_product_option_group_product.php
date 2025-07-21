<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_option_group_product', function (Blueprint $table) {
            $table->dropColumn(['is_required', 'max_selection']);
        });
    }

    public function down(): void
    {
        Schema::table('product_option_group_product', function (Blueprint $table) {
            $table->boolean('is_required')->default(false);
            $table->unsignedTinyInteger('max_selection')->default(1);
        });
    }
};

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
            Schema::create('product_option_group_product', function (Blueprint $table) {
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_option_groups_id')->constrained()->onDelete('cascade');
                $table->boolean('is_required')->default(false);
                $table->unsignedTinyInteger('max_selection')->default(1);
                $table->primary(['product_id', 'product_option_groups_id']);
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_option_group_product');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('shipping_lat', 10, 7)->nullable()->after('shipping_address');
            $table->decimal('shipping_lng', 10, 7)->nullable()->after('shipping_lat');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_lat', 'shipping_lng']);
        });
    }
};

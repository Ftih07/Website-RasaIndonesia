<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_status_mode_to_businesses.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->enum('status_mode', ['auto', 'manual_open', 'manual_closed'])
                ->default('auto')
                ->after('open_hours');
        });
    }

    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn('status_mode');
        });
    }
};

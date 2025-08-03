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
        Schema::table('participant_register_prosperity_expo', function (Blueprint $table) {
            //
            $table->boolean('email_sent')->default(false)->after('status'); // atau after kolom yang kamu mau
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participant_register_prosperity_expo', function (Blueprint $table) {
            //
            $table->dropColumn('email_sent');
        });
    }
};

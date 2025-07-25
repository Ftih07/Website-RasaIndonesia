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
        //
        Schema::table('participant_register_prosperity_expo', function (Blueprint $table) {
            $table->text('company_social_media_username')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('participant_register_prosperity_expo', function (Blueprint $table) {
            $table->string('company_social_media_username', 255)->nullable()->change();
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaKeywordsToNewsTable extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->text('meta_keywords')->nullable()->after('desc');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('meta_keywords');
        });
    }
}

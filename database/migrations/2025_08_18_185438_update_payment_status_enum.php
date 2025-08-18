<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Ubah enum status jadi include incomplete
        DB::statement("ALTER TABLE payments MODIFY status ENUM('incomplete', 'pending', 'paid', 'failed') DEFAULT 'incomplete'");
    }

    public function down(): void
    {
        // Balikin ke enum lama
        DB::statement("ALTER TABLE payments MODIFY status ENUM('pending', 'paid', 'failed') DEFAULT 'pending'");
    }
};

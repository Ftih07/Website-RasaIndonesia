<?php

// database/migrations/2025_08_15_000000_create_chats_and_messages_tables.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabel chats (room)
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->nullable()->constrained()->cascadeOnDelete(); // buat identitas logo/nama dari bisnis
            $table->foreignId('user_one_id')->constrained('users')->cascadeOnDelete(); // misalnya customer
            $table->foreignId('user_two_id')->constrained('users')->cascadeOnDelete(); // misalnya seller/superadmin
            $table->timestamps();
        });

        // Tabel messages (isi chat)
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->text('message')->nullable();
            $table->string('image_path')->nullable(); // upload gambar
            $table->enum('type', ['text', 'image', 'system'])->default('text'); // system buat notifikasi otomatis
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
        Schema::dropIfExists('chats');
    }
};

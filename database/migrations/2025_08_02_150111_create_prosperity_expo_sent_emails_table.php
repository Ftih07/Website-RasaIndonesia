<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prosperity_expo_sent_emails', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_name')->nullable();
            $table->string('email');
            $table->string('company_brand')->nullable();
            $table->string('participant_type')->nullable();
            $table->string('link')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prosperity_expo_sent_emails');
    }
};

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
        // Creates the qn_a_s table
        Schema::create('qn_a_s', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('question'); // Question field
            $table->string('answer'); // Answer field
            $table->timestamps(); // Created at & Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qn_a_s');
    }
};

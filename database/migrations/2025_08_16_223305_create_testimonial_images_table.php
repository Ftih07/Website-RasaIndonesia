<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonial_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('testimonial_id')->constrained()->cascadeOnDelete();
            $table->string('image_path'); // path gambar
            $table->timestamps();
        });

        // Optional: hapus kolom image_url_product dari testimonials kalau ga dipakai lagi
        Schema::table('testimonials', function (Blueprint $table) {
            if (Schema::hasColumn('testimonials', 'image_url_product')) {
                $table->dropColumn('image_url_product');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonial_images');

        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('image_url_product')->nullable();
        });
    }
};

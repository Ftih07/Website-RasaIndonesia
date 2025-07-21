<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Ubah struktur tabel users
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'profile_image')) {
                $table->string('profile_image')->nullable()->after('remember_token');
            }

            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('profile_image');
            }
        });

        // Ubah struktur testimonial: tambah kolom user_id dan image_url_product
        if (!Schema::hasColumn('testimonials', 'user_id') || !Schema::hasColumn('testimonials', 'image_url_product')) {
            Schema::table('testimonials', function (Blueprint $table) {
                if (!Schema::hasColumn('testimonials', 'user_id')) {
                    $table->foreignId('user_id')
                        ->nullable()
                        ->after('testimonial_user_id')
                        ->constrained('users'); // default references 'id' on 'users'
                }

                if (!Schema::hasColumn('testimonials', 'image_url_product')) {
                    $table->string('image_url_product')->nullable()->after('image_url');
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['profile_image', 'address', 'is_admin']);
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'image_url_product']);
        });
    }
};

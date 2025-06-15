<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * This migration handles adding and removing soft delete functionality
 * for the 'qn_a_s' table in the database.
 *
 * Soft deletes allow records to be "deleted" without actually removing them
 * from the database. Instead, a 'deleted_at' timestamp is set, indicating
 * when the record was soft-deleted. This is useful for retaining data
 * for auditing, recovery, or historical purposes.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This 'up' method is executed when you run the migration (e.g., `php artisan migrate`).
     * It's used to add new tables, columns, or indexes to your database schema.
     * In this specific migration, it adds the 'deleted_at' column for soft deletes.
     */
    public function up(): void
    {
        // Modify the 'qn_a_s' table.
        Schema::table('qn_a_s', function (Blueprint $table) {
            // Add the 'deleted_at' timestamp column to the 'qn_a_s' table.
            // This column is automatically managed by Laravel's Eloquent ORM
            // when the `SoftDeletes` trait is used on the corresponding Event model.
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * This 'down' method is executed when you roll back the migration (e.g., `php artisan migrate:rollback`).
     * It should reverse the operations performed in the 'up' method,
     * ensuring that the database can be returned to its previous state.
     * Here, it removes the 'deleted_at' column.
     */
    public function down(): void
    {
        // Modify the 'qn_a_s' table to revert changes.
        Schema::table('qn_a_s', function (Blueprint $table) {
            // Remove the 'deleted_at' column from the 'qn_a_s' table.
            // This effectively disables soft deletes for this table.
            $table->dropSoftDeletes();
        });
    }
};

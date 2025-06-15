<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * This migration handles adding and removing soft delete functionality
 * for the 'businesses' table in the database.
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
     * This 'up' method is executed when the migration is run.
     * It's used to add new tables, columns, or indexes to your database.
     */
    public function up(): void
    {
        // Modify the 'businesses' table to add soft deletes.
        // Soft deletes allow records to be "deleted" without actually removing them from the database.
        // Instead, a 'deleted_at' timestamp is set, indicating when the record was soft-deleted.
        Schema::table('businesses', function (Blueprint $table) {
            // Adds the 'deleted_at' timestamp column to the 'businesses' table.
            // This column is automatically managed by Laravel's Eloquent ORM
            // when the `SoftDeletes` trait is used on the corresponding model.
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     * This 'down' method is executed when the migration is rolled back.
     * It should reverse the operations performed in the 'up' method,
     * ensuring that the database can be returned to its previous state.
     */
    public function down(): void
    {
        // Revert the changes made in the 'up' method.
        // This drops the 'deleted_at' column from the 'businesses' table,
        // effectively disabling soft deletes for this table.
        Schema::table('businesses', function (Blueprint $table) {
            // Removes the 'deleted_at' column from the 'businesses' table.
            $table->dropSoftDeletes();
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration; // Import the base Migration class.
use Illuminate\Database\Schema\Blueprint;    // Import Blueprint for defining table structure.
use Illuminate\Support\Facades\Schema;       // Import Schema facade for database schema manipulation.

/**
 * CreateTrafficLogsTable
 *
 * This is a Laravel database migration class responsible for creating and dropping
 * the `traffic_logs` table. This table is designed to store basic information
 * about website traffic or user visits, such as IP address, URL visited, and user agent.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     * This method is executed when the migration is run (e.g., `php artisan migrate`).
     * It defines the schema for the `traffic_logs` table.
     *
     * @return void
     */
    public function up(): void
    {
        // Use the Schema facade to create a new table named 'traffic_logs'.
        Schema::create('traffic_logs', function (Blueprint $table) {
            // Define an auto-incrementing primary key column named 'id'.
            $table->id();

            // Define a string column for storing the IP address of the visitor.
            // It is nullable, meaning it can be empty.
            $table->string('ip_address')->nullable();

            // Define a string column for storing the URL that was visited.
            // It is nullable.
            $table->string('url')->nullable();

            // Define a string column for storing the user agent string (browser/OS info).
            // It is nullable.
            $table->string('user_agent')->nullable();

            // Adds `created_at` and `updated_at` timestamp columns.
            // These columns are automatically managed by Eloquent for record creation and update times.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * This method is executed when the migration is rolled back (e.g., `php artisan migrate:rollback`).
     * It defines the actions to undo the `up` method, typically dropping the table.
     *
     * @return void
     */
    public function down(): void
    {
        // Use the Schema facade to drop the 'traffic_logs' table if it exists.
        Schema::dropIfExists('traffic_logs');
    }
};

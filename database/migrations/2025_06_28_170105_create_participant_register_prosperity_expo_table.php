<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// This class defines a database migration.
// Migrations are like version control for your database, allowing you to easily
// modify and share the database schema of your application.
return new class extends Migration
{
    /**
     * The `up` method is executed when the migration is run.
     * It's used to create tables, add columns, or make other database changes.
     */
    public function up(): void
    {
        // Create a new table named 'participant_register_prosperity_expo'.
        // This table will store information about participants who register for the Prosperity Expo.
        Schema::create('participant_register_prosperity_expo', function (Blueprint $table) {
            // Adds an auto-incrementing primary key column named 'id'.
            // This will uniquely identify each participant record.
            $table->id();

            // Adds a string column for the participant's full name.
            $table->string('name');

            // Adds a string column for the participant's email address.
            // The `unique()` constraint ensures that no two participants can have the same email.
            $table->string('email')->unique();

            // Adds a string column for the name of the participant's company.
            $table->string('company_name');

            // Adds a string column for the participant's position within their company.
            $table->string('position');

            // Adds a string column for the participant's contact number or information.
            $table->string('contact');

            // Adds a string column to specify the type of participant (e.g., 'exhibitor', 'visitor').
            $table->string('participant_type');

            // Adds a string column to specify the type of company (e.g., 'tech', 'manufacturing').
            $table->string('company_type');

            // Adds a long text column for a detailed description of the company's product.
            $table->text('product_description');

            // Adds a string column for the company's social media username.
            // `nullable()` means this field is optional and can be empty.
            $table->string('company_social_media_username')->nullable();

            // Adds a string column for a link or reference to the company's profile.
            // `nullable()` means this field is optional.
            $table->string('company_profile')->nullable();

            // Adds a UUID (Universally Unique Identifier) column for a QR code.
            // `unique()` ensures each QR code is distinct.
            // `nullable()` means this field is optional and can be added later.
            $table->uuid('qr_code')->unique()->nullable();

            // Adds an enum column for the participant's status.
            // It can only be 'present', 'not_found', or `null`.
            // `default(null)` sets the initial value to null if not specified.
            $table->enum('status', ['present', 'not_found', null])->nullable()->default(null);

            // Adds `created_at` and `updated_at` timestamp columns.
            // Laravel automatically manages these columns, storing when a record was
            // created and last updated.
            $table->timestamps();
        });
    }

    /**
     * The `down` method is executed when the migration is rolled back.
     * It's used to reverse the changes made in the `up` method, typically by dropping tables.
     */
    public function down(): void
    {
        // Drops (deletes) the 'participant_register_prosperity_expo' table if it exists.
        // This is used to undo the table creation if the migration is rolled back.
        Schema::dropIfExists('participant_register_prosperity_expo');
    }
};

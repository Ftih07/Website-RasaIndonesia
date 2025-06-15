<?php

namespace App\Models; // Defines the namespace for the QnA model, organizing it within the application's models.

use Illuminate\Database\Eloquent\Factories\HasFactory; // Imports the `HasFactory` trait, enabling the use of model factories for seeding and testing.
use Illuminate\Database\Eloquent\Model; // Imports the base Eloquent `Model` class, from which all Laravel models extend.
use Illuminate\Database\Eloquent\SoftDeletes; // Imports the `SoftDeletes` trait, which provides soft deletion capabilities to the model.

/**
 * Class QnA
 *
 * This Eloquent Model represents the 'q_n_a' table in the database.
 * It's designed to store Frequently Asked Questions (FAQs), where each record
 * consists of a question and its corresponding answer.
 * The model utilizes soft deletes, allowing records to be "deleted" without
 * being permanently removed from the database, and supports model factories
 * for easy data generation.
 */
class QnA extends Model
{
    // Use the SoftDeletes trait.
    // This enables the "soft delete" feature for this model. Instead of permanently
    // removing a record from the database, it sets a timestamp in the 'deleted_at' column.
    // This allows for easy restoration of records and maintaining historical data.
    use SoftDeletes;

    // Use the HasFactory trait.
    // This trait provides a convenient way to generate new model instances for testing
    // and database seeding purposes using model factories. It simplifies the creation
    // of dummy data for development environments.
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * This property specifies which attributes of the model can be set via mass assignment.
     * Mass assignment is a feature in Laravel that allows you to fill multiple model attributes
     * using an array. By explicitly listing fields here, Laravel protects against
     * unintended attribute modifications (mass assignment vulnerabilities).
     *
     * @var array
     */
    protected $fillable = [
        'question', // The text of the question.
        'answer'    // The text of the answer corresponding to the question.
    ];
}

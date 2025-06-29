<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// This class defines an Eloquent Model for the 'participant_register_prosperity_expo' table.
// In Laravel, Models are used to interact with your database tables.
// Each Model typically corresponds to a single database table.
class ParticipantRegisterProsperityExpo extends Model
{
    // The `HasFactory` trait allows you to create fake model instances for testing and seeding.
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * By default, Laravel assumes the table name is the plural form of the model name
     * (e.g., 'ParticipantRegisterProsperityExpo' would map to 'participant_register_prosperity_expos').
     * We explicitly define `protected $table` here because our table name
     * 'participant_register_prosperity_expo' does not follow Laravel's default pluralization convention.
     *
     * @var string
     */
    protected $table = 'participant_register_prosperity_expo';

    /**
     * The attributes that are mass assignable.
     *
     * The `protected $fillable` array specifies which attributes can be mass-assigned.
     * Mass assignment is a convenient way to create or update multiple records at once
     * using an array of data. Any attributes not listed here will be protected from
     * mass assignment for security reasons (to prevent unexpected data changes).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'company_name',
        'position',
        'contact',
        'participant_type',
        'company_type',
        'product_description',
        'company_social_media_username',
        'company_profile',
        'qr_code',
        'status',
    ];

    // You can define relationships (e.g., hasMany, belongsTo) or other methods here
    // to add more functionality to your model, like fetching related data or
    // custom logic for participants.
}

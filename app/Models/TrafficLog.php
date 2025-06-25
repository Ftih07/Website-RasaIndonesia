<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // Import the base Eloquent Model class.

/**
 * TrafficLog
 *
 * This Eloquent Model represents the `traffic_logs` table in the database.
 * It provides an object-oriented way to interact with the traffic log records,
 * allowing you to retrieve, insert, and update data related to website visits.
 */
class TrafficLog extends Model
{
    /**
     * The table associated with the model.
     * By default, Eloquent assumes the table name is the plural form of the model name.
     * In this case, 'traffic_logs' matches the default convention for 'TrafficLog'.
     *
     * @var string
     */
    protected $table = 'traffic_logs';

    /**
     * The attributes that are mass assignable.
     * This array specifies which columns can be filled using mass assignment (e.g., `TrafficLog::create($data)`).
     * This is a security feature in Laravel to prevent unintended mass assignment vulnerabilities.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ip_address', // Allows mass assignment for the 'ip_address' column.
        'url',        // Allows mass assignment for the 'url' column.
        'user_agent', // Allows mass assignment for the 'user_agent' column.
    ];

    /**
     * The attributes that should be cast.
     * This array defines type casting for model attributes.
     * For example, dates can be cast to Carbon instances, or JSON strings to arrays.
     * In this model, the default 'created_at' and 'updated_at' timestamps are
     * automatically cast to Carbon instances by Eloquent. No custom casts are needed here.
     *
     * @var array<string, string>
     */
    // protected $casts = []; // Uncomment and use if custom casting is required.

    /**
     * Indicates if the model should be timestamped.
     * By default, Eloquent will automatically maintain `created_at` and `updated_at` columns.
     * Since the `traffic_logs` migration includes these columns, we leave this as default `true`.
     * If these columns were not present in the table, you would set this to `false`.
     *
     * @var bool
     */
    // public $timestamps = true; // This is the default behavior, no need to explicitly set unless overriding.

    // --- Relationships (if any) ---
    // You would define relationships here if TrafficLog was related to other models,
    // for example:
    /*
    public function user()
    {
        // Example: If a traffic log could be associated with a registered user.
        return $this->belongsTo(User::class);
    }
    */
}

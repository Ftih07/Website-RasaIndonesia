<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // Base Eloquent Model class.
use Illuminate\Support\Carbon; // Carbon library for date and time manipulation.
use Illuminate\Support\Str; // Facade for string manipulation, used here for slug generation.
use Illuminate\Database\Eloquent\SoftDeletes; // Trait to enable soft deletion functionality.

/**
 * Class Events
 *
 * This Eloquent Model represents the 'events' table in the database.
 * It provides a structured way to interact with event records,
 * including defining relationships, handling data types, and
 * implementing automatic slug generation and soft deletion.
 */
class Events extends Model
{
    // Use the SoftDeletes trait to enable soft deleting records.
    // This means instead of permanent deletion, records will have their 'deleted_at'
    // timestamp set, allowing for easy restoration and historical data retention.
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * These fields can be safely filled via mass assignment (e.g., `Events::create([...])` or `->fill([...])->save()`).
     * It's a security feature in Laravel to prevent unintended attribute modifications.
     * Add any database column that you want to be mass assignable here.
     *
     * @var array
     */
    protected $fillable = [
        'title',             // The title of the event.
        'place_name',        // The name of the venue or place where the event is held.
        'street_name',       // The street address of the event location.
        'date_events',       // Optional display field for event date (actual dates handled by start/end_time).
        'type_events',       // The type or category of the event (e.g., concert, workshop).
        'image_events',      // Path or URL to the event's promotional image.
        'desc',              // A detailed description of the event.
        'meta_keywords',     // 
        'contact_organizer', // Contact information for the event organizer.
        'iframe',            // URL for an embedded iframe (e.g., Google Maps, video).
        'start_time',        // The official start date and time of the event.
        'end_time',          // The official end date and time of the event.
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * This property defines how certain attributes should be converted when they are retrieved from
     * or set on the model. For example, 'array' means the attribute will be automatically
     * JSON encoded/decoded, and 'datetime' means it will be converted to a Carbon instance.
     *
     * @var array
     */
    protected $casts = [
        'contact_organizer' => 'array',    // Casts 'contact_organizer' JSON string to a PHP array.
        'start_time'        => 'datetime', // Casts 'start_time' to a Carbon datetime object.
        'end_time'          => 'datetime', // Casts 'end_time' to a Carbon datetime object.
    ];

    /**
     * Accessor for 'date_events' attribute.
     *
     * This "Accessor" automatically formats and returns a human-readable string
     * representing the event's start and end times whenever `$event->date_events` is accessed.
     * It leverages the Carbon instances from `start_time` and `end_time`.
     *
     * @return string
     */
    public function getDateEventsAttribute(): string
    {
        // Formats the start time to include day of the week, date, month, and time.
        // E.g., "Monday 1 January from 9AM"
        $startTimeFormatted = $this->start_time?->format('l j F \f\r\o\m gA');

        // Formats the end time to display just the time.
        // E.g., "to 5PM"
        $endTimeFormatted = $this->end_time?->format('gA');

        // Concatenates the formatted start and end times.
        return $startTimeFormatted . ' to ' . $endTimeFormatted;
    }

    /**
     * The "boot" method of the model.
     *
     * This method is called once when the model is initialized. It's a good place to
     * register global scopes, event listeners, or other one-time setup tasks for the model.
     * In this case, it's used to automatically generate a slug for the event.
     */
    protected static function boot(): void
    {
        parent::boot(); // Call the parent boot method.

        // Register an event listener for when an Events model is being created (inserted for the first time).
        static::creating(function ($event) {
            // Generates a URL-friendly slug from the event's title.
            // Slugs are typically used in URLs for better readability and SEO.
            $event->slug = Str::slug($event->title);
        });

        // Register an event listener for when an Events model is being updated.
        static::updating(function ($event) {
            // Regenerates the slug from the event's title whenever the event is updated.
            // This ensures the slug stays in sync if the title changes.
            $event->slug = Str::slug($event->title);
        });
    }
}

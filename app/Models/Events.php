<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Events extends Model
{
    protected $fillable = [
        'title',
        'place_name',
        'street_name',
        'date_events',        // optional display
        'type_events',
        'image_events',
        'desc',
        'contact_organizer',
        'iframe',
        'start_time',         // new
        'end_time',           // new
    ];

    protected $casts = [
        'contact_organizer' => 'array',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Accessor untuk string readable
    public function getDateEventsAttribute()
    {
        return $this->start_time?->format('l j F \f\r\o\m gA') . ' to ' . $this->end_time?->format('gA');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            $event->slug = Str::slug($event->title);
        });

        static::updating(function ($event) {
            $event->slug = Str::slug($event->title);
        });
    }
}

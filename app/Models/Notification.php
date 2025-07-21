<?php

// app/Models/Notification.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'image',
        'url',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

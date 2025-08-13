<?php

// app/Models/MessageImage.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageImage extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'message_id', 'image_url'];

    public function message() { return $this->belongsTo(Message::class); }
}

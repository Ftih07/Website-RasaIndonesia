<?php

// app/Models/Message.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'from_user_id', 'to_user_id', 'order_id', 'message', 'is_read'];

    public function images() { return $this->hasMany(MessageImage::class); }
}

<?php
// app/Models/Message.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'chat_id',
        'sender_id',
        'message',
        'image_path',
        'type',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // app/Models/Message.php
    protected static function booted()
    {
        static::created(function (Message $message) {
            // update updated_at chat agar sidebar ke-urut paling baru
            \App\Models\Chat::whereKey($message->chat_id)->update(['updated_at' => now()]);
        });
    }
}

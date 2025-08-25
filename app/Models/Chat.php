<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Chat extends Model
{
    protected $fillable = [
        'business_id',
        'user_one_id',
        'user_two_id',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function userOne(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    // Ambil pesan terakhir (buat sidebar)
    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    // Unread count untuk user tertentu
    public function unreadCountFor($userId): int
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->count();
    }

    public function unreadMessages()
    {
        return $this->messages()
            ->where('is_read', false)
            ->where('sender_id', '!=', auth()->id()); // hanya pesan yg bukan dari user login
    }

    public function getUnreadCountAttribute()
    {
        return $this->unreadMessages()->count();
    }

    public function getLatestMessageTextAttribute(): ?string
    {
        return $this->latestMessage?->message
            ? \Illuminate\Support\Str::limit($this->latestMessage->message, 30) // batasi biar pendek
            : null;
    }
}

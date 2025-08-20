<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\Message;

class ChatService
{
    protected static $defaultSuperadminId = 2;

    public static function getOrCreateChat($userOneId, $userTwoId = null, $businessId = null)
    {
        if (!$userTwoId) {
            $userTwoId = self::$defaultSuperadminId;
        }

        return Chat::firstOrCreate([
            'user_one_id' => $userOneId,
            'user_two_id' => $userTwoId,
            'business_id' => $businessId,
        ]);
    }

    public static function sendMessage($chatId, $senderId, $message, $type = 'text', $imagePath = null)
    {
        $msg = Message::create([
            'chat_id'    => $chatId,
            'sender_id'  => $senderId,
            'message'    => $message,
            'type'       => $type,
            'image_path' => $imagePath,
            'is_read'    => false,
        ]);

        // update updated_at supaya chat naik ke atas
        Chat::where('id', $chatId)->update(['updated_at' => now()]);

        return $msg;
    }

    public static function markAsRead($chatId, $userId)
    {
        Message::where('chat_id', $chatId)
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }
}

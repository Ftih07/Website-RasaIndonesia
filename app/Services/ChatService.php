<?php

// app/Services/ChatService.php
namespace App\Services;

use App\Models\Chat;
use App\Models\Message;

class ChatService
{
    protected static $defaultSuperadminId = 2; // ID superadmin kamu

    public static function getOrCreateChat($userOneId, $userTwoId = null, $businessId = null)
    {
        if (!$userTwoId) {
            $userTwoId = self::$defaultSuperadminId;
        }

        return Chat::firstOrCreate(
            [
                'user_one_id' => $userOneId,
                'user_two_id' => $userTwoId,
                'business_id' => $businessId,
            ]
        );
    }

    public static function sendMessage($chatId, $senderId, $message, $type = 'text', $imagePath = null)
    {
        return Message::create([
            'chat_id'    => $chatId,
            'sender_id'  => $senderId,
            'message'    => $message,
            'type'       => $type,
            'image_path' => $imagePath,
        ]);
    }
}

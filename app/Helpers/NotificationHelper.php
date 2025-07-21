<?php
// app/Helpers/NotificationHelper.php
namespace App\Helpers;

use App\Models\Notification;

class NotificationHelper
{
    public static function send($userId, $title, $message, $url = null, $image = null)
    {
        Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'url' => $url,
            'image' => $image,
        ]);
    }
}

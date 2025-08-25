<?php

namespace App\Filament\Widgets;

use App\Models\Chat;
use App\Models\Message;
use Filament\Widgets\Widget;
use Livewire\WithFileUploads;

class ChatMessagesWidget extends Widget
{
    use WithFileUploads;

    protected static bool $isDiscovered = false; // ⬅️ biar ga tampil di dashboard

    protected static string $view = 'filament.widgets.chat-messages-widget';

    public ?Chat $record = null;

    public $message = '';
    public $image;

    public function send()
    {
        $this->validate([
            'message' => 'nullable|string|max:1000',
            'image'   => 'nullable|image|max:2048',
        ]);

        $imagePath = $this->image ? $this->image->store('chat-images', 'public') : null;

        Message::create([
            'chat_id'    => $this->record->id,
            'sender_id'  => auth()->id(),
            'message'    => $this->message,
            'image_path' => $imagePath,
            'type'       => $imagePath ? 'image' : 'text',
        ]);

        $this->reset(['message', 'image']);
    }
    public function getMessagesProperty()
    {
        $messages = Message::where('chat_id', $this->record->id)
            ->with('sender')
            ->oldest()
            ->get();

        // tandai sebagai read
        Message::where('chat_id', $this->record->id)
            ->where('is_read', false)
            ->where('sender_id', '!=', auth()->id())
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return $messages;
    }
}

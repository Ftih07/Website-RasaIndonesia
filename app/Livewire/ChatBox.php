<?php

// app/Livewire/ChatBox.php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Chat;
use App\Services\ChatService;

class ChatBox extends Component
{
    use WithFileUploads;

    public int $chatId;
    public ?string $message = null;
    public $image; // Livewire temp upload

    protected $rules = [
        'message' => 'nullable|string',
        'image'   => 'nullable|image|max:2048',
    ];

    public function mount(int $chatId)
    {
        $this->chatId = $chatId;

        $chat = Chat::findOrFail($chatId);
        abort_unless(in_array(auth()->id(), [$chat->user_one_id, $chat->user_two_id]), 403);
    }

    public function send()
    {
        $this->validate();

        $imagePath = $this->image
            ? $this->image->store('chat_images', 'public')
            : null;

        ChatService::sendMessage(
            $this->chatId,
            auth()->id(),
            $this->message,
            $imagePath ? 'image' : ($this->message ? 'text' : 'system'),
            $imagePath
        );

        // reset form
        $this->reset(['message', 'image']);

        // agar container scroll ke bawah
        $this->dispatch('chat:scroll-bottom');
    }

    public function getMessagesProperty()
    {
        return Chat::find($this->chatId)
            ?->messages()
            ->with('sender:id,name')
            ->oldest()
            ->get() ?? collect();
    }

    public function render()
    {
        // wire:poll.* di view akan tarik ulang render setiap interval
        return view('livewire.chat-box', [
            'messages' => $this->messages,
        ]);
    }
}

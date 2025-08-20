<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use App\Livewire\ChatBox;
use Livewire\Attributes\Url;

class ChatSidebar extends Component
{
    #[Url] // <-- ini bikin state selectedChatId nyantol di query string
    public $selectedChatId;

    protected $listeners = [
        'chat:sent' => '$refresh',
        'chat:selected' => 'selectChat',
    ];

    public function mount($selectedChatId = null)
    {
        $this->selectedChatId = $selectedChatId;
    }

    public function selectChat($chatId)
    {
        $this->selectedChatId = $chatId;

        // kirim event ke ChatBox
        $this->dispatch('chat:switch', chatId: $chatId)->to(ChatBox::class);
    }

    public function getChatsProperty()
    {
        $userId = Auth::id();

        return Chat::with(['userOne:id,name', 'userTwo:id,name', 'messages'])
            ->where(function ($q) use ($userId) {
                $q->where('user_one_id', $userId)
                    ->orWhere('user_two_id', $userId);
            })
            ->latest('updated_at')
            ->get()
            ->map(function ($chat) use ($userId) {
                $chat->latestMessage = $chat->messages->last();
                $chat->unread_count = $chat->messages
                    ->where('sender_id', '!=', $userId)
                    ->where('is_read', false)
                    ->count();
                return $chat;
            });
    }

    public function render()
    {
        return view('livewire.chat-sidebar', [
            'chats' => $this->chats,
        ]);
    }
}

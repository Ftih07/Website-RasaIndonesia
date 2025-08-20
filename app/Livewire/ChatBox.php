<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On; // <— tambahin ini
use App\Models\Chat;
use App\Services\ChatService;

class ChatBox extends Component
{
    use WithFileUploads;

    public int $chatId;
    public ?string $message = null;
    public $image;

    protected $rules = [
        'message' => 'nullable|string',
        'image'   => 'nullable|image|max:2048',
    ];

    public function getPartnerProperty()
{
    $chat = Chat::with(['userOne:id,name', 'userTwo:id,name'])
        ->find($this->chatId);

    if (! $chat) {
        return null;
    }

    return $chat->user_one_id === auth()->id()
        ? $chat->userTwo
        : $chat->userOne;
}


    public function insertQuickMessage($message)
    {
        $this->message = $message;
        // Tidak perlu $this->send(); karena hanya memasukkan ke input
    }

    public function mount(int $chatId)
    {
        $this->switchChat($chatId); // langsung pake method switchChat biar DRY
    }

    #[On('chat:switch')]
    public function switchChat(int $chatId)
    {
        $this->chatId = $chatId;

        $chat = Chat::findOrFail($chatId);
        abort_unless(in_array(auth()->id(), [$chat->user_one_id, $chat->user_two_id]), 403);

        // reset input
        $this->reset(['message', 'image']);

        // tandai pesan dibaca
        ChatService::markAsRead($chatId, auth()->id());

        // biar scroll otomatis
        $this->dispatch('chat:scroll-bottom');
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

        $this->reset(['message', 'image']);
        $this->dispatch('chat:scroll-bottom');

        // 🚀 trigger refresh sidebar
        $this->dispatch('chat:sent');
    }

    public function getMessagesProperty()
    {
        $chat = Chat::with('messages.sender')->find($this->chatId);
        if ($chat) {
            ChatService::markAsRead($chat->id, auth()->id());
        }

        return $chat?->messages()->with('sender:id,name')->oldest()->get() ?? collect();
    }

public function render()
{
    return view('livewire.chat-box', [
        'messages' => $this->messages,
        'partner'  => $this->partner,
    ]);
}

}

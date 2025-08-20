<?php
// app/Http/Controllers/ChatController.php
namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function customerIndex(Request $request)
    {
        return $this->renderChatPage($request);
    }
    public function sellerIndex(Request $request)
    {
        return $this->renderChatPage($request);
    }
    public function partnerIndex(Request $request)
    {
        return $this->renderChatPage($request);
    }

    private function markMessagesAsRead(int $chatId, int $userId): void
    {
        Message::where('chat_id', $chatId)
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->update(['is_read' => true, 'read_at' => now()]);
    }

    private function renderChatPage(Request $request)
    {
        $userId = auth()->id();

        // Eager: partner, latestMessage, unread_count; urut dari paling baru aktif
        $chats = Chat::where(function ($q) use ($userId) {
            $q->where('user_one_id', $userId)->orWhere('user_two_id', $userId);
        })
            ->with(['userOne:id,name', 'userTwo:id,name', 'latestMessage'])
            ->withCount(['messages as unread_count' => function ($q) use ($userId) {
                $q->where('sender_id', '!=', $userId)->whereNull('read_at');
            }])
            ->latest('updated_at')
            ->get();

        $selectedChat = null;
        if ($request->filled('chat_id')) $selectedChat = $chats->firstWhere('id', (int)$request->chat_id);
        if (!$selectedChat) $selectedChat = $chats->first();

        if ($selectedChat) $this->markMessagesAsRead($selectedChat->id, $userId);

        $messages = $selectedChat
            ? $selectedChat->messages()->with('sender:id,name')->oldest()->get()
            : collect();

        return view('chat.index', compact('chats', 'selectedChat', 'messages'));
    }

    public function send(Request $request, Chat $chat)
    {
        abort_unless(in_array(auth()->id(), [$chat->user_one_id, $chat->user_two_id]), 403);

        $validated = $request->validate([
            'message' => 'nullable|string',
            'image'   => 'nullable|image|max:2048',
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('chat_images', 'public')
            : null;

        ChatService::sendMessage(
            $chat->id,
            auth()->id(),
            $validated['message'] ?? null,
            $imagePath ? 'image' : ($validated['message'] ? 'text' : 'system'),
            $imagePath
        );

        $chat->touch(); // jaga-jaga kalau booted() ke-skip

        // Kalau dipanggil dari AJAX/Livewire bisa balikin JSON
        if ($request->wantsJson()) return response()->json(['ok' => true]);

        return back();
    }
}

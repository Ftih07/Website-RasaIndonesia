<?php

// app/Http/Controllers/ChatController.php
namespace App\Http\Controllers;

use App\Models\Chat;
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

    private function renderChatPage(Request $request)
    {
        $userId = auth()->id();

        $chats = Chat::where(function ($q) use ($userId) {
            $q->where('user_one_id', $userId)->orWhere('user_two_id', $userId);
        })
            ->with(['userOne:id,name', 'userTwo:id,name'])
            ->latest('updated_at')
            ->get();

        // pilih chat berdasarkan query ?chat_id=xx atau ambil pertama
        $selectedChat = null;
        if ($request->filled('chat_id')) {
            $selectedChat = $chats->firstWhere('id', (int) $request->chat_id);
        }
        if (!$selectedChat) {
            $selectedChat = $chats->first();
        }

        $messages = $selectedChat
            ? $selectedChat->messages()->with('sender:id,name')->oldest()->get()
            : collect();

        return view('chat.index', compact('chats', 'selectedChat', 'messages'));
    }

    public function send(Request $request, Chat $chat)
    {
        // pastikan user memang bagian dari chat-nya
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

        // update updated_at chat biar naik ke atas
        $chat->touch();

        return back();
    }
}

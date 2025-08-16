@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-4">
    <h2 class="text-lg font-bold mb-4">Chat</h2>

    <div class="border rounded-lg h-[500px] flex">

        {{-- Sidebar daftar chat --}}
        <div class="w-64 border-r overflow-y-auto">
            @forelse($chats as $c)
                @php
                    $partner = $c->user_one_id === auth()->id() ? $c->userTwo : $c->userOne;
                @endphp
                <a href="{{ route(Route::currentRouteName(), ['chat_id' => $c->id]) }}"
                   class="block p-3 hover:bg-gray-100 {{ $selectedChat && $selectedChat->id === $c->id ? 'bg-gray-200' : '' }}">
                    <div class="font-semibold">{{ $partner->name ?? 'Unknown' }}</div>
                    <div class="text-xs text-gray-500 truncate">
                        {{ optional($c->messages()->latest()->first())->message ?? '—' }}
                    </div>
                </a>
            @empty
                <div class="p-3 text-sm text-gray-500">Belum ada chat.</div>
            @endforelse
        </div>

        {{-- Chat area --}}
        <div class="flex-1 flex flex-col">
            @if($selectedChat)
                {{-- === Livewire real-time chat box === --}}
                @livewire('chat-box', ['chatId' => $selectedChat->id])

            @else
                <div class="flex-1 flex items-center justify-center text-gray-500">
                    Pilih chat untuk mulai percakapan
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

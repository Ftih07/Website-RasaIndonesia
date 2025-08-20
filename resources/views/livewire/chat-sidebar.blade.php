{{-- resources\views\livewire\chat-sidebar.blade.php --}}
<div wire:poll.2s.keep-alive class="h-100 overflow-auto" style="scrollbar-width: thin; scrollbar-color: #f59e0b transparent;">
    <div class="p-3">
    </div>

    {{-- Chat List --}}
    <div class="px-2">
        @forelse($chats as $c)
        @php
        $partner = $c->user_one_id === auth()->id() ? $c->userTwo : $c->userOne;
        $isSelected = $selectedChatId == $c->id;
        @endphp

        <div wire:key="chat-{{ $c->id }}"
            wire:click="selectChat({{ $c->id }})"
            class="chat-item cursor-pointer rounded-3xl mb-2 p-3 transition-all duration-300 {{ $isSelected ? 'bg-white bg-opacity-25 shadow-lg transform scale-105' : 'hover:bg-white hover:bg-opacity-10' }}"
            style="backdrop-filter: blur(5px); border: 1px solid rgba(255,255,255,0.1);">

            <div class="d-flex align-items-center">
                {{-- Avatar --}}
                <div class="position-relative me-3 flex-shrink-0">
                    <div class="bg-gradient-to-br from-white to-orange-100 rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                        style="width: 50px; height: 50px;">
                        <i class="fas fa-user text-orange-500 fs-5"></i>
                    </div>
                    {{-- Online Status --}}
                    <div class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-2 border-white"
                        style="width: 14px; height: 14px;"></div>

                    {{-- Unread Badge --}}
                    @if($c->unread_count > 0)
                    <div class="position-absolute top-0 start-0 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm animate-pulse"
                        style="width: 20px; height: 20px; font-size: 0.7rem; margin-top: -5px; margin-left: -5px;">
                        {{ $c->unread_count > 9 ? '9+' : $c->unread_count }}
                    </div>
                    @endif
                </div>

                {{-- Chat Info --}}
                <div class="flex-grow-1 min-w-0">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <h6 class="mb-0 fw-bold {{ $isSelected ? 'text-white' : 'text-white text-opacity-90' }} truncate"
                            style="font-size: 0.95rem;">
                            {{ $partner->name ?? 'Unknown User' }}
                        </h6>

                        @if($c->latestMessage)
                        <small class="{{ $isSelected ? 'text-white text-opacity-75' : 'text-orange-100' }}"
                            style="font-size: 0.75rem;">
                            {{ $c->latestMessage->created_at->format('H:i') }}
                        </small>
                        @endif
                    </div>

                    {{-- Last Message Preview --}}
                    <div class="d-flex align-items-center">
                        @if($c->latestMessage)
                        @if($c->latestMessage->type === 'image')
                        <i class="fas fa-camera me-2 {{ $isSelected ? 'text-white text-opacity-60' : 'text-orange-200' }}" style="font-size: 0.8rem;"></i>
                        <span class="{{ $isSelected ? 'text-white text-opacity-75' : 'text-orange-100' }} truncate" style="font-size: 0.85rem;">
                            Photo shared
                        </span>
                        @else
                        <span class="{{ $isSelected ? 'text-white text-opacity-75' : 'text-orange-100' }} truncate" style="font-size: 0.85rem;">
                            {{ \Illuminate\Support\Str::limit($c->latestMessage->message, 30) }}
                        </span>
                        @endif
                        @else
                        <span class="{{ $isSelected ? 'text-white text-opacity-60' : 'text-orange-200' }} font-italic" style="font-size: 0.85rem;">
                            Start a conversation...
                        </span>
                        @endif
                    </div>

                    {{-- Food Interest Tags (Optional Enhancement) --}}
                    @if($c->latestMessage && str_contains(strtolower($c->latestMessage->message), 'nasi'))
                    <div class="mt-1">
                        <span class="badge bg-white bg-opacity-20 text-white rounded-pill" style="font-size: 0.65rem;">
                            <i class="fas fa-bowl-rice me-1"></i>Rice Lover
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Hover Effect Indicator --}}
            @if($isSelected)
            <div class="position-absolute top-0 start-0 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-start-pill"
                style="width: 4px; height: 100%;"></div>
            @endif
        </div>
        @empty
        {{-- Empty State --}}
        <div class="text-center py-5">
            <div class="bg-white bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                style="width: 80px; height: 80px;">
                <i class="fas fa-comment-slash text-white text-opacity-60" style="font-size: 2rem;"></i>
            </div>
            <h6 class="text-white mb-2 fw-bold">No Conversations Yet</h6>
            <p class="text-orange-100 mb-3" style="font-size: 0.85rem;">
                Start chatting about Indonesian cuisine!
            </p>
            <button class="btn btn-light btn-sm rounded-pill px-4">
                <i class="fas fa-plus me-2"></i>New Chat
            </button>
        </div>
        @endforelse
    </div>

    {{-- Bottom Action Section --}}
    @if($chats->count() > 0)
    <div class="p-3 mt-4 border-top border-white border-opacity-20">
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-orange-100">
                {{ $chats->count() }} conversation{{ $chats->count() !== 1 ? 's' : '' }}
            </small>
            <button class="btn btn-outline-light btn-sm rounded-pill">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    @endif

    {{-- Custom Styles for Sidebar --}}
    <style>
        .chat-item {
            position: relative;
            overflow: hidden;
        }

        .chat-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .chat-item:hover::before {
            opacity: 1;
        }

        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        @media (max-width: 768px) {
            .chat-item {
                margin-bottom: 8px;
                padding: 12px;
            }
        }
    </style>
</div>
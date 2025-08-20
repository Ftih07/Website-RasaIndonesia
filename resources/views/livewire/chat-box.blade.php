{{-- resources/views/livewire/chat-box.blade.php --}}
<div class="chat-box-container" wire:poll.2s.keep-alive>
    {{-- Chat Header (Fixed) --}}
    <div class="px-4 py-3 border-bottom bg-gradient-to-r from-orange-100 to-amber-100 flex-shrink-0">
        <div class="d-flex align-items-center">
            {{-- Mobile Back Button --}}
            <button class="btn btn-sm text-orange-600 me-2 p-0 d-md-none" onclick="showSidebar()" style="width: 32px; height: 32px;">
                <i class="fas fa-arrow-left"></i>
            </button>

            <div class="position-relative me-3">
                <div class="bg-gradient-to-br from-orange-400 to-amber-500 rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="fas fa-user text-white"></i>
                </div>
                <div class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-2 border-white" style="width: 12px; height: 12px;"></div>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-bold text-gray-800">{{ $partner->name ?? 'Unknown User' }}</h6>
            </div>
        </div>
    </div>
    {{-- Messages Container (Scrollable) --}}
    <div id="chat-messages" class="chat-messages-area p-4">
        @php $lastDate = null; @endphp @foreach($messages as $msg) @php
        $dateLabel = $msg->created_at->isToday() ? 'Today' :
        ($msg->created_at->isYesterday() ? 'Yesterday' :
        $msg->created_at->format('d M Y')); @endphp {{-- Date Separator --}}
        @if($lastDate !== $dateLabel)
        <div class="d-flex justify-content-center my-4">
            <div
                class="badge bg-gradient bg-[#f97316] text-white px-3 py-2 rounded-pill shadow-sm">
                <i class="fas fa-calendar-alt me-1"></i>
                {{ $dateLabel }}
            </div>
        </div>
        @php $lastDate = $dateLabel; @endphp @endif {{-- Message Bubble --}}
        <div
            class="mb-3 {{ $msg->sender_id === auth()->id() ? 'd-flex justify-content-end' : 'd-flex justify-content-start' }}">
            <div
                class="d-flex align-items-end {{ $msg->sender_id === auth()->id() ? 'flex-row-reverse' : '' }}"
                style="max-width: 75%">
                {{-- Avatar --}} @if($msg->type !== 'system')
                <div class="flex-shrink-0 mx-2">
                    <div
                        class="{{ $msg->sender_id === auth()->id() ? 'bg-[#f97316]' : 'bg-secondary' }} bg-gradient rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                        style="width: 32px; height: 32px">
                        <span
                            class="text-white fw-bold"
                            style="font-size: 0.75rem">
                            {{ $msg->sender_id === auth()->id() ?
                            strtoupper(substr(auth()->user()->name ?? 'Y', 0,
                            1)) : strtoupper(substr($msg->sender->name ?? 'U',
                            0, 1)) }}
                        </span>
                    </div>
                </div>
                @endif {{-- Message Content --}}
                <div class="message-bubble position-relative">
                    <div
                        class="shadow-sm rounded-3 p-3 {{ 
                        $msg->type === 'system' 
                        ? 'bg-warning bg-gradient text-dark fst-italic' 
                        : ($msg->sender_id === auth()->id() 
                            ? 'bg-[#f97316] bg-gradient text-white' 
                            : 'bg-light border') 
                    }}"
                        style="{{ $msg->sender_id === auth()->id() && $msg->type !== 'system' ? 'border-bottom-end-radius: 0.375rem !important;' : ($msg->sender_id !== auth()->id() && $msg->type !== 'system' ? 'border-bottom-start-radius: 0.375rem !important;' : '') }}">
                        {{-- Image Message --}} @if($msg->type === 'image' &&
                        $msg->image_path)
                        <div class="mb-2">
                            <img
                                src="{{ asset('storage/'.$msg->image_path) }}"
                                class="img-fluid rounded-2 shadow-sm cursor-pointer"
                                style="max-width: 280px; cursor: pointer"
                                onclick="window.open(this.src, '_blank')"
                                data-bs-toggle="tooltip"
                                title="Click to view full image" />
                        </div>
                        @endif {{-- Text Message --}} @if($msg->message)
                        <p
                            class="mb-0 lh-base"
                            style="white-space: pre-line; word-wrap: break-word">
                            {!! \Illuminate\Support\Str::of(e($msg->message))
                            ->replace(':)', '😊')->replace(':(',
                            '☹️')->replace('<3','❤️') !!}
                                </p>
                                @endif
                    </div>

                    {{-- Message Meta Info --}}
                    <div
                        class="d-flex align-items-center gap-2 mt-1 {{ $msg->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                        <small
                            class="{{ $msg->type === 'system' ? 'text-warning' : 'text-muted' }}"
                            style="font-size: 0.75rem">
                            {{ $msg->created_at->format('H:i') }}
                        </small>

                        {{-- Read Receipt for sent messages --}}
                        @if($msg->sender_id === auth()->id() && $msg->type !==
                        'system')
                        <div class="d-flex align-items-center">
                            @if($msg->is_read)
                            <div
                                class="d-flex text-success"
                                style="margin-left: -2px">
                                <i
                                    class="fas fa-check"
                                    style="font-size: 0.7rem"></i>
                                <i
                                    class="fas fa-check"
                                    style="font-size: 0.7rem; margin-left: -4px"></i>
                            </div>
                            @else
                            <i
                                class="fas fa-check text-muted"
                                style="font-size: 0.7rem"></i>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Input Area (Fixed at bottom) --}}
    <div class="chat-input-area border-top bg-light">
        <form wire:submit.prevent="send" class="p-3">
            {{-- Image Preview --}} @if ($image)
            <div class="mb-3">
                <div
                    class="position-relative d-inline-block bg-light border border-2 border-dashed border-orange rounded-3 p-2">
                    <img
                        src="{{ $image->temporaryUrl() }}"
                        class="rounded-2 shadow-sm"
                        style="max-height: 120px" />
                    <button
                        type="button"
                        wire:click="$set('image', null)"
                        class="btn btn-danger btn-sm position-absolute top-0 end-0 rounded-circle p-1 shadow"
                        style="
                            transform: translate(25%, -25%);
                            width: 24px;
                            height: 24px;
                        ">
                        <i class="fas fa-times" style="font-size: 0.7rem"></i>
                    </button>
                </div>
            </div>
            @endif {{-- Input Row --}}
            <div class="row g-2 align-items-center">
                {{-- Emoji Toggle --}}
                <div class="col-auto">
                    <button
                        type="button"
                        id="emoji-toggle"
                        class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center hover-scale"
                        style="width: 40px; height: 40px">
                        <span style="font-size: 1.2rem">😊</span>
                    </button>
                </div>

                {{-- Message Input --}}
                <div class="col">
                    <div class="position-relative">
                        <input
                            type="text"
                            wire:model.defer="message"
                            placeholder="Type a message..."
                            class="form-control rounded-pill pe-5 border-2 shadow-sm"
                            style="padding: 12px 20px; border-color: #f97316" />

                        {{-- File Upload Button --}}
                        <input
                            type="file"
                            wire:model="image"
                            class="d-none"
                            id="chat-image"
                            accept="image/*" />
                        <label
                            for="chat-image"
                            class="position-absolute top-50 end-0 translate-middle-y me-3 btn btn-sm btn-outline-secondary rounded-circle p-1 hover-scale"
                            style="width: 30px; height: 30px">
                            <i
                                class="fas fa-paperclip"
                                style="font-size: 0.8rem"></i>
                        </label>
                    </div>
                </div>

                {{-- Send Button --}}
                <div class="col-auto">
                    <button
                        type="submit"
                        class="btn btn-orange bg-gradient rounded-circle d-flex align-items-center justify-content-center shadow hover-scale"
                        style="width: 46px; height: 46px">
                        <i class="fas fa-paper-plane text-white"></i>
                    </button>
                </div>
            </div>

            {{-- Emoji Picker Container --}}
            <div id="emoji-container" class="d-none mt-3">
                <div
                    class="border rounded-3 shadow-sm bg-white overflow-hidden">
                    <emoji-picker class="w-100"></emoji-picker>
                </div>
            </div>

            {{-- Quick Message Buttons --}}
            <div class="mt-2">
                <div class="d-flex flex-nowrap gap-2 overflow-auto px-1">
                    <button type="button"
                        wire:click="insertQuickMessage('Hi, I would like to place an order')"
                        class="btn btn-sm btn-outline-orange rounded-pill px-3 py-2">
                        🍽️ Order Now
                    </button>
                    <button type="button"
                        wire:click="insertQuickMessage('Can you give me an update on my order?')"
                        class="btn btn-sm btn-outline-orange rounded-pill px-3 py-2">
                        ⏰ Order Status
                    </button>
                    <button type="button"
                        wire:click="insertQuickMessage('I’d like to cancel my order, please')"
                        class="btn btn-sm btn-outline-orange rounded-pill px-3 py-2">
                        ❌ Cancel Order
                    </button>
                    <button type="button"
                        wire:click="insertQuickMessage('Is my food ready for pickup/delivery?')"
                        class="btn btn-sm btn-outline-orange rounded-pill px-3 py-2">
                        ✅ Ready?
                    </button>
                    <button type="button"
                        wire:click="insertQuickMessage('Thank you for the service!')"
                        class="btn btn-sm btn-outline-orange rounded-pill px-3 py-2">
                        ❤️ Thank You
                    </button>
                    <button type="button"
                        wire:click="insertQuickMessage('Can I change something in my order?')"
                        class="btn btn-sm btn-outline-orange rounded-pill px-3 py-2">
                        ✏️ Modify Order
                    </button>
                    <button type="button"
                        wire:click="insertQuickMessage('Do you have any specials today?')"
                        class="btn btn-sm btn-outline-orange rounded-pill px-3 py-2">
                        🌟 Specials
                    </button>
                    <button type="button"
                        wire:click="insertQuickMessage('Can I add extra items to my order?')"
                        class="btn btn-sm btn-outline-orange rounded-pill px-3 py-2">
                        ➕ Add Items
                    </button>
                    <button type="button"
                        wire:click="insertQuickMessage('What’s the estimated delivery time?')"
                        class="btn btn-sm btn-outline-orange rounded-pill px-3 py-2">
                        ⏱️ ETA
                    </button>
                    <button type="button"
                        wire:click="insertQuickMessage('Can you make it spicy/mild?')"
                        class="btn btn-sm btn-outline-orange rounded-pill px-3 py-2">
                        🌶️ Spice Level
                    </button>
                </div>
            </div>


        </form>
    </div>

    {{-- Scripts --}}
    <script
        type="module"
        src="https://cdn.jsdelivr.net/npm/emoji-picker-element"></script>
    <script>
        // Scroll helper
        function scrollBottom() {
            const el = document.getElementById("chat-messages");
            if (el) {
                el.scrollTop = el.scrollHeight;
            }
        }

        window.addEventListener("chat:scroll-bottom", scrollBottom);
        document.addEventListener("livewire:load", scrollBottom);

        // Auto scroll when new messages arrive
        document.addEventListener("livewire:load", () => {
            bindEmojiPicker();
            setTimeout(scrollBottom, 100);
        });

        Livewire.hook("message.processed", () => {
            bindEmojiPicker();
            setTimeout(scrollBottom, 100);
        });

        function bindEmojiPicker() {
            const picker = document.querySelector(
                "#emoji-container emoji-picker"
            );
            const input = document.querySelector(
                'input[wire\\:model\\.defer="message"]'
            );
            const toggle = document.getElementById("emoji-toggle");
            const wrap = document.getElementById("emoji-container");

            if (toggle && wrap && !toggle.dataset.bound) {
                toggle.addEventListener("click", () => {
                    wrap.classList.toggle("d-none");
                });
                toggle.dataset.bound = "true";
            }

            if (picker && input && !picker.dataset.bound) {
                picker.addEventListener("emoji-click", (e) => {
                    input.value += e.detail.unicode;
                    input.dispatchEvent(new Event("input")); // trigger Livewire
                    scrollBottom();
                });
                picker.dataset.bound = "true";
            }
        }
    </script>

    {{-- Additional Styles --}}
    <style>
        .btn-orange {
            background-color: #f97316;
            border-color: #f97316;
        }

        .btn-orange:hover {
            background-color: #ea580c;
            border-color: #ea580c;
        }

        .hover-scale:hover {
            transform: scale(1.05);
            transition: transform 0.2s ease;
        }

        .message-bubble {
            animation: fadeInUp 0.3s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom scrollbar untuk area pesan */
        .chat-messages-area::-webkit-scrollbar {
            width: 8px;
        }

        .chat-messages-area::-webkit-scrollbar-track {
            background: #f8f9fa;
            border-radius: 4px;
        }

        .chat-messages-area::-webkit-scrollbar-thumb {
            background: #f97316;
            border-radius: 4px;
        }

        .chat-messages-area::-webkit-scrollbar-thumb:hover {
            background: #ea580c;
        }

        /* Input focus styling */
        .form-control:focus {
            border-color: #f97316 !important;
            box-shadow: 0 0 0 0.2rem rgba(249, 115, 22, 0.25) !important;
        }
    </style>
</div>
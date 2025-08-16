{{-- resources/views/livewire/chat-box.blade.php --}}
<div class="flex-1 flex flex-col" wire:poll.2s.keep-alive>
    <div id="chat-messages" class="flex-1 p-3 overflow-y-auto space-y-3">
        @foreach($messages as $msg)
        <div @class(['flex', 'justify-end'=> $msg->sender_id === auth()->id()])>
            <div @class([ 'max-w-xs p-3 rounded-lg' , 'bg-green-200'=> $msg->sender_id === auth()->id(),
                'bg-gray-200' => $msg->sender_id !== auth()->id(),
                'italic text-gray-600 bg-yellow-100' => $msg->type === 'system',
                ])>
                @if($msg->type === 'image' && $msg->image_path)
                <img src="{{ asset('storage/'.$msg->image_path) }}" class="max-w-[200px] rounded mb-2">
                @endif
                @if($msg->message)
                <p>{{ $msg->message }}</p>
                @endif
                <span class="block text-xs text-gray-500">{{ $msg->created_at->format('H:i') }}</span>
            </div>
        </div>
        @endforeach
    </div>

    <form wire:submit.prevent="send" class="flex border-t p-2 gap-2">
        <input type="text" wire:model.defer="message" placeholder="Ketik pesan..." class="flex-1 p-2 outline-none border rounded">
        <input type="file" wire:model="image" class="p-2">
        <button type="submit" class="bg-green-500 text-white px-4 rounded">Kirim</button>
    </form>
</div>

<script>
    Livewire.on('chat:scroll-bottom', () => {
        const el = document.getElementById('chat-messages');
        if (el) el.scrollTop = el.scrollHeight;
    });
    // auto scroll on load
    document.addEventListener('livewire:load', () => {
        const el = document.getElementById('chat-messages');
        if (el) el.scrollTop = el.scrollHeight;
    });
</script>
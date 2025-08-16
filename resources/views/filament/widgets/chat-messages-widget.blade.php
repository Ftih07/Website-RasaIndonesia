<div class="space-y-3">
    <div wire:poll.10s>
        @foreach($this->messages as $msg)
        <div class="p-3 rounded-lg {{ $msg->sender_id == auth()->id() ? 'bg-green-100 text-right' : 'bg-gray-100' }}">
            <strong>{{ $msg->sender->name }}</strong>
            @if($msg->type === 'image' && $msg->image_path)
            <img src="{{ asset('storage/'.$msg->image_path) }}" class="max-w-xs mt-1 rounded">
            @endif
            @if($msg->message)
            <p>{{ $msg->message }}</p>
            @endif
            <div class="text-xs text-gray-500">{{ $msg->created_at->diffForHumans() }}</div>
        </div>
        @endforeach

        {{-- Form kirim pesan --}}
        <form wire:submit.prevent="send" class="flex gap-2 items-center border-t pt-3 mt-3">
            <input type="text" wire:model.defer="message" class="flex-1 p-2 border rounded" placeholder="Tulis pesan...">
            <input type="file" wire:model="image" class="text-sm">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Kirim</button>
        </form>
    </div>
</div>
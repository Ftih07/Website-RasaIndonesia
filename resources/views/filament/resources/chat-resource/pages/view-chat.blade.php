<div class="space-y-3" wire:poll.2s>
    @foreach($this->messages as $msg)
        <div class="p-3 rounded-lg {{ $msg->sender_id === auth()->id() ? 'bg-green-100' : 'bg-gray-100' }}">
            <strong>{{ $msg->sender->name }}</strong>
            @if($msg->type === 'image' && $msg->image_path)
                <img src="{{ asset('storage/'.$msg->image_path) }}" class="max-w-xs mt-1 rounded">
            @endif
            @if($msg->message)
                <p>{{ $msg->message }}</p>
            @endif
            <span class="text-xs text-gray-500">{{ $msg->created_at->diffForHumans() }}</span>
        </div>
    @endforeach
</div>

<form wire:submit.prevent="send" class="flex gap-2 mt-3">
    <input type="text" wire:model.defer="message" placeholder="Ketik pesan..." class="flex-1 border rounded p-2">
    <input type="file" wire:model="image" class="border rounded p-2">
    <button type="submit" class="bg-primary-500 text-white px-4 rounded">Kirim</button>
</form>

<div class="space-y-3">
    <div wire:poll.10s class="max-h-[70vh] overflow-y-auto px-2 
        scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-600 
        scrollbar-track-gray-100 dark:scrollbar-track-gray-800">

        @foreach($this->messages as $msg)
        <div class="flex mb-4 {{ $msg->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
            <div class="max-w-xs md:max-w-md lg:max-w-lg p-4 rounded-2xl shadow-sm transition-all duration-200
                    {{ $msg->sender_id == auth()->id() 
                        ? 'bg-primary-500 hover:bg-primary-600 text-white rounded-br-md border border-primary-400' 
                        : 'bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-bl-md border border-gray-200 dark:border-gray-700 hover:shadow-md' }}">

                {{-- Nama pengirim --}}
                <strong class="block text-xs font-medium mb-2 
                    {{ $msg->sender_id == auth()->id() 
                        ? 'text-primary-100' 
                        : 'text-gray-600 dark:text-gray-400' }}">
                    {{ $msg->sender->name }}
                </strong>

                {{-- Gambar --}}
                @if($msg->type === 'image' && $msg->image_path)
                <div class="mb-3">
                    <img src="{{ asset('storage/'.$msg->image_path) }}"
                        class="max-w-full rounded-lg border border-gray-200 dark:border-gray-600 
                        shadow-sm hover:shadow-md transition-shadow duration-200">
                </div>
                @endif

                {{-- Pesan teks --}}
                @if($msg->message)
                <div class="text-sm leading-relaxed mb-2">
                    {{ $msg->message }}
                </div>
                @endif

                {{-- Footer bubble --}}
                <div class="flex items-center justify-end gap-2 text-xs 
                    {{ $msg->sender_id == auth()->id() 
                        ? 'text-primary-200' 
                        : 'text-gray-500 dark:text-gray-400' }}">

                    <time datetime="{{ $msg->created_at->toISOString() }}"
                        class="font-medium">
                        {{ $msg->created_at->format('H:i d/m/Y') }}
                    </time>

                    {{-- Read receipt (hanya untuk pesan kita) --}}
                    @if($msg->sender_id == auth()->id())
                    @if($msg->is_read)
                    <span class="text-success-400 dark:text-success-300" title="Dibaca">✔✔</span>
                    @else
                    <span class="text-primary-300 dark:text-primary-400" title="Terkirim">✔</span>
                    @endif
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Form kirim pesan --}}
    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4 
        bg-white dark:bg-gray-900 rounded-lg shadow-sm">

        <form wire:submit.prevent="send" class="flex gap-3 items-end p-4">

            {{-- Input pesan --}}
            <div class="flex-1">
                <input type="text" wire:model.defer="message"
                    class="w-full p-3 rounded-xl 
                    bg-gray-50 dark:bg-gray-800 
                    text-gray-900 dark:text-gray-100 
                    border border-gray-200 dark:border-gray-600 
                    focus:ring-2 focus:ring-primary-500 focus:border-primary-500 
                    dark:focus:ring-primary-400 dark:focus:border-primary-400
                    placeholder-gray-500 dark:placeholder-gray-400
                    transition-all duration-200 ease-in-out
                    shadow-sm hover:shadow-md focus:shadow-md"
                    placeholder="Tulis pesan...">
            </div>

            {{-- Upload file --}}
            <div class="flex-shrink-0">
                <label for="image-upload"
                    class="inline-flex items-center justify-center w-12 h-12 
                    bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 
                    text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 
                    rounded-xl border border-gray-200 dark:border-gray-600 
                    cursor-pointer transition-all duration-200 shadow-sm hover:shadow-md
                    focus:ring-2 focus:ring-primary-500 focus:outline-none"
                    title="Pilih gambar">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </label>

                <input type="file"
                    wire:model="image"
                    id="image-upload"
                    class="sr-only"
                    accept="image/*">
            </div>

            {{-- Tombol kirim --}}
            <button type="submit"
                class="flex-shrink-0 inline-flex items-center justify-center px-6 py-3 
                bg-primary-600 hover:bg-primary-700 focus:bg-primary-700 
                dark:bg-primary-500 dark:hover:bg-primary-600 dark:focus:bg-primary-600
                text-white font-medium rounded-xl 
                border border-primary-600 dark:border-primary-500
                focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 
                dark:focus:ring-offset-gray-900 focus:outline-none
                transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-md
                disabled:opacity-50 disabled:cursor-not-allowed"
                wire:loading.attr="disabled"
                wire:target="send">

                <span wire:loading.remove wire:target="send">Kirim</span>
                <span wire:loading wire:target="send" class="flex items-center gap-2">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Mengirim...
                </span>
            </button>
        </form>

        {{-- Preview upload image --}}
        @if($image)
        <div class="px-4 pb-4">
            <div class="flex items-center gap-3 p-3 
                bg-gray-50 dark:bg-gray-800 
                border border-gray-200 dark:border-gray-600 
                rounded-lg">

                <div class="flex-shrink-0 w-10 h-10 
                    bg-primary-100 dark:bg-primary-900 
                    text-primary-600 dark:text-primary-400 
                    rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>

                <div class="flex-1 text-sm">
                    <div class="font-medium text-gray-900 dark:text-gray-100">
                        Gambar siap dikirim
                    </div>
                    <div class="text-gray-500 dark:text-gray-400">
                        {{ $image->getClientOriginalName() }}
                    </div>
                </div>

                <button type="button"
                    wire:click="$set('image', null)"
                    class="flex-shrink-0 p-1 text-gray-400 hover:text-gray-600 
                    dark:text-gray-500 dark:hover:text-gray-300 
                    rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 
                    transition-colors duration-200"
                    title="Hapus gambar">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        @endif
    </div>
</div>
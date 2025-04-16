<x-filament::page>
    <x-filament::card>
        <h2 class="text-xl font-bold mb-4">{{ $record->name }}</h2>

        <div class="flex flex-col items-center gap-4">
            <div>{!! QrCode::size(250)->generate($record->url) !!}</div>

            <a 
                href="{{ route('qr.download', $record->id) }}"
                target="_blank"
                class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition"
            >
                📥 Download QR Code
            </a>

            <p class="text-gray-500">{{ $record->url }}</p>
        </div>
    </x-filament::card>
</x-filament::page>

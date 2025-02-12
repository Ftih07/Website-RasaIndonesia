<x-filament-panels::page>
    <div class="p-4 space-y-4">
        {{-- File Upload Manual tanpa Filament Form --}}
        <input type="file" wire:model="json_file" accept=".json" class="block w-full border p-2 rounded">

        {{-- Tombol Submit --}}
        <x-filament::button wire:click="importData" color="primary" class="mt-4">
            Import Now
        </x-filament::button>

        {{-- Notifikasi --}}
        @if (session()->has('message'))
            <div class="text-green-500 mt-2">{{ session('message') }}</div>
        @endif
    </div>
</x-filament-panels::page>

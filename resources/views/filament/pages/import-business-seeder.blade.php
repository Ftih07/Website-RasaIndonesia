<x-filament-panels::page>
    <style>
        select {
            background-color: black !important;
            color: white !important;
            border: 1px solid #444;
        }

        option {
            background-color: black !important;
            color: white !important;
        }
    </style>

    <div class="p-4 space-y-4">
        {{-- Pilihan Type --}}
        <label class="block text-white">Select Type Business</label>
        <select wire:model="selectedTypeId" class="block w-full border p-2 rounded">
            <option value="">Select Business Type</option>
            @foreach ($this->types as $type)
            <option value="{{ $type->id }}">{{ $type->title }}</option>
            @endforeach
        </select>

        {{-- File Upload --}}
        <label class="block mt-4">Upload JSON File</label>
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
<x-filament-panels::page>
    <style>
        /* Custom styling for select dropdown */
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
        <!-- Business Selection Dropdown -->
        <label class="block text-white">Select Business</label>
        <select wire:model="business_id" class="block w-full border p-2 rounded">
            <option value="">-- Choose Business --</option>
            @foreach ($this->getBusinessOptions() as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>

        <!-- JSON File Upload -->
        <label class="block mt-4">Upload JSON File</label>
        <input type="file" wire:model="json_file" accept=".json" class="block w-full border p-2 rounded">

        <!-- Import Button -->
        <x-filament::button wire:click="importData" color="primary" class="mt-4">
            Import Now
        </x-filament::button>

        <!-- Success Notification -->
        @if (session()->has('message'))
        <div class="text-green-500 mt-2">{{ session('message') }}</div>
        @endif
    </div>
</x-filament-panels::page>
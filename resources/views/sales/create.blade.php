<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add') }} {{ __('Sale') }}
        </h2>
    </x-slot>
    <livewire:sales.create :visit="$pullApart->visit"  />
</x-app-layout>

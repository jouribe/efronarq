<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Promotions') }}
        </h2>
    </x-slot>

    <livewire:promotions.index />

</x-app-layout>
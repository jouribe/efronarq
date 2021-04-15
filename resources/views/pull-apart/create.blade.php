<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add') }} {{ __('Pull apart') }}
        </h2>
    </x-slot>

    <livewire:pull-aparts.create :visit="$visit" :page="request()->fullUrl()" />
</x-app-layout>

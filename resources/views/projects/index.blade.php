<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-end mb-4">
                <x-link :href="route('projects.create')">{{ __('Add') }}</x-link>
            </div>

            <livewire:tables.projects />

        </div>
    </div>
</x-app-layout>

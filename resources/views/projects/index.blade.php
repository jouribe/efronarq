<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <livewire:tables.projects
                :route="route('projects.create')"
                :is-admin="!auth()->user()->hasRole(['admin', 'asistente'])"/>

        </div>
    </div>
</x-app-layout>

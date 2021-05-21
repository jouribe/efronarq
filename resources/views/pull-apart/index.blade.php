<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pull apart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <livewire:tables.pull-aparts
                :is-admin="auth()->user()->hasRole(['admin', 'asistente'])"/>

        </div>
    </div>

    @include('pull-apart.modals.pull-aparts-selection')
</x-app-layout>

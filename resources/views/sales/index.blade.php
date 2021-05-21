<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <livewire:tables.sales
                :is-admin="!auth()->user()->hasRole(['admin', 'asistente'])"/>

        </div>
    </div>

    @include('sales.modals.sales-selection')
</x-app-layout>ð

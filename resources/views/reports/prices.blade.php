<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de precios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{type :''}">

            <livewire:tables.prices/>

            <div x-show="type === '1'">

            </div>

            <div x-show="type === '2'">
                <livewire:tables.report-parking-loots-prices/>
            </div>

            <div x-show="type === '3'">
                <livewire:tables.report-closets-prices/>
            </div>

        </div>
    </div>

</x-app-layout>

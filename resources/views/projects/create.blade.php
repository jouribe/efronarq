<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow">
                <x-jet-validation-errors class="mb-4"/>

                <form method="POST" action="{{ route('projects.store') }}" class="flex">

                    @csrf

                    <div class="p-4 w-1/2">
                        <x-jet-label for="name" value="{{ __('Name') }}"/>
                        <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus/>
                    </div>

                    <div class="p-4 w-1/2">
                        <x-jet-label for="status" value="{{ __('Status') }}"/>
                        <select id="status" name="status" class="form-select block w-full mt-1">
                            <option selected value="">{{ __('Select') }}</option>
                            <option value="Preregistrado">Preregistrado</option>
                            <option value="Preventa">Preventa</option>
                            <option value="En construcción">En construcción</option>
                            <option value="Entrega">Entrega</option>
                            <option value="Finalizado">Finalizado</option>
                        </select>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>

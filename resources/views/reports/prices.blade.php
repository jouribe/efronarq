<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de precios') }}
        </h2>
    </x-slot>

    <div class="pt-10 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{type :'', projectId: ''}">

            <div class="flex">
                <select @change="projectId = $event.target.value; sendProjectId(projectId)" class="md:w-1/4 form-select mb-6 mr-4">
                    <option x-bind:value="0">Seleccionar</option>
                    @foreach($projects as $project)
                        <option x-bind:value="{{ $project->id  }}">{{ $project->name }}</option>
                    @endforeach
                </select>

                <script>
                    function sendProjectId(id)
                    {
                        Livewire.emit('setProjectId', id)
                    }
                </script>

                <select @change="type = $event.target.value" class="md:w-1/4 form-select mb-6">
                    <option x-bind:value="0">Seleccionar</option>
                    <option x-bind:value="1">Departamento</option>
                    <option x-bind:value="2">Estacionamiento</option>
                    <option x-bind:value="3">Depósito/Closet</option>
                </select>
            </div>

            <div x-show="type === '1'">
                <livewire:tables.prices />
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

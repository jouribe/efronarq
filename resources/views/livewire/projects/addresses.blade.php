<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">
        {{ __('Direcciones de Estacionamientos') }}
    </h2>

    @if($isOpen)
        @include('projects.modals.address-create')
    @endif

    <livewire:tables.project-addresses :project-id="$project->id"/>
</div>

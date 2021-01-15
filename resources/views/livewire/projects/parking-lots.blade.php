<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">
        {{ __('Parking lots') }}
    </h2>

    @if($isOpen)
        @include('projects.modals.parking-lots-create')
    @endif

    <livewire:tables.project-parking-lots :project-id="$project->id"/>
</div>

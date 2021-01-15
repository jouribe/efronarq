<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">
        {{ __('Apartment Type') }}
    </h2>

    @if($isOpen)
        @include('projects.modals.apartment-type-create')
    @endif

    <livewire:tables.project-apartment-types :project-id="$project->id"/>

</div>

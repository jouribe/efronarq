<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">
        {{ __('Apartments') }}
    </h2>

    @if($isOpen)
        @include('projects.modals.price-apartments-create')
    @endif

    <livewire:tables.project-price-apartments
        :project-id="$project->id"
        :is-admin="auth()->user()->hasRole(['admin', 'asistente'])" />
</div>

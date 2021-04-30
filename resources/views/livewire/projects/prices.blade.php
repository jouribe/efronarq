<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">
        {{ __('General') }}
    </h2>

    @if($isOpen)
        @include('projects.modals.prices-create')
    @endif

    <livewire:tables.project-prices
        :project-id="$project->id"
        :hide-create="$project->prices->count() > 0"
        :is-admin="auth()->user()->hasRole(['admin', 'asistente'])" />

</div>

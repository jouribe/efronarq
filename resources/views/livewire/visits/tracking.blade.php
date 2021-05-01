<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">
        {{ __('Tracking') }}
    </h2>

    @if($isOpen)
        @include('visits.modals.tracking-create')
    @endif

    <livewire:tables.visits-tracking
        :visit-id="$visit->id"
        :hideable="auth()->user()->hasRole('vendedor') ? 'add-modal' : null"/>
</div>

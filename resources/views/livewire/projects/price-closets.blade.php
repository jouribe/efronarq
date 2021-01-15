<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">
        {{ __('Storage / Closets') }}
    </h2>

    @if($isOpen)
        @include('projects.modals.price-closets-create')
    @endif

    <livewire:tables.project-price-closets :project-id="$project->id" :hide-create="$project->closetPrices->count() > 0"/>
</div>

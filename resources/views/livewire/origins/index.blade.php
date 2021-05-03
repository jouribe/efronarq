<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if($isOpen)
            @include('origins.modals.origin-create')
        @endif

        <livewire:tables.origins />

    </div>
</div>

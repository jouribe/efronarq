<div class="pt-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if($isOpen)
            @include('exchanges.modals.exchange-create')
        @endif

        <livewire:tables.exchanges/>

    </div>
</div>

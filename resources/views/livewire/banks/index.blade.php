<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if($isOpen)
            @include('banks.modals.bank-create')
        @endif

        <livewire:tables.bank />

    </div>
</div>

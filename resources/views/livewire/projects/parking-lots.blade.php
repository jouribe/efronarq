<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">
        {{ __('Parking lots') }}
    </h2>

    <div class="flex justify-end mb-2">
        <x-link wire:click="create()" href="javascript:">{{ __('Add') }}</x-link>
    </div>

    @if($isOpen)
        @include('projects.modals.parking-lots-create')
    @endif

    <livewire:tables.project-parking-lots/>
</div>

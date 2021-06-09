<div class="flex">
    <div class="py-4 mr-4 w-1/4">
        <x-jet-label for="project">{{ __('Project') }}</x-jet-label>
        <x-dropdown-list :items="$projectList" wire:model="project" />
    </div>

    <div class="py-4 w-1/4">
        <x-jet-label for="priceType">{{ __('Tipo') }}</x-jet-label>
        <x-dropdown-list :items="$priceTypeList" wire:model="priceType" />
    </div>
</div>

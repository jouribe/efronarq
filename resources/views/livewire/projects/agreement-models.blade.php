<form wire:submit.prevent="store" enctype="multipart/form-data">
    <div class="w-full pb-10">
        <input class="editor" id="content" wire:model="content">
    </div>

    <div class="flex justify-end">
        <x-jet-button class="bg-blue-500 hover:bg-blue-700">{{ __('Save') }}</x-jet-button>
    </div>
</form>

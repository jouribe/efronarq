<form autocomplete="off" wire:submit.prevent="store">
    <div class="w-full pb-10">
        <textarea class="form-textarea editor" rows="10" id="content" wire:model="content"></textarea>
    </div>

    <script>
        tinymce.init({
            selector: '#content',
            //toolbar: 'undo redo  | bold italic underline ',
            menubar: false,
            height: '600'
        })
    </script>

    <div class="flex justify-end">
        <x-jet-button type="submit" class="bg-blue-500 hover:bg-blue-700">{{ __('Save') }}</x-jet-button>
    </div>
</form>

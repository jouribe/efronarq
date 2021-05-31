<form wire:submit.prevent="store">
    <div class="w-full pb-10" wire:ignore>
        <textarea class="content" wire:model.lazy="content" name="content"></textarea>

        <script>
            tinymce.init({
                selector: 'textarea.content',
                //toolbar: 'undo redo  | bold italic underline ',
                menubar: false,
                height: '600',
                forced_root_block: false,
                setup: function (editor) {
                    editor.on('init change', function () {
                        editor.save()
                    })
                    editor.on('change', function (e) {
                        @this.set('content', editor.getContent())
                    })
                },
            })
        </script>
    </div>

    <div class="flex justify-end">
        <x-jet-button class="bg-blue-500 hover:bg-blue-700">{{ __('Save') }}</x-jet-button>
    </div>
</form>

<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog"
             aria-modal="true" aria-labelledby="modal-headline">

            <form wire:submit.prevent="store">

                <div class="flex-row">
                    <div class="flex">
                        <div class="p-4 w-full">
                            <x-jet-label for="buy">{{ __('Compra') }}</x-jet-label>
                            <x-jet-input type="text" id="buy" class="w-full" wire:model="buy"/>
                            @error('buy') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-full">
                            <x-jet-label for="sale">{{ __('Venta') }}</x-jet-label>
                            <x-jet-input type="text" id="sale" class="w-full" wire:model="sale"/>
                            @error('sale') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-between p-4">
                        <x-jet-button type="button" wire:click="closeModal()">{{ __('Close') }}</x-jet-button>
                        <x-jet-button type="submit" class="bg-blue-500 hover:bg-blue-700">{{ __('Save') }}</x-jet-button>
                    </div>
                </div>


            </form>

        </div>

    </div>
</div>

<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog"
             aria-modal="true" aria-labelledby="modal-headline">

            <form>
                <div class="flex-row">

                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="free_area">Factor {{ __('Free area') }}</x-jet-label>
                            <x-jet-input id="free_area" class="w-full" required wire:model="free_area"/>
                        </div>

                        <div class="p-4 w-1/2">
                            <x-jet-label for="discount_presale">Factor {{ __('Discount presale') }}</x-jet-label>
                            <x-jet-input id="discount_presale" class="w-full" required wire:model="discount_presale"/>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="delivery_increment">Factor {{ __('Delivery increment') }}</x-jet-label>
                            <x-jet-input id="delivery_increment" class="w-full" required wire:model="delivery_increment"/>
                        </div>

                        <div class="p-4 w-1/2">
                            <x-jet-label for="parking_discount">{{ __('Parking discount') }}</x-jet-label>
                            <x-jet-input id="parking_discount" class="w-full" required wire:model="parking_discount"/>
                        </div>
                    </div>

                    <div class="p-4">
                        <x-jet-label for="currency">{{ __('Currency') }}</x-jet-label>
                        <x-dropdown-list :items="$currencyTypes" id="currency" required wire:model="currency" />
                    </div>

                    <div class="flex justify-between p-4">
                        <x-jet-button type="button" wire:click="closeModal()">{{ __('Close') }}</x-jet-button>
                        <x-jet-button type="button" class="bg-blue-900 hover:bg-blue-700" wire:click="store()">{{ __('Save') }}</x-jet-button>
                    </div>
                </div>
            </form>

        </div>

    </div>
</div>

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
                            <x-jet-label for="name">{{ __('Name') }}</x-jet-label>
                            <x-jet-input type="text" id="name" class="w-full" wire:model="name"/>
                            @error('name') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-full">
                            <x-jet-label for="description">{{ __('Description') }}</x-jet-label>
                            <x-jet-input type="text" id="description" class="w-full" wire:model="description"/>
                            @error('description') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-full">
                            <x-jet-label for="contact_name">{{ __('Contact name') }}</x-jet-label>
                            <x-jet-input type="text" id="contact_name" class="w-full" wire:model="contact_name"/>
                            @error('contact_name') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-full">
                            <x-jet-label for="contact_phone">{{ __('Contact phone') }}</x-jet-label>
                            <x-jet-input type="tel" id="contact_phone" class="w-full" wire:model="contact_phone"/>
                            @error('contact_phone') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-full">
                            <x-jet-label for="contact_email">{{ __('Contact email') }}</x-jet-label>
                            <x-jet-input type="email" id="contact_email" class="w-full" wire:model="contact_email"/>
                            @error('contact_email') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-full">
                            <x-jet-label for="currency">{{ __('Currency') }}</x-jet-label>
                            <x-dropdown-list :items="$currencyList" id="currency" wire:model="currency"/>
                            @error('currency') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-full">
                            <x-jet-label for="is_active">{{ __('Active') }}</x-jet-label>
                            <x-dropdown-list :items="$activeList" id="is_active" wire:model="is_active"/>
                            @error('is_active') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
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

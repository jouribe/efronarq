<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">

            <form wire:submit.prevent="store" autocomplete="off">
                <div class="flex-row">
                    <div class="p-4">
                        <x-jet-label for="type">{{ __('Type') }}</x-jet-label>
                        <x-dropdown-list required :items="$types" wire:model="type"></x-dropdown-list>
                        @error('type') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="p-4">
                        <x-jet-label for="district_id">{{ __('District') }}</x-jet-label>
                        <x-dropdown-list required :items="$districts" wire:model="district_id"></x-dropdown-list>
                        @error('district_id') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="p-4">
                        <x-jet-label for="address">{{ __('Address') }}</x-jet-label>
                        <x-jet-input class="w-full" required wire:model="address"/>
                        @error('address') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-between p-4">
                        <x-jet-button type="button" wire:click="closeModal()">{{ __('Close') }}</x-jet-button>
                        <x-jet-button type="submit" class="bg-blue-900 hover:bg-blue-700">{{ __('Save') }}</x-jet-button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

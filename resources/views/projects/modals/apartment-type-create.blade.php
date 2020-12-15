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
                    <div class="p-4">
                        <x-jet-label for="type_name">{{ __('Name') }}</x-jet-label>
                        <x-jet-input id="type_name" class="w-full" required wire:model="type_name"/>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="roofed_area">{{ __('Roofed area') }}</x-jet-label>
                            <x-jet-input id="roofed_area" class="w-full" required wire:model="roofed_area"/>
                        </div>

                        <div class="p-4 w-1/2">
                            <x-jet-label for="free_area">{{ __('Free area') }}</x-jet-label>
                            <x-jet-input id="free_area" class="w-full" required wire:model="free_area"/>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="bedroom">{{ __('Bedroom') }}</x-jet-label>
                            <x-jet-input id="bedroom" class="w-full" required wire:model="bedroom"/>
                        </div>

                        <div class="p-4 w-1/2">
                            <x-jet-label for="bathroom">{{ __('Bathroom') }}</x-jet-label>
                            <x-jet-input id="bathroom" class="w-full" required wire:model="bathroom"/>
                        </div>
                    </div>

                    <div class="p-4">
                        <x-jet-label for="view">{{ __('View') }}</x-jet-label>
                        <x-jet-input id="view" class="w-full" required wire:model="view"/>
                    </div>

                    <div class="p-4">
                        <x-jet-label for="blueprint">{{ __('Blueprint') }}</x-jet-label>
                        <x-jet-input id="blueprint" class="w-full" required wire:model="blueprint"/>
                    </div>

                    <div class="p-4">
                        <x-jet-label for="service_room">{{ __('Service room') }}</x-jet-label>
                        <x-dropdown-list :items="$isServiceRoom" id="service_room" required wire:model="service_room" />
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

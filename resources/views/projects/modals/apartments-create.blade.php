<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog"
             aria-modal="true" aria-labelledby="modal-headline">

            <form wire:submit.prevent="store" autocomplete="off">

                <div class="flex-row">
                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="availability">{{ __('Availability') }}</x-jet-label>
                            <x-dropdown-list :items="$availabilityList" id="availability" wire:model="availability" />
                            @error('availability') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="p-4 w-1/2">
                            <x-jet-label for="project_apartment_type_id">{{ __('Type') }}</x-jet-label>
                            <x-dropdown-list :items="$projectApartmentTypeList" id="project_apartment_type_id" wire:model="project_apartment_type_id" />
                            @error('project_apartment_type_id') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="start_floor">{{ __('Start floor') }}</x-jet-label>
                            <x-jet-input id="start_floor" class="w-full" wire:model="start_floor"/>
                            @error('start_floor') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                         <div class="p-4 w-1/2">
                            <x-jet-label for="end_floor">{{ __('End floor') }}</x-jet-label>
                            <x-jet-input id="end_floor" class="w-full" wire:model="end_floor"/>
                             @error('end_floor') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="parking_lots">{{ __('Parking lots') }}</x-jet-label>
                            <x-jet-input id="parking_lots" class="w-full" wire:model="parking_lots"/>
                            @error('parking_lots') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="p-4 w-1/2">
                            <x-jet-label for="closets">{{ __('Closets') }}</x-jet-label>
                            <x-jet-input id="closets" class="w-full" wire:model="closets"/>
                            @error('closets') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="order">{{ __('Order') }}</x-jet-label>
                            <x-jet-input id="order" class="w-full" wire:model="order"/>
                            @error('order') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-between p-4">
                        <x-jet-button type="button" wire:click="closeModal()">{{ __('Close') }}</x-jet-button>
                        <x-jet-button type="submit" class="bg-blue-900 hover:bg-blue-700" wire:click="store">{{ __('Save') }}</x-jet-button>
                    </div>
                </div>

            </form>

        </div>

    </div>
</div>

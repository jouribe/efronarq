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
                            <x-jet-label for="discount">{{ __('Discount') }}</x-jet-label>
                            <x-jet-input type="text" id="discount" class="w-full" wire:model="discount"/>
                            @error('discount') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-full">
                            <x-jet-label for="start_at">{{ __('Start at') }}</x-jet-label>
                            <x-jet-input type="date" id="start_at" class="w-full" wire:model="start_at"/>
                            @error('start_at') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-full">
                            <x-jet-label for="end_at">{{ __('End at') }}</x-jet-label>
                            <x-jet-input type="date" id="end_at" class="w-full" wire:model="end_at"/>
                            @error('end_at') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-full">
                            <x-jet-label for="project_id">{{ __('Project') }}</x-jet-label>
                            <x-dropdown-list :items="$projectList" id="project_id" wire:model="project_id"/>
                            @error('projectId') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
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

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
                        <div class="p-4 w-full">
                            <x-jet-label for="name">{{ __('Name') }}</x-jet-label>
                            <x-jet-input type="text" id="name" class="w-full" wire:model="name"/>
                            @error('name') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-full">
                            <x-jet-label for="email">{{ __('Email') }}</x-jet-label>
                            <x-jet-input type="email" id="email" class="w-full" wire:model="email"/>
                            @error('email') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-full">
                            <x-jet-label for="password">{{ __('Password') }}</x-jet-label>
                            <x-jet-input type="password" id="password" class="w-full" wire:model="password"/>
                            @error('password') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-full">
                            <x-jet-label for="password_confirmation">{{ __('Password confirmation') }}</x-jet-label>
                            <x-jet-input type="password" id="password_confirmation" class="w-full" wire:model="password_confirmation"/>
                            @error('password_confirmation') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-full">
                            <x-jet-label for="role">{{ __('Role') }}</x-jet-label>
                            <x-dropdown-list :items="$roleList" id="role" wire:model="role"/>
                            @error('role') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
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

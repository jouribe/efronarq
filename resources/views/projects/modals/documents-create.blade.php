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
                            <x-jet-label for="type">{{ __('Type') }}</x-jet-label>
                            <x-dropdown-list :items="$typeList" id="type" wire:model="type"/>
                            @error('type') <span class="text-red-600 text-xs font-bold">* {{ __('required') }}</span> @enderror
                        </div>

                        <div class="p-4 w-1/2">
                            <x-jet-label for="name">{{ __('Name') }}</x-jet-label>
                            <x-jet-input type="text" id="name" class="w-full" wire:model="name"/>
                            @error('name') <span class="text-red-600 text-xs font-bold">* {{ __('required') }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-full" x-data="{ isUploading: false, progress: 0 }"
                             x-on:livewire-upload-start="isUploading = true"
                             x-on:livewire-upload-finish="isUploading = false"
                             x-on:livewire-upload-error="isUploading = false"
                             x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <x-jet-label for="file">{{ __('File') }}</x-jet-label>
                            <label
                                class="w-full flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue-900 hover:text-white">
                                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"/>
                                </svg>
                                <span class="mt-2 text-base leading-normal">{{ __('Select a file') }}</span>
                                <input type="file" class="hidden" wire:model="file"/>
                                <input type="hidden" wire:model="current_file">
                            </label>

                            @error('file') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror

                            <!-- Progress Bar -->
                            <div x-show="isUploading" class="mt-1 flex">
                                <progress max="100" x-bind:value="progress" class="w-full h-1"></progress>
                            </div>
                        </div>
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

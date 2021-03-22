<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow">
                <x-jet-validation-errors class="mb-4"/>

                <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data" autocomplete="off">

                    @csrf

                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="name" value="{{ __('Name') }}"/>
                            <x-jet-input id="name" type="text" name="name" :value="old('name')" required autofocus/>
                            @error('name') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="p-4 w-1/2">
                            <x-jet-label for="status" value="{{ __('Project status') }}"/>
                            <x-dropdown-list id="status" name="status" :items="$projectStatus"/>
                            @error('status') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="district_id" value="{{ __('District') }}"/>
                            <x-dropdown-list id="district_id" name="district_id" :items="$districts"/>
                            @error('district_id') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="p-4 w-1/2">
                            <x-jet-label for="address" value="{{ __('Main address') }}"/>
                            <x-jet-input id="address" type="text" name="address" :value="old('address')"/>
                            @error('address') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="bank_id" value="{{ __('Financing bank') }}"/>
                            <x-dropdown-list id="bank_id" name="bank_id" :items="$banks"/>
                            @error('bank_id') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="p-4 w-1/2">
                            <x-jet-label for="logo" value="{{ __('Logo') }}"/>
                            <input type="file" id="logo" name="logo" value="{{ old('logo') }}">
                            @error('logo') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="currency" value="{{ __('Currency') }}"/>
                            <x-dropdown-list id="currency" name="currency" :items="$currencyList"/>
                            @error('currency') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="account_nro_mn">{{ __('N° Cuenta corriente MN') }}</x-jet-label>
                            <x-jet-input type="text" id="account_nro_mn" class="w-full"  name="account_nro_mn" value="{{ old('account_nro_mn') }}"/>
                            @error('account_nro_mn') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="p-4 w-1/2">
                            <x-jet-label for="account_nro_me">{{ __('N° Cuenta corriente ME') }}</x-jet-label>
                            <x-jet-input type="text" id="account_nro_me" class="w-full" name="account_nro_me" value="{{ old('account_nro_me') }}"/>
                            @error('account_nro_me') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                    </div>

                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="description" value="{{ __('Description') }}"/>
                            <textarea class="form-textarea editor" id="description" name="description"></textarea>
                        </div>

                        <div class="p-4 w-1/2">
                            <x-jet-label for="legal" value="{{ __('Legal listing') }}" />
                            <textarea id="legal" name="legal" class="form-textarea" rows="7"></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <div class="p-4">
                            <x-jet-button>{{ __('Save') }}</x-jet-button>
                        </div>
                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>

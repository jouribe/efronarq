<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Visit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow">
                <x-jet-validation-errors class="mb-4"/>

                <form method="POST" action="{{ route('visits.update', $visit->id) }}">

                    @method('PUT')

                    @csrf

                    <h2 class="px-4 text-lg">{{ __('Personal data') }}</h2>
                    <hr class="mx-4 pb-6">

                    <div class="flex-row">
                        <div class="flex">
                            <div class="p-4 w-1/2">
                                <x-jet-label for="first_name">{{ __('First name') }}</x-jet-label>
                                <x-jet-input type="text" class="form-input mt-1 w-full" name="first_name" id="first_name" value="{{ $visit->customer->first_name }}" required/>
                            </div>

                            <div class="p-4 w-1/2">
                                <x-jet-label for="last_name">{{ __('Last name') }}</x-jet-label>
                                <x-jet-input type="text" class="form-input mt-1 w-full" name="last_name" id="last_name" value="{{ $visit->customer->last_name }}" required/>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="p-4 w-1/3">
                                <x-jet-label for="dni">{{ __('DNI') }}</x-jet-label>
                                <x-jet-input type="text" class="form-input mt-1 w-full" name="dni" id="dni" value="{{ $visit->customer->dni }}" required maxlength="8" minlength="8"/>
                            </div>

                            <div class="p-4 w-1/3">
                                <x-jet-label for="phone">{{ __('Phone') }}</x-jet-label>
                                <x-jet-input type="text" class="form-input mt-1 w-full" name="phone" id="phone" value="{{ $visit->customer->phone }}" required/>
                            </div>

                            <div class="p-4 w-1/3">
                                <x-jet-label for="district_id">{{ __('District') }}</x-jet-label>
                                <x-dropdown-list :items="$districts" id="district_id" class="mt-1" name="district_id" :selectedId="$visit->customer->district_id" required/>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="p-4 w-1/2">
                                <x-jet-label for="email">{{ __('Email') }}</x-jet-label>
                                <x-jet-input class="form-input mt-1 w-full" name="email" id="email" type="email" value="{{ $visit->customer->email }}" required/>
                            </div>

                            <div class="p-4 w-1/2">
                                <x-jet-label for="secondary_email">{{ __('Secondary email') }}</x-jet-label>
                                <x-jet-input class="form-input mt-1 w-full" name="secondary_email" id="secondary_email" type="email" value="{{ $visit->customer->secondary_email }}" />
                            </div>
                        </div>
                    </div>

                    <h2 class="px-4 text-lg pt-10">{{ __('How did you find out?') }}</h2>
                    <hr class="mx-4 pb-6">

                    <div class="flex-row p-4 w-1/3">
                        <x-jet-label for="origin_id">{{ __('Origin') }}</x-jet-label>
                        <x-dropdown-list :items="$origins" id="origin_id" name="origin_id" class="mt-1" :selectedId="$visit->origin_id" required/>
                    </div>

                    <h2 class="px-4 text-lg pt-10">{{ __('What are you looking for?') }}</h2>
                    <hr class="mx-4 pb-6">

                    <div class="flex-row">
                        <div class="flex">
                            <div class="p-4 w-1/5">
                                <x-jet-label for="area_range">{{ __('Area range') }} m<sup>2</sup></x-jet-label>
                                <x-dropdown-list :items="$areaRangeList" id="area_range" name="area_range" class="mt-1" :selectedId="$visit->customer->details->first()->area_range" required/>
                            </div>

                            <div class="p-4 w-1/5">
                                <x-jet-label for="bedroom">{{ __('Bedroom') }}</x-jet-label>
                                <x-jet-input type="text" class="form-input mt-1 w-full" name="bedroom" id="bedroom" value="{{ $visit->customer->details->first()->bedroom }}"/>
                            </div>

                            <div class="p-4 w-1/5">
                                <x-jet-label for="bathroom">{{ __('Bathroom') }}</x-jet-label>
                                <x-jet-input type="text" class="form-input mt-1 w-full" name="bathroom" id="bathroom" value="{{ $visit->customer->details->first()->bathroom }}"/>
                            </div>

                            <div class="p-4 w-1/5">
                                <x-jet-label for="type_financing">{{ __('Financing type') }}</x-jet-label>
                                <x-dropdown-list :items="$financingTypeList" id="type_financing" name="type_financing" class="mt-1" :selectedId="$visit->type_financing" required/>
                            </div>

                            <div class="flex p-4 w-1/5">
                                <x-jet-label for="service_room" class="hidden">{{ __('Service room') }}</x-jet-label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" class="form-checkbox mt-1" id="service_room" name="service_room">
                                    <span class="ml-2">{{ __('Service room') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <h2 class="px-4 text-lg pt-10">{{ __('What do we offer you?') }}</h2>
                    <hr class="mx-4 pb-6">

                    <livewire:visits.project :projects="$projects" :bool-list="$boolList" :discount-list="$discountList" :visit="$visit"/>

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

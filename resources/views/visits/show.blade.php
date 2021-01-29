<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Visit') }}: {{ $visit->project->name }}
        </h2>
    </x-slot>

    @if(!is_null($visit->quotation))
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="px-4 text-lg">{{ __('Quote summary') }}</h2>

                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <span class="block text-xs text-gray-500">{{ __('Created at') }}</span>
                            <div>{{ $visit->quotation->created_at->format('d/m/Y H:i:s') }}</div>
                        </div>

                        @if(!is_null($visit->apartment))
                            <div class="p-4 w-1/2">
                                <span class="block text-xs text-gray-500">{{ __('Blueprints') }}</span>
                                <ul>
                                    <li>
                                        <a class="text-blue-400 hover:text-blue-600 text-sm" href="{{ asset("storage/{$visit->apartment->apartmentType->blueprint}") }}" target="_blank">
                                            {{ __('Apartment') }} {{ $visit->apartment->apartmentType->type_name }}
                                        </a>
                                    </li>

                                    @if(!is_null($visit->parkingLots))

                                        @foreach($visit->parkingLots as $parkingLot)

                                            <li>
                                                <a class="text-blue-400 hover:text-blue-600 text-sm" href="{{ asset("storage/{$parkingLot->parkingLot->blueprint}") }}" target="_blank">
                                                    {{ __('Parking lot') }} {{ $parkingLot->parkingLot->parking_lot }}
                                                </a>
                                            </li>

                                        @endforeach

                                    @endif

                                    @if(!is_null($visit->closets))
                                        @foreach($visit->closets as $closet)

                                            <li>
                                                <a class="text-blue-400 hover:text-blue-600 text-sm" href="{{ asset("storage/{$closet->closet->blueprint}") }}" target="_blank">
                                                    {{ __('Closet') }} {{ $closet->closet->closet }}
                                                </a>
                                            </li>

                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="flex justify-end">
                        <div class="p-4">
                            <x-link color="green" href="{{ asset('storage/' . $visit->quotation->file) }}" target="_blank">
                                <svg class="w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ __('View Quote') }}
                            </x-link>

                            <x-link color="blue" href="#tracking">
                                <svg class="w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                </svg>
                                {{ __('Tracking') }}
                            </x-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">

                <h2 class="px-4 text-lg">{{ __('Personal data') }}</h2>
                <hr class="mx-4">

                <div class="flex">
                    <div class="p-4 w-1/4">
                        <span class="block text-xs text-gray-500">{{ __('DNI') }}</span>
                        <div>{{ $visit->customer->dni }}</div>
                    </div>

                    <div class="p-4 w-1/4">
                        <span class="block text-xs text-gray-500">{{ __('Name') }}</span>
                        <div>{{ $visit->customer->first_name }} {{ $visit->customer->last_name }}</div>
                    </div>

                    <div class="p-4 w-1/4">
                        <span class="block text-xs text-gray-500">{{ __('Phone') }}</span>
                        <div>{{ $visit->customer->phone }}</div>
                    </div>

                    <div class="p-4 w-1/4">
                        <span class="block text-xs text-gray-500">{{ __('District') }}</span>
                        <div>{{ $visit->customer->district->name }}</div>
                    </div>
                </div>

                <div class="flex">
                    <div class="p-4 w-1/4">
                        <span class="block text-xs text-gray-500">{{ __('Email') }}</span>
                        <div>{{ $visit->customer->email }}</div>
                    </div>

                    <div class="p-4 w-1/4">
                        <span class="block text-xs text-gray-500">{{ __('Secondary email') }}</span>
                        <div>{{ $visit->customer->secondary_email }}</div>
                    </div>
                </div>

                <h2 class="px-4 text-lg pt-10">{{ __('How did you find out?') }}</h2>
                <hr class="mx-4">

                <div class="flex">
                    <div class="p-4 w-1/4">
                        <span class="block text-xs text-gray-500">{{ __('Origin') }}</span>
                        <div>{{ $visit->origin->name }}</div>
                    </div>
                </div>

                <h2 class="px-4 text-lg pt-10">{{ __('What are you looking for?') }}</h2>
                <hr class="mx-4">

                <div class="flex">
                    <div class="p-4 w-1/5">
                        <span class="block text-xs text-gray-500">{{ __('Area range') }}</span>
                        <div>{{ $visit->customer->details->first()->area_range }} - m<sup>2</sup></div>
                    </div>

                    <div class="p-4 w-1/5">
                        <span class="block text-xs text-gray-500">{{ __('Bedroom') }}</span>
                        <div>{{ $visit->customer->details->first()->bedroom }}</sup></div>
                    </div>

                    <div class="p-4 w-1/5">
                        <span class="block text-xs text-gray-500">{{ __('Bathroom') }}</span>
                        <div>{{ $visit->customer->details->first()->bathroom }}</div>
                    </div>

                    <div class="p-4 w-1/5">
                        <span class="block text-xs text-gray-500">{{ __('Service room') }}</span>
                        <div>{{ $visit->customer->details->first()->service_room ? 'Si' : 'No' }}</div>
                    </div>

                    <div class="p-4 w-1/5">
                        <span class="block text-xs text-gray-500">{{ __('Financing type') }}</span>
                        <div>{{ $visit->type_financing }}</div>
                    </div>
                </div>

                <h2 class="px-4 text-lg pt-10">{{ __('What do we offer you?') }}</h2>
                <hr class="mx-4">

                <div class="flex">
                    <div class="p-4 w-1/4">
                        <span class="block text-xs text-gray-500">{{ __('Project') }}</span>
                        <div>{{ $visit->project->name }}</div>
                    </div>

                    <div class="p-4 w-1/4">
                        <span class="block text-xs text-gray-500">{{ __('Apartment') }}</span>
                        <div>
                            {{ $visit->apartment->name }}:
                            Tipo {{ $visit->apartment->apartmentType->type_name }} -
                            {{ $visit->apartment->apartmentType->roofed_area + $visit->apartment->apartmentType->free_area }} m<sup>2</sup></div>
                    </div>

                    <div class="p-4 w-1/4">
                        <span class="block text-xs text-gray-500">{{ __('Interested?') }}</span>
                        <div>{{ $visit->interested ? 'Si' : 'No' }}</div>
                    </div>

                    <div class="p-4 w-1/4">
                        <span class="block text-xs text-gray-500">{{ __('Financing type') }}</span>
                        <div>{{ $visit->type_financing }}</div>
                    </div>
                </div>

                <div class="flex">
                    @foreach($visit->parkingLots as $key => $value)
                        <div class="p-4 w-1/2">
                            <span class="block text-xs text-gray-500">{{ __('Parking lot') }} {{ $key + 1 }}</span>
                            <div>{{ $value->parkingLot->floor }} - {{ $value->parkingLot->roofed_area + $value->parkingLot->free_area }} m<sup>2</sup></div>
                        </div>
                    @endforeach
                </div>

                <div class="flex">
                    @foreach($visit->closets as $key => $value)
                        <div class="p-4 w-1/2">
                            <span class="block text-xs text-gray-500">{{ __('Closet') }} {{ $key + 1 }}</span>
                            <div>{{ $value->closet->closet }} - {{ $value->closet->roofed_area }} m<sup>2</sup></div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-end">
                    <div class="p-4">
                        <x-link color="gray" href="{{ route('visits.index') }}">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z"/>
                            </svg>
                            {{ __('Back') }}
                        </x-link>
                        @if (is_null($visit->quotation))
                            @unlessrole('admin')
                            <x-link color="green" href="{{ route('visits.quote', $visit->id) }}" target="_blank">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 28 28" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                                {{ __('Generate Quote') }}
                            </x-link>
                            @endunlessrole
                        @endif
                        @unlessrole('admin')
                        <x-link color="blue" href="{{ route('visits.edit', $visit->id) }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                            </svg>
                            {{ __('Edit') }}
                        </x-link>
                        @endunlessrole
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pb-12" id="tracking">
        <livewire:visits.tracking :visit="$visit"/>
    </div>
</x-app-layout>

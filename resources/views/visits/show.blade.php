<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Visit') }}: {{ $visit->project->name }}
        </h2>
    </x-slot>

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
                            {{ $visit->apartment->apartmentType->type_name }}:
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
                        <x-link href="{{ route('visits.index') }}">{{ __('Back') }}</x-link>
                        <x-link href="{{ route('visits.edit', $visit->id) }}">{{ __('Edit') }}</x-link>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pb-12">
        <livewire:visits.tracking :visit="$visit"/>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project') }}: {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex-row p-4">
                    <span class="block text-xs text-gray-500">{{ __('Logo') }}</span>
                    <div class="block">
                        <img src="https://dummyimage.com/200x200/000/fff" alt="{{ $project->name }}">
                    </div>
                </div>

                <div class="flex">
                    <div class="p-4 w-1/2">
                        <span class="block text-xs text-gray-500">{{ __('Name') }}</span>
                        <div>{{ $project->name }}</div>
                    </div>

                    <div class="p-4 w-1/2">
                        <span class="block text-xs text-gray-500">{{ __('Status') }}</span>
                        <div>{{ $project->status }}</div>
                    </div>
                </div>

                <div class="flex">
                    <div class="p-4 w-1/2">
                        <span class="block text-xs text-gray-500">{{ __('District') }}</span>
                        <div>{{ $project->addresses()->whereType('Principal')->firstOrFail()->district->name }}</div>
                    </div>

                    <div class="p-4 w-1/2">
                        <span class="block text-xs text-gray-500">{{ __('Main address') }}</span>
                        <div>{{ $project->addresses()->whereType('Principal')->firstOrFail()->address }}</div>
                    </div>
                </div>

                <div class="flex">
                    <div class="p-4 w-1/2">
                        <span class="block text-xs text-gray-500">{{ __('Financing bank') }}</span>
                        <div>{{ $project->bank->name }} - {{ $project->bank->description }}</div>
                    </div>

                    <div class="p-4 w-1/2">
                        <span class="block text-xs text-gray-500">{{ __('Currency') }}</span>
                        <div>{{ $project->bank->currency }}</div>
                    </div>
                </div>

                <div class="flex">
                    <div class="p-4 w-1/2">
                        <span class="block text-xs text-gray-500">{{ __('Description') }}</span>
                        <div>{!! $project->description !!}</div>
                    </div>

                    <div class="p-4 w-1/2">
                        <span class="block text-xs text-gray-500">{{ __('Legal listing') }}</span>
                        <div>{{ $project->legal }}</div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <div class="p-4">
                        <x-link color="gray" href="{{ route('projects.index') }}">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414 6.414a2 2 0 001.414.586H19a2 2 0 002-2V7a2 2 0 00-2-2h-8.172a2 2 0 00-1.414.586L3 12z"/>
                            </svg>
                            {{ __('Back') }}
                        </x-link>
                        <x-link href="{{ route('projects.edit', $project->id) }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                            </svg>
                            {{ __('Edit') }}
                        </x-link>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pb-12">
        <livewire:projects.addresses :project="$project"/>
    </div>

    <div class="pb-12">
        <livewire:projects.apartment-types :project="$project"/>
    </div>

    <div class="pb-12">
        <livewire:projects.prices :project="$project"/>
    </div>

    <div class="pb-12">
        <livewire:projects.price-apartments :project="$project"/>
    </div>

    <div class="pb-12">
        <livewire:projects.price-parking-lots :project="$project"/>
    </div>

    <div class="pb-12">
        <livewire:projects.price-closets :project="$project"/>
    </div>

    <div class="pb-12">
        <livewire:projects.apartments :project="$project"/>
    </div>

    <div class="pb-12">
        <livewire:projects.parking-lots :project="$project"/>
    </div>

    <div class="pb-12">
        <livewire:projects.closets :project="$project"/>
    </div>

    <div class="pb-12">
        <livewire:projects.documents :project="$project"/>
    </div>
</x-app-layout>

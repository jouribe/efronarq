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
                        <x-link href="{{ route('projects.index') }}">{{ __('Back') }}</x-link>
                        <x-link href="{{ route('projects.edit', $project->id) }}">{{ __('Edit') }}</x-link>
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
        <livewire:projects.price-apartments :project="$project" />
    </div>

    <div class="pb-12">
        <livewire:projects.price-parking-lots :project="$project" />
    </div>
</x-app-layout>

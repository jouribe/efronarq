<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project') }} {{ $project->name }}
        </h2>
    </x-slot>

    <div class="nav-interno">
      <nav class="tabs flex flex-col sm:flex-row">
          <button data-target="panel-1" class="tab active text-gray-600 py-4 px-6 block">
            General
          </button>
          <button data-target="panel-2" class="tab text-gray-600 py-4 px-6 block">
            Tipo de Departamento
          </button>
          <button data-target="panel-3" class="tab text-gray-600 py-4 px-6 block">
            Lista de Precios
          </button>
          <button data-target="panel-4" class="tab text-gray-600 py-4 px-6 block">
            Departamentos
          </button>
          <button data-target="panel-5" class="tab text-gray-600 py-4 px-6 block">
            Estacionamientos
          </button>
          <button data-target="panel-6" class="tab text-gray-600 py-4 px-6 block">
            Closets / Depositos
          </button>
          <button data-target="panel-7" class="tab text-gray-600 py-4 px-6 block">
            Documentos
          </button>
          <button data-target="panel-8" class="tab text-gray-600 py-4 px-6 block">
            Vendedores
          </button>
      </nav>
    </div>
    <div id="panels">
      <div class="panel-1 tab-content active general py-5">
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

        @if(session()->has('message'))
            <div class="py-6 bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 shadow-md" role="alert">
                <div class="flex">
                    <div>
                        <p class="text-sm">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="pb-12">
            <livewire:projects.addresses :project="$project"/>
        </div>
      </div>
      <div class="panel-2 tab-content apartment-types py-5">
        <div class="py-12">
            <livewire:projects.apartment-types :project="$project"/>
        </div>
      </div>
      <div class="panel-3 tab-content prices py-5">
        <div class="py-12">
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
      </div>
      <div class="panel-4 tab-content apartments py-5">
        <div class="py-12">
            <livewire:projects.apartments :project="$project"/>
        </div>
      </div>
      <div class="panel-5 tab-content parking-lots py-5">
        <div class="py-12">
            <livewire:projects.parking-lots :project="$project"/>
        </div>
      </div>
      <div class="panel-6 tab-content closets py-5">
        <div class="py-12">
            <livewire:projects.closets :project="$project"/>
        </div>
      </div>
      <div class="panel-7 tab-content documents py-5">
        <div class="py-12">
            <livewire:projects.documents :project="$project"/>
        </div>
      </div>
      <div class="panel-7 tab-content vendors py-5">
        <p>Vendedores content</p>
      </div>
    </div>
</x-app-layout>

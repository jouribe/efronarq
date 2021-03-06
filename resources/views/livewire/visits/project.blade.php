<div class="flex-row">
    <div class="flex">
        <div class="p-4 w-1/2">
            <x-jet-label for="project_id">{{ __('Project') }}</x-jet-label>
            <x-dropdown-list :items="$projects" id="project_id" name="project_id" wire:model="project_id" required/>
        </div>

        <div class="p-4 w-1/2">
            <x-jet-label for="project_apartment_id">{{ __('Apartment') }}</x-jet-label>
            <x-dropdown-list :items="$apartmentList" id="project_apartment_id" name="project_apartment_id" :selectedId="$visit === null ? '' : $visit->project_apartment_id" required/>
        </div>
    </div>

    <div class="flex">
        <div class="flex-row w-1/2">
            <div class="p-4 w-full">
                <x-jet-label for="project_parking_lot_id.0">{{ __('Parking lot') }}</x-jet-label>
                <div class="flex">
                    <div class="w-full pr-2">
{{--                        <x-dropdown-list :items="$parkingLotList" id="project_parking_lot_id.0" name="project_parking_lot_id[]" wire:model="project_parking_lot_id.0" :selectedId="$visit === null ? '' : $visit->parkingLots->first()->project_parking_lot_id"/>--}}
                        <x-dropdown-list :items="$parkingLotList" id="project_parking_lot_id.0" name="project_parking_lot_id[]" wire:model="project_parking_lot_id.0" />
                    </div>
                    <button wire:click.prevent="addParkingLot({{$i}})" class="border px-4 rounded-lg bg-blue-600 text-xl font-bold text-white">+</button>
                </div>
            </div>

            @foreach($parkingLotDropDowns as $key => $value)
                <div class="p-4 w-full">
                    <x-jet-label for="project_parking_lot_id.{{$value}}">{{ __('Parking lot') }}</x-jet-label>
                    <div class="flex">
                        <div class="w-full pr-2">
                            <x-dropdown-list :items="$parkingLotList" id="project_parking_lot_id.{{$value}}" name="project_parking_lot_id[]" wire:model="project_parking_lot_id.{{$value}}"/>
                        </div>
                        <button wire:click.prevent="removeParkingLot({{$key}})" class="border px-4 rounded-lg bg-red-700 text-xl font-bold text-white">-</button>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="flex-row w-1/2">
            <div class="p-4 w-full">
                <x-jet-label for="project_closet_id.0">{{ __('Closet') }}</x-jet-label>
                <div class="flex">
                    <div class="w-full pr-2">
                        <x-dropdown-list :items="$closetList" id="project_closet_id.0" name="project_closet_id[]" wire:model="project_closet_id.0" />
                    </div>
                    <button wire:click.prevent="addCloset({{$j}})" class="border px-4 rounded-lg bg-blue-600 text-xl font-bold text-white">+</button>
                </div>
            </div>

            @foreach($closetDropDowns as $key => $value)
                <div class="p-4 w-full">
                    <x-jet-label for="project_closet_id.{{$value}}">{{ __('Closet') }}</x-jet-label>
                    <div class="flex">
                        <div class="w-full pr-2">
                            <x-dropdown-list :items="$closetList" id="project_closet_id.{{$value}}" name="project_closet_id[]" wire:model="project_closet_id.{{$value}}"/>
                        </div>
                        <button wire:click.prevent="removeCloset({{$key}})" class="border px-4 rounded-lg bg-red-700 text-xl font-bold text-white">-</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="flex">
        <div class="p-4 w-1/2">
            <x-jet-label for="interested">{{ __('Interested?') }}</x-jet-label>
            <x-dropdown-list :items="$boolList" id="interested" name="interested" wire:model="interested" :selectedId="$visit === null ? '' : $visit->interested" required/>
        </div>

        <div class="p-4 w-1/2">
            <x-jet-label for="discount">{{ __('Discount') }}</x-jet-label>
            <x-dropdown-list :items="$discountList" id="discount" name="discount"/>
        </div>
    </div>

    @if($interested)
        <div class="flex flex-col">
            <h2 class="px-4 text-lg pt-10">{{ __('¿Desea cotizar en otra moneda?') }}</h2>
            <hr class="mx-4 pb-6">

            <div class="px-4 py-2 w-full">
                Moneda actual del proyecto: <strong>{{ $projectCurrency === 'PEN' ? 'Soles (S/.)' : 'Dólares (US$.)' }}</strong>
            </div>

            <div class="p-4 w-1/4">
                <x-jet-label for="exchange">{{ __('Cotizar en otra moneda') }}</x-jet-label>
                <x-dropdown-list :items="$exchangeRateList" id="exchange" required name="exchange"/>
                @error('exchange') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
            </div>

        </div>
    @endif
</div>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(session()->has('message'))
            <div class="p-6 bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 shadow-md mb-8" role="alert">
                <div class="flex">
                    <div>
                        <p class="text-sm">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow mb-10">

            <form wire:submit.prevent="storeGeneralPrice" autocomplete="off">
                <div class="flex-row">
                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="apartmentNro">{{ __('Apartment') }}</x-jet-label>
                            <x-jet-input id="apartmentNro" class="w-full" required wire:model="apartmentNro" readonly/>
                        </div>

                        <div class="p-4 w-1/2">
                            <x-jet-label for="price">{{ __('Price') }}</x-jet-label>
                            <x-jet-input id="price" class="w-full" required wire:model="priceApartmentText" readonly/>
                        </div>
                    </div>

                    @if(!is_null($visit->parkingLots))
                        @foreach($visit->parkingLots as $key => $value)
                            <div class="flex">
                                <div class="p-4 w-1/2">
                                    <label>{{ __('Parking lot') }} {{ $key + 1 }}</label>
                                    <input class="form-input w-full" type="text" value="{{ $value->parkingLot->id }}" readonly>
                                </div>

                                <div class="p-4 w-1/2">
                                    <label>{{ __('Price') }}</label>
                                    <input type="text" class="form-input w-full" value="US$ {{ number_format($value->parkingLot->project->parkingLotPrices->first()->price, 2) }}" readonly>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if(!is_null($visit->closets))
                        @foreach($visit->closets as $key => $value)
                            <div class="flex">
                                <div class="p-4 w-1/2">
                                    <label> {{ __('Closet') }} {{ $key + 1 }}</label>
                                    <input type="text" class="form-input w-full" value="{{ $value->closet->closet }}" readonly>
                                </div>

                                <div class="p-4 w-1/2">
                                    <label>{{ __('Price') }}</label>
                                    <input type="text" class="form-input w-full" value="US$ {{ number_format($value->closet->project->closetPrices->first()->price * $value->closet->roofed_area, 2) }}"
                                           readonly>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="discountType">{{ __('Discount') }}</x-jet-label>
                            <x-dropdown-list :items="$discountList" id="discountType" wire:model="discountType"/>
                        </div>

                        <div class="p-4 w-1/2">
                            <x-jet-label for="amount">{{ __('Amount') }}</x-jet-label>
                            <x-jet-input id="amount" class="w-full" wire:model.debounce.500ms="amount"/>
                        </div>

                    </div>

                    <div class="flex justify-end">
                        <div class="p-4 w-1/2">
                            <label>Total</label>
                            <input type="text" class="form-input w-full" wire:model="priceTotalText" readonly>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <div class="p-4">
                        <x-jet-button>{{ __('Save') }}</x-jet-button>
                    </div>
                </div>
            </form>

        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <form autocomplete="off">
                <div class="flex-col">
                    <div class="p-4 w-1/2">
                        <x-jet-label for="buyerType">{{ __('Buyer Type') }}</x-jet-label>
                        <x-dropdown-list :items="$buyerTypeList" id="buyerType" required wire:model="buyerType"/>
                        @error('buyerType') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex">
                    <div class="flex-row w-1/2">
                        <h2 class="px-4 font-bold">Del Titular</h2>

                        <div class="flex">
                            <div class="p-4 w-1/2">
                                <x-jet-label for="customerFirstName">{{ __('First name') }}</x-jet-label>
                                <x-jet-input id="customerFirstName" class="w-full" required wire:model="customerFirstName"/>
                                @error('customerFirstName') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div class="p-4 w-1/2">
                                <x-jet-label for="customerLastName">{{ __('Last name') }}</x-jet-label>
                                <x-jet-input id="customerLastName" class="w-full" required wire:model="customerLastName"/>
                                @error('customerLastName') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex">
                            <div class="p-4 w-full">
                                <x-jet-label for="customerDocument">{{ __('DNI') }}</x-jet-label>
                                <x-jet-input id="customerDocument" class="w-full" required wire:model="customerDocument"/>
                                @error('customerDocument') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex">
                            <div class="p-4 w-full">
                                <x-jet-label for="customerAddress">{{ __('Address') }}</x-jet-label>
                                <x-jet-input id="customerAddress" class="w-full" required wire:model="customerAddress"/>
                                @error('customerAddress') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex">
                            <div class="p-4 w-full">
                                <x-jet-label for="customerEmail">{{ __('Email') }}</x-jet-label>
                                <x-jet-input id="customerEmail" class="w-full" required wire:model="customerEmail"/>
                                @error('customerEmail') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex">
                            <div class="p-4 w-full">
                                <x-jet-label for="customerPhone">{{ __('Phone') }}</x-jet-label>
                                <x-jet-input id="customerPhone" class="w-full" required wire:model="customerPhone"/>
                                @error('customerPhone') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    @if($buyerType !== 'Soltero(a)')
                        <div class="flex-row w-1/2">
                            <h2 class="px-4 font-bold">De la {{ $buyerType }}</h2>

                            <div class="flex">
                                <div class="p-4 w-1/2">
                                    <x-jet-label for="customerFirstNameSecond">{{ __('First name') }}</x-jet-label>
                                    <x-jet-input id="customerFirstNameSecond" class="w-full" required wire:model="customerFirstNameSecond"/>
                                    @error('customerFirstNameSecond') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>

                                <div class="p-4 w-1/2">
                                    <x-jet-label for="customerLastNameSecond">{{ __('Last name') }}</x-jet-label>
                                    <x-jet-input id="customerLastNameSecond" class="w-full" required wire:model="customerLastNameSecond"/>
                                    @error('customerLastNameSecond') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="flex">
                                <div class="p-4 w-full">
                                    <x-jet-label for="customerDocumentSecond">{{ __('DNI') }}</x-jet-label>
                                    <x-jet-input id="customerDocumentSecond" class="w-full" required wire:model="customerDocumentSecond"/>
                                    @error('customerDocumentSecond') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="flex">
                                <div class="p-4 w-full">
                                    <x-jet-label for="customerAddressSecond">{{ __('Address') }}</x-jet-label>
                                    <x-jet-input id="customerAddressSecond" class="w-full" required wire:model="customerAddressSecond"/>
                                    @error('customerAddressSecond') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="flex">
                                <div class="p-4 w-full">
                                    <x-jet-label for="customerEmailSecond">{{ __('Email') }}</x-jet-label>
                                    <x-jet-input id="customerEmailSecond" class="w-full" required wire:model="customerEmailSecond"/>
                                    @error('customerEmailSecond') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="flex">
                                <div class="p-4 w-full">
                                    <x-jet-label for="customerPhoneSecond">{{ __('Phone') }}</x-jet-label>
                                    <x-jet-input id="customerPhoneSecond" class="w-full" required wire:model="customerPhoneSecond"/>
                                    @error('customerPhoneSecond') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    @endif
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

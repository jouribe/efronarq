<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(session()->has('message'))
            <div class="p-6 bg-blue-100 border-t-4 border-blue-500 rounded-b text-white shadow-md mb-8" role="alert">
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
                            <x-jet-input type="text" id="apartmentNro" class="w-full" required wire:model="apartmentNro" readonly/>
                        </div>

                        <div class="p-4 w-1/2">
                            <x-jet-label for="price">{{ __('Price') }}</x-jet-label>
                            <x-jet-input type="text" id="price" class="w-full" required wire:model="priceApartmentText" readonly/>
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
                            <x-jet-input type="text" id="amount" class="w-full" wire:model.debounce.500ms="discountAmount"/>
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
                        <x-jet-button class="bg-blue-500">{{ __('Save') }}</x-jet-button>
                    </div>
                </div>
            </form>

        </div>

        <div class="bg-white p-6 rounded-lg shadow mb-10">
            <form wire:submit.prevent="storeOwner" autocomplete="off">
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
                                <x-jet-input type="text" id="customerFirstName" class="w-full" required wire:model="customerFirstName"/>
                                @error('customerFirstName') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div class="p-4 w-1/2">
                                <x-jet-label for="customerLastName">{{ __('Last name') }}</x-jet-label>
                                <x-jet-input type="text" id="customerLastName" class="w-full" required wire:model="customerLastName"/>
                                @error('customerLastName') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex">
                            <div class="p-4 w-full">
                                <x-jet-label for="customerDocument">{{ __('DNI') }}</x-jet-label>
                                <x-jet-input type="text" id="customerDocument" class="w-full" required wire:model="customerDocument"/>
                                @error('customerDocument') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex">
                            <div class="p-4 w-full">
                                <x-jet-label for="customerAddress">{{ __('Address') }}</x-jet-label>
                                <x-jet-input type="text" id="customerAddress" class="w-full" wire:model="customerAddress"/>
                                @error('customerAddress') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex">
                            <div class="p-4 w-full">
                                <x-jet-label for="customerEmail">{{ __('Email') }}</x-jet-label>
                                <x-jet-input type="email" id="customerEmail" class="w-full" required wire:model="customerEmail"/>
                                @error('customerEmail') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex">
                            <div class="p-4 w-full">
                                <x-jet-label for="customerPhone">{{ __('Phone') }}</x-jet-label>
                                <x-jet-input type="text" id="customerPhone" class="w-full" required wire:model="customerPhone"/>
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
                                    <x-jet-input type="text" id="customerFirstNameSecond" class="w-full" required wire:model="customerFirstNameSecond"/>
                                    @error('customerFirstNameSecond') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>

                                <div class="p-4 w-1/2">
                                    <x-jet-label for="customerLastNameSecond">{{ __('Last name') }}</x-jet-label>
                                    <x-jet-input type="text" id="customerLastNameSecond" class="w-full" required wire:model="customerLastNameSecond"/>
                                    @error('customerLastNameSecond') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="flex">
                                <div class="p-4 w-full">
                                    <x-jet-label for="customerDocumentSecond">{{ __('DNI') }}</x-jet-label>
                                    <x-jet-input type="text" id="customerDocumentSecond" class="w-full" required wire:model="customerDocumentSecond"/>
                                    @error('customerDocumentSecond') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="flex">
                                <div class="p-4 w-full">
                                    <x-jet-label for="customerAddressSecond">{{ __('Address') }}</x-jet-label>
                                    <x-jet-input type="text" id="customerAddressSecond" class="w-full" required wire:model="customerAddressSecond"/>
                                    @error('customerAddressSecond') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="flex">
                                <div class="p-4 w-full">
                                    <x-jet-label for="customerEmailSecond">{{ __('Email') }}</x-jet-label>
                                    <x-jet-input type="text" id="customerEmailSecond" class="w-full" required wire:model="customerEmailSecond"/>
                                    @error('customerEmailSecond') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="flex">
                                <div class="p-4 w-full">
                                    <x-jet-label for="customerPhoneSecond">{{ __('Phone') }}</x-jet-label>
                                    <x-jet-input type="text" id="customerPhoneSecond" class="w-full" required wire:model="customerPhoneSecond"/>
                                    @error('customerPhoneSecond') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="flex justify-end">
                    <div class="p-4">
                        <x-jet-button class="bg-blue-500">{{ __('Save') }}</x-jet-button>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow mb-10">
            <form wire:submit.prevent="storePullApartFee" autocomplete="off">
                <div class="flex-row">

                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="paymentType">{{ __('Payment type') }}</x-jet-label>
                            <x-dropdown-list :items="$paymentTypeList" id="paymentType" required wire:model="paymentType"/>
                            @error('paymentType') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="p-4 w-1/2">
                            <label>Valor de Venta
                                <Total></Total>
                            </label>
                            <input type="text" class="form-input w-full" wire:model="priceTotalText" readonly>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-1/3">
                            <x-jet-label for="amount">{{ __('Amount pull apart') }}</x-jet-label>
                            <x-jet-input type="text" id="amount" class="w-full" required wire:model="amount"/>
                            @error('amount') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="p-4 w-1/3">
                            <x-jet-label for="amountAt">{{ __('Amount at') }}</x-jet-label>
                            <x-jet-input type="date" id="amountAt" class="w-full" required wire:model="amountAt"/>
                            @error('amountAt') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="p-4 w-1/3">
                            <x-jet-label for="milestone">{{ __('Milestone') }}</x-jet-label>
                            <x-jet-input type="text" id="milestone" class="w-full" wire:model="milestone"/>
                            @error('milestone') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <div class="p-4 w-1/3">
                            <x-jet-label for="balance">{{ __('Balance') }}</x-jet-label>
                            <x-jet-input type="text" id="balance" class="w-full" readonly wire:model="balance"/>
                            @error('balance') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4">
                            <x-jet-label for="feeCount">{{ __('Fee') }}</x-jet-label>
                            <div class="flex">
                                <x-jet-input type="number" id="feeCount" class="w-full" wire:model="feeCount" min="0"/>
                                <x-jet-button type="button" class="bg-blue-500 mt-1 ml-2" wire:click="generateFeeInputs">{{ __('Generate') }}</x-jet-button>
                            </div>
                        </div>
                    </div>

                    @foreach($inputs as $key => $value)
                        <div class="flex">
                            <div class="p-4 w-1/3">
                                <x-jet-label>{{ __('Fee Nro.') }} {{ $key + 1 }}</x-jet-label>
                                <x-jet-input type="text" class="w-full" required wire:model="fee.{{ $value }}"/>
                                @error('amount') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div class="p-4 w-1/3">
                                <x-jet-label>{{ __('Date') }}</x-jet-label>
                                <x-jet-input type="date" class="w-full" required wire:model="feeAt.{{ $value }}"/>
                                @error('amountAt') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div class="p-4 w-1/3">
                                <x-jet-label>{{ __('Milestone') }}</x-jet-label>
                                <x-jet-input type="text" class="w-full" wire:model="feeMilestone.{{ $value }}"/>
                                @error('milestone') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-end">
                    <div class="p-4">
                        <x-jet-button class="bg-blue-500">{{ __('Save') }}</x-jet-button>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow mb-10">
            <form wire:submit.prevent="storeAgreementAndSignMinute" autocomplete="off">
                <div class="flex-row">

                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="separationAgreementAt">{{ __('Separation agreement at') }}</x-jet-label>
                            <x-jet-input type="date" id="separationAgreementAt" class="w-full" required wire:model="separationAgreementAt"/>
                            @error('separationAgreementAt') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="p-4 w-1/2">
                            <x-jet-label for="signatureMinuteAt">{{ __('Signature minute at') }}</x-jet-label>
                            <x-jet-input type="date" id="signatureMinuteAt" class="w-full" required wire:model="signatureMinuteAt"/>
                            @error('signatureMinuteAt') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <div class="p-4">
                        <x-jet-button class="bg-blue-500">{{ __('Save') }}</x-jet-button>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">

            @if(session()->has('sendToApprove'))
                <div class="p-6 bg-blue-100 border-t-4 border-blue-500 rounded-b text-white shadow-md mb-2 mx-4 mt-4" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('sendToApprove') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form wire:submit.prevent="sendToApprove" autocomplete="off">
                <div class="flex-row">
                    <div class="flex">
                        <div class="p-4 w-full">
                            <x-jet-label for="comment">{{ __('Comments') }}</x-jet-label>
                            <textarea type="" id="comment" class="form-textarea mt-1 w-full" wire:model="comment" rows="4"></textarea>
                            @error('comment') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <div class="p-4">
                        <x-jet-button class="bg-blue-500">{{ __('Send to approve') }}</x-jet-button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>

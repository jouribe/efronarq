<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">
            {{ __('Unidades del Proyecto') }}
        </h2>

        <div class="bg-white p-6 rounded-lg shadow mb-10">

            <form wire:submit.prevent="storeGeneralPrice" autocomplete="off">
                <div class="flex-row">
                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="apartmentNro">{{ __('Apartment') }}</x-jet-label>
                            <x-jet-input type="text" id="apartmentNro" class="w-full" required value="{{ $visit->apartment->name }}" readonly/>
                        </div>

                        <div class="p-4 w-1/2">
                            <x-jet-label for="price">{{ __('Price') }}</x-jet-label>
                            <x-jet-input type="text" id="price" class="w-full" required wire:model="priceApartmentText" readonly/>
                        </div>
                    </div>

                    @php
                        $prefix = $visit->project->currency === 'PEN' ? 'S/.' : 'US$.';

                        $exchangeRate = 1;

                        if (!is_null($visit->exchange)) {
                            switch ($prefix) {
                                case 'S/.':
                                    $prefix = 'US$.';
                                    $exchangeRate /= $visit->exchange->sale;
                                    break;
                                case 'US$.':
                                    $prefix = 'S/.';
                                     $exchangeRate *= $visit->exchange->buy;
                                    break;
                            }
                        }
                    @endphp

                    @if(!is_null($visit->parkingLots))
                        @foreach($visit->parkingLots as $key => $value)
                            <div class="flex">
                                <div class="p-4 w-1/2">
                                    <label>{{ __('Parking lot') }} {{ $key + 1 }}</label>
                                    <input class="form-input w-full" type="text" value="{{ $value->parkingLot->parking_lot }}" readonly>
                                </div>

                                <div class="p-4 w-1/2">
                                    <label>{{ __('Price') }}</label>
                                    <input type="text" class="form-input w-full" value="{{ $prefix }} {{ number_format($value->parkingLot->price * $exchangeRate, 2) }}" readonly>
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
                                    <input type="text" class="form-input w-full" value="{{ $prefix }} {{ number_format($value->closet->price * $exchangeRate, 2) }}"
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
                            <x-jet-input type="text" id="discountAmount" class="w-full" wire:model.debounce.500ms="discountAmount"/>
                        </div>

                    </div>

                    <div class="flex justify-end">
                        <div class="p-4 w-1/2">
                            <label>Total</label>
                            <input type="text" class="form-input w-full" wire:model="priceTotalText" readonly>
                        </div>
                    </div>
                </div>

                @if(!is_null($pullApart))
                    @if(($pullApart->status === 'Registrado' || $pullApart->status === 'Rechazado') && auth()->user()->hasRole('vendedor'))
                        <div class="flex justify-end">
                            <div class="p-4">
                                <x-jet-button class="bg-blue-500">{{ __('Save') }}</x-jet-button>
                            </div>
                        </div>
                    @elseif(auth()->user()->hasRole(['admin', 'asistente']) && ($pullApart->status === 'Pendiente Aprobación'))
                        <div class="flex justify-end">
                            <div class="p-4">
                                <x-jet-button class="bg-blue-500">{{ __('Save') }}</x-jet-button>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="flex justify-end">
                        <div class="p-4">
                            <x-jet-button class="bg-blue-500">{{ __('Save') }}</x-jet-button>
                        </div>
                    </div>
                @endif
            </form>

            @if(session()->has('message'))
                <div class="p-6 bg-blue-500 border-t-4 border-blue-800 rounded-b text-white shadow-md mb-2 mx-4 mt-4" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if(!is_null($pullApart))
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">
                {{ __('Datos del Propietario') }}
            </h2>

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
                            @if($buyerType === 'Empresa')
                                <h2 class="px-4 font-bold">Representante</h2>
                            @else
                                <h2 class="px-4 font-bold">Del Titular</h2>
                            @endif

                            @if($buyerType === 'Empresa')
                                <div class="flex">
                                    <div class="p-4 w-full">
                                        <x-jet-label for="customerPosition">{{ __('Cargo') }}</x-jet-label>
                                        <x-jet-input type="text" id="customerPosition" class="w-full" wire:model="customerPosition"/>
                                        @error('customerPosition') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                    </div>

                                </div>
                            @endif

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

                            @if($buyerType === 'Empresa')
                                <div class="p-4 w-full">
                                    <x-jet-label for="statusType">{{ __('Estado civil') }}</x-jet-label>
                                    <x-dropdown-list :items="$statusList" id="statusType" required wire:model="statusType"/>
                                    @error('statusType') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>

                            @endif

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

                            @if($buyerType === 'Empresa')
                                <div class="flex">
                                    <div class="p-4 w-full">
                                        <x-jet-label for="customerDocumentNro">{{ __('N° de partida') }}</x-jet-label>
                                        <x-jet-input type="text" id="customerDocumentNro" class="w-full" wire:model="customerDocumentNro"/>
                                        @error('customerDocumentNro') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if($buyerType !== 'Soltero(a)')
                            <div class="flex-row w-1/2">
                                <h2 class="px-4 font-bold">{{ $buyerType }}</h2>

                                @if ($buyerType !== 'Empresa')

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
                                @else
                                    <div class="flex">
                                        <div class="p-4 w-full">
                                            <x-jet-label for="companyName">{{ __('Razón social') }}</x-jet-label>
                                            <x-jet-input type="text" id="companyName" class="w-full" wire:model="companyName"/>
                                            @error('companyName') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="flex">
                                        <div class="p-4 w-full">
                                            <x-jet-label for="companyTaxNr">{{ __('RUC') }}</x-jet-label>
                                            <x-jet-input type="text" id="companyTaxNr" class="w-full" wire:model="companyTaxNr" max="11"/>
                                            @error('companyTaxNr') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="flex">
                                        <div class="p-4 w-full">
                                            <x-jet-label for="companyAddress">{{ __('Address') }}</x-jet-label>
                                            <x-jet-input type="text" id="companyAddress" class="w-full" wire:model="companyAddress"/>
                                            @error('companyAddress') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="flex">
                                        <div class="p-4 w-full">
                                            <x-jet-label for="companyEmail">{{ __('Email') }}</x-jet-label>
                                            <x-jet-input type="email" id="companyEmail" class="w-full" wire:model="companyEmail"/>
                                            @error('companyEmail') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="flex">
                                        <div class="p-4 w-full">
                                            <x-jet-label for="companyPhone">{{ __('Phone') }}</x-jet-label>
                                            <x-jet-input type="tel" id="companyPhone" class="w-full" wire:model="companyPhone"/>
                                            @error('companyPhone') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                        </div>

                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    @if($buyerType === 'Sociedad Conyugal' || $buyerType === 'Copropietario')
                        <div class="flex">
                            @if($buyerType === 'Sociedad Conyugal')
                                <div class="flex w-1/2">
                                    <div class="p-4 w-full">
                                        <x-jet-label for="partnerType">{{ __('Partner type') }}</x-jet-label>
                                        <x-dropdown-list :items="$partnerTypeList" id="partnerType" required wire:model="partnerType"/>
                                        @error('partnerType') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            @endif

                            @if($partnerType !== 'Tradicional' ||  $buyerType === 'Copropietario')
                                <div class="flex-row w-1/2">
                                    <div class="flex w-full">
                                        <div class="p-4 w-1/4">
                                            <x-jet-label for="partOne">{{ __('Part') }} 1</x-jet-label>
                                            <x-jet-input type="number" id="partOne" class="w-full" required wire:model="partOne" min="0"/>
                                            @error('partOne') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="p-4 w-1/4">
                                            <x-jet-label for="partTwo">{{ __('Part') }} 2</x-jet-label>
                                            <x-jet-input type="number" id="partTwo" class="w-full" required wire:model="partTwo" min="0"/>
                                            @error('partTwo') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="p-4 w-2/4">
                                            <x-jet-label for="documentNro">{{ __('Document Nro') }}</x-jet-label>
                                            <x-jet-input type="text" id="documentNro" class="w-full" required wire:model="documentNro"/>
                                            @error('documentNro') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    @if(!is_null($current_document))
                                        <div class="flex w-full">
                                            <a href="{{ asset('storage/' . $current_document) }}" target="_blank" class="p-4 inline-block hover:text-blue-500">
                                                <svg class="w-7 h-7 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                Documento
                                            </a>
                                        </div>
                                    @endif

                                    <div class="flex w-full">
                                        <div class="p-4 w-full" x-data="{ isUploading: false, progress: 0 }"
                                             x-on:livewire-upload-start="isUploading = true"
                                             x-on:livewire-upload-finish="isUploading = false"
                                             x-on:livewire-upload-error="isUploading = false"
                                             x-on:livewire-upload-progress="progress = $event.detail.progress">
                                            <x-jet-label for="document">{{ __('Document') }}</x-jet-label>
                                            <label
                                                class="w-full flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue-500 hover:text-white">
                                                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"/>
                                                </svg>
                                                <span class="mt-2 text-base leading-normal">{{ __('Select a file') }}</span>
                                                <input type="file" class="hidden" wire:model="document"/>
                                                <input type="hidden" wire:model="current_document">
                                            </label>

                                            @error('blueprint') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror

                                        <!-- Progress Bar -->
                                            <div x-show="isUploading" class="mt-1 flex">
                                                <progress max="100" x-bind:value="progress" class="w-full h-1"></progress>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if(auth()->user()->hasRole('vendedor') && ($pullApart->status === 'Registrado' || $pullApart->status === 'Rechazado') )
                        <div class="flex justify-end">
                            <div class="p-4">
                                <x-jet-button class="bg-blue-500">{{ __('Save') }}</x-jet-button>
                            </div>
                        </div>
                    @elseif(auth()->user()->hasRole(['admin', 'asistente']) && ($pullApart->status === 'Pendiente Aprobación'))
                        <div class="flex justify-end">
                            <div class="p-4">
                                <x-jet-button class="bg-blue-500">{{ __('Save') }}</x-jet-button>
                            </div>
                        </div>
                    @endif
                </form>

                @if(session()->has('customerUpdated'))
                    <div class="p-6 bg-blue-500 border-t-4 border-blue-800 rounded-b text-white shadow-md mb-2 mx-4 mt-4" role="alert">
                        <div class="flex">
                            <div>
                                <p class="text-sm">{{ session('customerUpdated') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">
                {{ __('Forma de Pago') }}
            </h2>

            <div class="bg-white p-6 rounded-lg shadow mb-10">

                <form wire:submit.prevent="storePullApartFee" autocomplete="off">
                    <div class="flex-row">

                        <div class="flex">
                            <div class="p-4 w-1/2">
                                <x-jet-label for="paymentType">{{ __('Payment type') }}</x-jet-label>
                                <x-dropdown-list :items="$paymentTypeList" id="paymentType" required wire:model="paymentType"/>
                                <x-jet-input type="hidden" wire:model="lastPaymentType"/>
                                <x-jet-input type="hidden" wire:model="paymentEdit"/>
                                @error('paymentType') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div class="p-4 w-1/2">
                                <label>Valor de Venta Total</label>
                                <input type="text" class="form-input w-full" wire:model="priceTotalText" readonly>
                            </div>
                        </div>

                        @if($paymentType === 'Hipotecario' || $paymentType === 'Mixto')
                            <div class="flex">
                                <div class="p-4 w-1/3">
                                    <x-jet-label for="bankId">{{ __('Bank') }}</x-jet-label>
                                    <x-dropdown-list :items="$bankList" id="bankId" required wire:model="bankId"/>
                                    @error('bankId') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endif

                        @if($paymentType !== '')
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
                        @endif

                        @if($paymentType === 'Directo')
                            <div class="flex justify-end">
                                <div class="p-4 w-1/3">
                                    <x-jet-label for="balance">{{ __('Balance') }}</x-jet-label>
                                    <x-jet-input type="text" id="balance" class="w-full" readonly wire:model="balance"/>
                                    @error('balance') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endif

                        @if($paymentType === 'Hipotecario' || $paymentType === 'Mixto')
                            <div class="flex">
                                <div class="p-4 w-1/3">
                                    <x-jet-label for="feeBalance">{{ __('Fee balance') }}</x-jet-label>
                                    <x-jet-input type="text" class="w-full" required wire:model="feeBalance"/>
                                    @error('feeBalance') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>

                                <div class="p-4 w-1/3">
                                    <x-jet-label for="feeBalanceAt">{{ __('Date') }}</x-jet-label>
                                    <x-jet-input type="date" class="w-full" wire:model="feeBalanceAt"/>
                                    @error('feeBalanceAt') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>

                                <div class="p-4 w-1/3">
                                    <x-jet-label for="feeBalanceMilestone">{{ __('Milestone') }}</x-jet-label>
                                    <x-jet-input type="text" class="w-full" wire:model="feeBalanceMilestone"/>
                                    @error('feeBalanceMilestone') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="flex">
                                <div class="p-4 w-1/3">
                                    <x-jet-label for="afpAmount">{{ __('AFP amount') }}</x-jet-label>
                                    <x-jet-input type="text" class="w-full" wire:model="afpAmount"/>
                                    @error('afpAmount') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>

                                <div class="p-4 w-1/3">
                                    <x-jet-label for="afpAmountAt">{{ __('Date') }}</x-jet-label>
                                    <x-jet-input type="date" class="w-full" wire:model="afpAmountAt"/>
                                    @error('afpAmountAt') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>

                                <div class="p-4 w-1/3">
                                    <x-jet-label for="afpAmountMilestone">{{ __('Milestone') }}</x-jet-label>
                                    <x-jet-input type="text" class="w-full" wire:model="afpAmountMilestone"/>
                                    @error('afpAmountMilestone') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="flex">
                                <div class="p-4 w-1/3">
                                    <x-jet-label for="creditAmount">{{ __('Credit amount') }}</x-jet-label>
                                    <x-jet-input type="text" class="w-full" required wire:model="creditAmount"/>
                                    @error('creditAmount') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>

                                <div class="p-4 w-1/3">
                                    <x-jet-label for="creditAmountAt">{{ __('Date') }}</x-jet-label>
                                    <x-jet-input type="date" class="w-full" required wire:model="creditAmountAt"/>
                                    @error('creditAmountAt') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>

                                <div class="p-4 w-1/3">
                                    <x-jet-label for="creditAmountMilestone">{{ __('Milestone') }}</x-jet-label>
                                    <x-jet-input type="text" class="w-full" wire:model="creditAmountMilestone"/>
                                    @error('creditAmountMilestone') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endif

                        @if($paymentType === 'Directo' || $paymentType === 'Mixto')
                            <div class="flex">
                                <div class="p-4">
                                    <x-jet-label for="feeCount">{{ __('Fee') }}</x-jet-label>
                                    <div class="flex">
                                        <x-jet-input type="number" id="feeCount" class="w-full" wire:model="feeCount" min="0"/>

                                        @if(auth()->user()->hasRole('vendedor') && ($pullApart->status === 'Registrado' || $pullApart->status === 'Rechazado') )
                                            <x-jet-button type="button" class="bg-blue-500 mt-1 ml-2" wire:click="generateFeeInputs">{{ __('Generate') }}</x-jet-button>
                                        @elseif(auth()->user()->hasRole(['admin', 'asistente']) && ($pullApart->status === 'Pendiente Aprobación'))
                                            <x-jet-button type="button" class="bg-blue-500 mt-1 ml-2" wire:click="generateFeeInputs">{{ __('Generate') }}</x-jet-button>
                                        @endif
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
                        @endif
                    </div>

                    @if(auth()->user()->hasRole('vendedor') && ($pullApart->status === 'Registrado' || $pullApart->status === 'Rechazado') )
                        <div class="flex justify-end">
                            <div class="p-4">
                                <x-jet-button class="bg-blue-500">{{ __('Save') }}</x-jet-button>
                            </div>
                        </div>
                    @elseif(auth()->user()->hasRole(['admin', 'asistente']) && ($pullApart->status === 'Pendiente Aprobación'))
                        <div class="flex justify-end">
                            <div class="p-4">
                                <x-jet-button class="bg-blue-500">{{ __('Save') }}</x-jet-button>
                            </div>
                        </div>
                    @endif
                </form>

                @if(session()->has('amountValidation'))
                    <div class="p-6 bg-red-500 border-t-4 border-red-800 rounded-b text-white shadow-md mb-2 mx-4 mt-4" role="alert">
                        <div class="flex">
                            <div>
                                <p class="text-sm">{{ session('amountValidation') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session()->has('feeSuccess'))
                    <div class="p-6 bg-blue-100 border-t-4 border-blue-500 rounded-b text-white shadow-md mb-2 mx-4 mt-4" role="alert">
                        <div class="flex">
                            <div>
                                <p class="text-sm">{{ session('feeSuccess') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">
                {{ __('Fechas y Modelo de convenio') }}
            </h2>

            <div class="bg-white p-6 rounded-lg shadow mb-10">

                <form wire:submit.prevent="storeAgreementAndSignMinute" autocomplete="off">
                    <div class="flex-row">
                        <div class="flex">
                            <div class="p-4 w-1/3">
                                <x-jet-label for="agreementModel">{{ __('Modelo de convenio') }}</x-jet-label>
                                <x-dropdown-list :items="$agreementModelList" id="agreementModel" required wire:model="agreementModel"/>
                                @error('agreementModel') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div class="p-4 w-1/3">
                                <x-jet-label for="separationAgreementAt">{{ __('Separation agreement at') }}</x-jet-label>
                                <x-jet-input type="date" id="separationAgreementAt" class="w-full" required wire:model="separationAgreementAt"/>
                                @error('separationAgreementAt') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div class="p-4 w-1/3">
                                <x-jet-label for="signatureMinuteAt">{{ __('Signature minute at') }}</x-jet-label>
                                <x-jet-input type="date" id="signatureMinuteAt" class="w-full" required wire:model="signatureMinuteAt"/>
                                @error('signatureMinuteAt') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    @if(auth()->user()->hasRole('vendedor') && ($pullApart->status === 'Registrado' || $pullApart->status === 'Rechazado') )
                        <div class="flex justify-end">
                            <div class="p-4">
                                <x-jet-button class="bg-blue-500">{{ __('Save') }}</x-jet-button>
                            </div>
                        </div>
                    @elseif(auth()->user()->hasRole(['admin', 'asistente']) && ($pullApart->status === 'Pendiente Aprobación'))
                        <div class="flex justify-end">
                            <div class="p-4">
                                <x-jet-button class="bg-blue-500">{{ __('Save') }}</x-jet-button>
                            </div>
                        </div>
                    @endif
                </form>

                @if(session()->has('datesUpdated'))
                    <div class="p-6 bg-blue-500 border-t-4 border-blue-800 rounded-b text-white shadow-md mb-2 mx-4 mt-4" role="alert">
                        <div class="flex">
                            <div>
                                <p class="text-sm">{{ session('datesUpdated') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">
                {{ __('Historial de comentarios') }}
            </h2>

            <div class="mb-10">
                <livewire:tables.pull-apart-comments :pull-apart-id="$pullApart === null ? 0 : $pullApart->id"/>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">

{{--                <form onsubmit="approvePullApart()" autocomplete="off">--}}

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
                            @role('admin')
                            @if(!is_null($pullApart))
                                @if($pullApart->status === 'Pendiente Aprobación')
                                    <x-jet-button type="button" class="bg-red-500" onclick="rejectPullApart()">{{ __('Reject') }}</x-jet-button>
                                    <script>
                                        function rejectPullApart() {
                                            if (confirm('Desea rechazar la separación?')) {
                                                window.livewire.emit('pullApartReject')
                                            }
                                        }
                                    </script>
                                @endif
                            @endif
                            @endrole

                            @if(auth()->user()->hasRole('vendedor') && ($pullApart->status === 'Registrado' || $pullApart->status === 'Rechazado') )
                                <x-jet-button type="button" class="bg-blue-500" onclick="approvePullApart('Confirma que desea enviar a aprobación la separación?')">
                                    {{ __('Send to approve') }}
                                </x-jet-button>
                            @elseif(auth()->user()->hasRole(['admin', 'asistente']) && ($pullApart->status === 'Pendiente Aprobación'))
                                <x-jet-button type="button" class="bg-blue-500" onclick="approvePullApart('Confirma que desea aprobar la separación?')">
                                    {{ __('Approve') }}
                                </x-jet-button>
                            @endif

                            <script>
                                function approvePullApart(msg)
                                {
                                    if(confirm(msg)) {
                                        window.livewire.emit('sendToApprove');
                                    }
                                }
                            </script>
                        </div>
                    </div>
{{--                </form>--}}

                @if(session()->has('sendToApprove'))
                    <div class="p-6 bg-blue-100 border-t-4 border-blue-500 rounded-b text-white shadow-md mb-2 mx-4 mt-4" role="alert">
                        <div class="flex">
                            <div>
                                <p class="text-sm">{{ session('sendToApprove') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif

    </div>
</div>

<div x-data="{ tab: window.location.hash ? window.location.hash.substring(1) : 'tab1' }">
    <div class="nav-ventas mx-auto nav-interno mb-4">
        <nav class="tabs flex flex-col sm:flex-row">
            <a href="#" x-on:click.prevent="tab='tab1'; ; window.location.hash = 'tab1'" class="tab text-gray-600 py-4 px-6 block" :class="{ 'active': tab === 'tab1' }">
                Datos del Propietario
            </a>
            <a href="#" x-on:click.prevent="tab='tab2'; ; window.location.hash = 'tab2'" class="tab text-gray-600 py-4 px-6 block" :class="{ 'active': tab === 'tab2' }">
                Forma de Pago
            </a>
            <a href="#" x-on:click.prevent="tab='tab3'; ; window.location.hash = 'tab3'" class="tab text-gray-600 py-4 px-6 block" :class="{ 'active': tab === 'tab3' }">
                Convenio de Separación
            </a>
            <a href="#" x-on:click.prevent="tab='tab4'; ; window.location.hash = 'tab4'" class="tab text-gray-600 py-4 px-6 block" :class="{ 'active': tab === 'tab4' }">
                Control Documentario
            </a>
            <a href="#" x-on:click.prevent="tab='tab5'; ; window.location.hash = 'tab5'" class="tab text-gray-600 py-4 px-6 block" :class="{ 'active': tab === 'tab5' }">
                Minuta
            </a>
            <a href="#" x-on:click.prevent="tab='tab6'; ; window.location.hash = 'tab6'" class="tab text-gray-600 py-4 px-6 block" :class="{ 'active': tab === 'tab6' }">
                Cambios en Acabados
            </a>
            <a href="#" x-on:click.prevent="tab='tab7'; ; window.location.hash = 'tab7'" class="tab text-gray-600 py-4 px-6 block" :class="{ 'active': tab === 'tab7' }">
                Historial de Pago
            </a>
            <a href="#" x-on:click.prevent="tab='tab8'; ; window.location.hash = 'tab8'" class="tab text-gray-600 py-4 px-6 block" :class="{ 'active': tab === 'tab8' }">
                Entrega
            </a>
        </nav>
    </div>

    <div x-show="tab == 'tab1'" x-cloak class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow mb-10">
            @if(session()->has('customerUpdated'))
                <div class="p-6 bg-blue-500 border-t-4 border-blue-800 rounded-b text-white shadow-md mb-2 mx-4 mt-4" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('customerUpdated') }}</p>
                        </div>
                    </div>
                </div>
            @endif
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

                                        @error('document') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror

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

                <div class="flex justify-end">
                    <div class="p-4">
                        <x-jet-button class="bg-blue-500">{{ __('Save') }}</x-jet-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div x-show="tab == 'tab2'" x-cloak class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow mb-10">
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
                            <label>Valor de Venta
                                <Total></Total>
                            </label>
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

                    {{-- Directo --}}
                    @if($paymentType === 'Directo')
                        <div class="flex justify-end">
                            <div class="p-4 w-1/3">
                                <x-jet-label for="balance">{{ __('Balance') }}</x-jet-label>
                                <x-jet-input type="text" id="balance" class="w-full" readonly wire:model="balance"/>
                                @error('balance') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    @endif

                    {{-- Hipotecario --}}
                    @if($paymentType === 'Hipotecario' || $paymentType === 'Mixto')
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
                    @endif

                    @if($paymentType === 'Directo' || $paymentType === 'Mixto')
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
                    @endif
                </div>

                <div class="flex justify-end">
                    <div class="p-4">
                        <x-jet-button class="bg-blue-500">{{ __('Save') }}</x-jet-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div x-show="tab == 'tab3'" x-cloak class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow mb-10">
            @if(session()->has('quotationValidation'))
                <div class="p-6 bg-blue-500 border-t-4 border-blue-800 rounded-b text-white shadow-md mb-2 mx-4 mt-4" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('quotationValidation') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form wire:submit.prevent="storeQuotation" autocomplete="off">
                <div class="flex-row">
                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="amount">{{ __('Amount pull apart') }}</x-jet-label>
                            <x-jet-input type="text" id="amount" class="w-full" required wire:model="amount"/>
                            @error('amount') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="p-4 w-1/2">
                            <x-jet-label for="signatureMinuteAt">{{ __('Signature minute at') }}</x-jet-label>
                            <x-jet-input type="date" id="signatureMinuteAt" class="w-full" required wire:model="signatureMinuteAt"/>
                            @error('signatureMinuteAt') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-1/2" x-data="{ isUploading: false, progress: 0 }"
                             x-on:livewire-upload-start="isUploading = true"
                             x-on:livewire-upload-finish="isUploading = false"
                             x-on:livewire-upload-error="isUploading = false"
                             x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <x-jet-label for="signedSeparationAgreement">{{ __('Convenio de Separación') }}</x-jet-label>
                            <label
                                class="w-full flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue-500 hover:text-white">
                                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"/>
                                </svg>
                                <span class="mt-2 text-base leading-normal">{{ __('Select a file') }}</span>
                                <input type="file" class="hidden" wire:model="signedSeparationAgreement"/>
                                <input type="hidden" wire:model="currentSignedSeparationAgreement">
                            </label>

                            @error('signedSeparationAgreement') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror

                        <!-- Progress Bar -->
                            <div x-show="isUploading" class="mt-1 flex">
                                <progress max="100" x-bind:value="progress" class="w-full h-1"></progress>
                            </div>
                        </div>

                        <div class="p-4 w-1/2" x-data="{ isUploading: false, progress: 0 }"
                             x-on:livewire-upload-start="isUploading = true"
                             x-on:livewire-upload-finish="isUploading = false"
                             x-on:livewire-upload-error="isUploading = false"
                             x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <x-jet-label for="document">{{ __('Declaración Jurada') }}</x-jet-label>
                            <label
                                class="w-full flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue-500 hover:text-white">
                                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"/>
                                </svg>
                                <span class="mt-2 text-base leading-normal">{{ __('Select a file') }}</span>
                                <input type="file" class="hidden" wire:model="swornDeclaration"/>
                                <input type="hidden" wire:model="currentSwornDeclaration">
                            </label>

                            @error('swornDeclaration') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror

                        <!-- Progress Bar -->
                            <div x-show="isUploading" class="mt-1 flex">
                                <progress max="100" x-bind:value="progress" class="w-full h-1"></progress>
                            </div>
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
    </div>
    <div x-show="tab == 'tab4'" x-cloak class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow mb-10">
            @if(session()->has('documentsControlValidation'))
                <div class="p-6 bg-blue-500 border-t-4 border-blue-800 rounded-b text-white shadow-md mb-2 mx-4 mt-4" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('documentsControlValidation') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form wire:submit.prevent="storeDocumentControl" autocomplete="off">
                <div class="flex-row">
                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="documentControl">{{ __('Tipo de crédito hipotecario') }}</x-jet-label>
                            <x-dropdown-list :items="$documentControlListType" id="documentControl" required wire:model="documentControl"/>
                            @error('documentType') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    @if(!is_null($documentControl))
                        <div class="flex text-xs font-bold">
                            <div class="px-4 w-5/12"></div>
                            <div class="px-4 w-2/12">{{ __('Date') }}</div>
                            <div class="px-4 w-4/12">{{ __('Observación') }}</div>
                            <div class="px-4 w-1/12">{{ __('V. Bueno') }}</div>
                        </div>
                        @foreach($documentControlData as $item)
                            <div class="flex">
                                <div class="flex items-center p-4 w-5/12">
                                    <div class="uppercase text-xs">{{ $item->name }}</div>
                                </div>
                                <div class="p-4 w-2/12">
                                    <x-jet-label for="documentControlDate.{{ $item->id }}" class="hidden">{{ __('Date') }}</x-jet-label>
                                    <x-jet-input type="date" id="documentControlDate.{{ $item->id }}" class="w-full" wire:model="documentControlDate.{{ $item->id }}"/>
                                    <input type="hidden" wire:model="documentControlId.{{ $item->id }}">
                                    @error('documentControlDate') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                                <div class="p-4 w-4/12">
                                    <x-jet-label for="documentoControlObservation.{{ $item->id }}" class="hidden">{{ __('Observation') }}</x-jet-label>
                                    <x-jet-input type="text" id="documentoControlObservation.{{ $item->id }}" class="w-full" wire:model="documentoControlObservation.{{ $item->id }}"/>
                                    @error('documentoControlObservation') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex items-center p-4 w-1/12">
                                    <input type="checkbox" wire:model="documentControlApprove.{{ $item->id }}">
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                @if(!is_null($documentControl))
                    <div class="flex justify-end">
                        <div class="p-4">
                            <x-jet-button class="bg-blue-500">{{ __('Save') }}</x-jet-button>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
    <div x-show="tab == 'tab5'" x-cloak class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow mb-10">
            @if(session()->has('billValidation'))
                <div class="p-6 bg-blue-500 border-t-4 border-blue-800 rounded-b text-white shadow-md mb-2 mx-4 mt-4" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('billValidation') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form wire:submit.prevent="storeSaleBill" autocomplete="off">
                <div class="flex flex-row">
                    <div class="w-1/2">
                        <div class="p-4 w-full">
                            <x-jet-label for="proprietorship">{{ __('Proprietorship') }}</x-jet-label>
                            <x-dropdown-list :items="$proprietorshipList" id="proprietorship" wire:model="proprietorship" selectedId="0"/>
                            @error('proprietorship') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex-row w-full">
                            <div class="px-4 w-full">
                                <x-jet-label>{{ __('Penalidad por daños y perjuicios') }}</x-jet-label>
                            </div>
                            <div class="flex">
                                <div class="px-4 pb-4 w-1/3">
                                    <x-jet-label for="damages">{{ __('%') }}</x-jet-label>
                                    <x-jet-input type="text" id="damages" class="w-full" wire:model="damages"/>
                                    @error('damages') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                                <div class="px-4 pb-4 w-2/3">
                                    <x-jet-label for="damagesStr">{{ __('En letras') }}</x-jet-label>
                                    <x-jet-input type="text" id="damagesStr" class="w-full" wire:model="damagesStr"/>
                                    @error('damagesStr') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex w-full">
                            <div class="flex-row w-full">
                                <div class="px-4 w-full">
                                    <x-jet-label>{{ __('Penalidad por desocupación') }}</x-jet-label>
                                </div>
                                <div class="flex">
                                    <div class="px-4 pb-4 w-1/3">
                                        <x-jet-label for="unemployment">{{ __('Amount') }}</x-jet-label>
                                        <x-jet-input type="text" id="unemployment" class="w-full" wire:model="unemployment"/>
                                        @error('unemployment') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="px-4 pb-4 w-2/3">
                                        <x-jet-label for="unemploymentStr">{{ __('En letras') }}</x-jet-label>
                                        <x-jet-input type="text" id="unemploymentStr" class="w-full" wire:model="unemploymentStr"/>
                                        @error('unemploymentStr') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 w-full">
                            <x-jet-label for="changes">{{ __('Changes') }}</x-jet-label>
                            <x-dropdown-list :items="$changesSelectList" id="changes" wire:model="changes"/>
                            @error('changes') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="p-4 w-full">
                            <x-jet-label for="sanitation">{{ __('Sanitation') }}</x-jet-label>
                            <x-dropdown-list :items="$sanitationSelectList" id="sanitation" wire:model="sanitation"/>
                            @error('sanitation') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="w-1/2">
                        <div class="p-4 w-full">
                            <x-jet-label for="deliveryApartmentAt">{{ __('Fecha de entrega del departamento') }}</x-jet-label>
                            <x-jet-input type="date" id="deliveryApartmentAt" class="w-full" wire:model="deliveryApartmentAt"/>
                            @error('deliveryApartmentAt') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="p-4 w-full">
                            <x-jet-label for="deliveryTerm">{{ __('Plazo de entrega') }}</x-jet-label>
                            <x-dropdown-list :items="$deliveryTermSelectList" id="deliveryTerm" wire:model="deliveryTerm"/>
                            @error('deliveryTerm') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        @if($deliveryTerm)
                            <div class="flex w-full transition-opacity">
                                <div class="p-4 w-1/3">
                                    <x-jet-label for="deliveryTermAmount">{{ __('Monto penalidad') }}</x-jet-label>
                                    <x-jet-input type="text" id="deliveryTermAmount" class="w-full" wire:model="deliveryTermAmount"/>
                                    @error('deliveryTermAmount') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                                <div class="p-4 w-2/3">
                                    <x-jet-label for="deliveryTermAmountStr">{{ __('En letras') }}</x-jet-label>
                                    <x-jet-input type="text" id="deliveryTermAmountStr" class="w-full" wire:model="deliveryTermAmountStr"/>
                                    @error('deliveryTermAmountStr') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endif

                        <div class="p-4 w-full">
                            <x-jet-label for="additionalTerm">{{ __('Plazo adicional') }}</x-jet-label>
                            <x-dropdown-list :items="$additionalTermSelectList" id="additionalTerm" wire:model="additionalTerm"/>
                            @error('additionalTerm') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        @if($additionalTerm)
                            <div class="flex w-full transition-opacity">
                                <div class="p-4 w-1/3">
                                    <x-jet-label for="additionalTermAt">{{ __('Nueva Fecha') }}</x-jet-label>
                                    <x-jet-input type="date" id="additionalTermAt" class="w-full" wire:model="additionalTermAt"/>
                                    @error('additionalTermAt') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                                <div class="p-4 w-1/3">
                                    <x-jet-label for="additionalTermPenalty">{{ __('Monto penalidad') }}</x-jet-label>
                                    <x-jet-input type="text" id="additionalTermPenalty" class="w-full" wire:model="additionalTermPenalty"/>
                                    @error('additionalTermPenalty') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                                <div class="p-4 w-1/3">
                                    <x-jet-label for="additionalTermPenaltyStr">{{ __('En letras') }}</x-jet-label>
                                    <x-jet-input type="text" id="additionalTermPenaltyStr" class="w-full" wire:model="additionalTermPenaltyStr"/>
                                    @error('additionalTermPenaltyStr') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col">
                    <div class="p-4 w-full">
                        <x-jet-label for="footer">{{ __('Footer') }}</x-jet-label>
                        <x-jet-input type="text" id="footer" class="w-full" wire:model="footer"/>
                        @error('footer') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex justify-end">
                    <div class="p-4">
                        <x-jet-button class="bg-blue-500">{{ __('Save') }}</x-jet-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div x-show="tab == 'tab6'" x-cloak class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow mb-10">
            @if(session()->has('changesValidation'))
                <div class="p-6 bg-blue-500 border-t-4 border-blue-800 rounded-b text-white shadow-md mb-2 mx-4 mt-4" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('changesValidation') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            <form wire:submit.prevent="storeChanges" autocomplete="off">
                <div class="flex-row">
                    <div class="flex w-full">
                        <div class="p-4 w-1/2" x-data="{ isUploading: false, progress: 0 }"
                             x-on:livewire-upload-start="isUploading = true"
                             x-on:livewire-upload-finish="isUploading = false"
                             x-on:livewire-upload-error="isUploading = false"
                             x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <x-jet-label for="estimate">{{ __('Presupuesto de cambio') }}</x-jet-label>
                            <label
                                class="w-full flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue-500 hover:text-white">
                                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"/>
                                </svg>
                                <span class="mt-2 text-base leading-normal">{{ __('Select a file') }}</span>
                                <input type="file" class="hidden" wire:model="estimate"/>
                                <input type="hidden" wire:model="currentEstimate">
                            </label>

                            @error('estimate') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror

                        <!-- Progress Bar -->
                            <div x-show="isUploading" class="mt-1 flex">
                                <progress max="100" x-bind:value="progress" class="w-full h-1"></progress>
                            </div>
                        </div>

                        <div class="p-4 w-1/2" x-data="{ isUploading: false, progress: 0 }"
                             x-on:livewire-upload-start="isUploading = true"
                             x-on:livewire-upload-finish="isUploading = false"
                             x-on:livewire-upload-error="isUploading = false"
                             x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <x-jet-label for="blueprint">{{ __('Plano aprobado') }}</x-jet-label>
                            <label
                                class="w-full flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue-500 hover:text-white">
                                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"/>
                                </svg>
                                <span class="mt-2 text-base leading-normal">{{ __('Select a file') }}</span>
                                <input type="file" class="hidden" wire:model="blueprint"/>
                                <input type="hidden" wire:model="currentBlueprint">
                            </label>

                            @error('blueprint') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror

                        <!-- Progress Bar -->
                            <div x-show="isUploading" class="mt-1 flex">
                                <progress max="100" x-bind:value="progress" class="w-full h-1"></progress>
                            </div>
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="changeAmount">{{ __('Monto de cambio') }}</x-jet-label>
                            <x-jet-input type="text" id="changeAmount" class="w-full" wire:model="changeAmount"/>
                            @error('changeAmount') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="p-4 w-1/2">
                            <x-jet-label for="changePaymentAt">{{ __('Fecha de pago de cambio') }}</x-jet-label>
                            <x-jet-input type="date" id="changePaymentAt" class="w-full" wire:model="changePaymentAt"/>
                            @error('changePaymentAt') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="p-4 w-1/2">
                            <x-jet-label for="estimateDays">{{ __('Nro de días adicionales por el cambio') }}</x-jet-label>
                            <x-jet-input type="text" id="estimateDays" class="w-full" wire:model="estimateDays"/>
                            @error('estimateDays') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="p-4 w-1/2">
                            <x-jet-label for="changeDeliveryAt">{{ __('Fecha de entrega') }}</x-jet-label>
                            <x-jet-input type="date" id="changeDeliveryAt" class="w-full" required wire:model="changeDeliveryAt"/>
                            @error('changeDeliveryAt') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <div class="p-4">
                        <x-jet-button class="bg-blue-500">{{ __('Save') }}</x-jet-button>
                    </div>
                </div>

                <div class="w-full p-4">
                    <livewire:tables.pull-apart-changes :pull-apart-id="$pullApart->id"/>
                </div>
            </form>
        </div>
    </div>
    <div x-show="tab == 'tab7'" x-cloak class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow mb-10">
            @if(session()->has('paymentHistoryValidation'))
                <div class="p-6 bg-blue-500 border-t-4 border-blue-800 rounded-b text-white shadow-md mb-2 mx-4 mt-4" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('paymentHistoryValidation') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="flex flex-row">
                <div class="p-4 w-1/2 border-r border-dotted border-black">
                    <h3 class="mb-6">Cronograma establecido</h3>
                    <table class="text-sm w-full">
                        <thead>
                        <tr>
                            <th class="py-2"></th>
                            <th class="py-2">Valor</th>
                            <th class="py-2">F. Cronograma</th>
                            <th class="py-2">F. Pago</th>
                            <th class="py-2">Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pullApart->fees as $item)
                            <tr>
                                <td class="py-2 text-xs">{{ $item->type }}</td>
                                <td class="py-2 text-xs">US$. {{ number_format($item->fee,2) }}</td>
                                <td class="py-2 text-xs">{{  \Carbon\Carbon::parse($item->fee_at)->format('d/m/Y') }}</td>
                                <td class="py-2 text-xs">{{ \Carbon\Carbon::parse($item->payment_at)->format('d/m/Y') }}</td>
                                <td class="py-2 text-xs">
                                    @if($item->pay === 0)
                                        Pendiente
                                    @else
                                        Cancelado
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" class="py-1">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="py-2 text-sm font-bold">Total</td>
                            <td class="p-2 text-center text-sm bg-green-700 text-white font-bold">US$. {{ number_format($pullApart->final_price, 2) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="p-4 w-1/2">
                    <h3 class="mb-6">Pagos realizados</h3>
                    <table class="text-sm w-full">
                        <thead>
                        <tr>
                            <th class="py-2"></th>
                            <th class="py-2">Valor</th>
                            <th class="py-2">F. Pago</th>
                            <th class="py-2"></th>
                        </tr>
                        </thead>
                        <tbody>

                        @php
                            $sumFeeAmount = 0;
                        @endphp

                        @foreach($pullApart->fees as $item)
                            @if($item->payments->count() > 0)
                                @foreach($item->payments as $payment)

                                    @php
                                        $sumFeeAmount += $payment->amount;
                                    @endphp

                                    <tr>
                                        <td class="py-2 text-xs">{{ $item->type }}</td>
                                        <td class="py-2 text-xs">US$. {{ number_format($payment->amount,2) }}</td>
                                        <td class="py-2 text-xs">{{ \Carbon\Carbon::parse($payment->payment_at)->format('d/m/Y') }}</td>
                                        <td class="py-2 text-xs">
                                            <a href="javascript:" wire:click="$emit('editHistoryPayment', {{ $payment->id }})" class="text-xs text-blue-500 hover:text-blue-800 hover:underline">Ver detalle</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                        <tr>
                            <td colspan="4" class="py-1">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="py-2 text-sm font-bold">Total abonado</td>
                            <td class="p-2 text-center text-sm bg-green-700 text-white font-bold">US$. {{ number_format($sumFeeAmount, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 text-sm font-bold">Saldo</td>
                            <td class="p-2 text-center text-sm bg-red-500 text-white font-bold">US$. {{ number_format($pullApart->final_price - $sumFeeAmount, 2) }}</td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="flex flex-row-reverse pt-10">
                        <a href="javascript:" wire:click="addPayment" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 h-10 bg-blue-500">Agregar Pago</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div x-show="tab == 'tab8'" x-cloak class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow mb-10">
            @if(session()->has('saleDeliveryValidation'))
                <div class="p-6 bg-blue-500 border-t-4 border-blue-800 rounded-b text-white shadow-md mb-2 mx-4 mt-4" role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('saleDeliveryValidation') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form wire:submit.prevent="storeSaleDelivery" autocomplete="off">
                <div class="flex flex-col">
                    <div class="flex flex-row">
                        <div class="w-1/2">
                            <div class="p-4 w-full">
                                <x-jet-label for="billDeliveryAt">{{ __('Fecha de entrega según minuta') }}</x-jet-label>
                                <x-jet-input type="date" id="billDeliveryAt" class="w-full" wire:model="billDeliveryAt"/>
                                @error('billDeliveryAt') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>

                        </div>
                        <div class="flex flex-row w-1/2">
                            <div class="p-4 w-1/2">
                                <x-jet-label for="deliveryApartmentDate">{{ __('Fecha') }}</x-jet-label>
                                <x-jet-input type="date" id="deliveryApartmentDate" class="w-full" required wire:model="deliveryApartmentDate"/>
                                @error('deliveryApartmentDate') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                            <div class="p-4 w-1/2">
                                <x-jet-label for="deliveryApartmentTime">{{ __('Hora') }}</x-jet-label>
                                <x-jet-input type="time" id="deliveryApartmentTime" class="w-full" required wire:model="deliveryApartmentTime"/>
                                @error('deliveryApartmentTime') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row">
                        <div class="w-1/2">
                            <div class="p-4 w-full">
                                <x-jet-label for="executive">{{ __('Encargado') }}</x-jet-label>
                                <x-jet-input type="text" id="executive" class="w-full" wire:model="executive"/>
                                @error('executive') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="w-1/2">
                        <div class="p-4 w-full" x-data="{ isUploading: false, progress: 0 }"
                             x-on:livewire-upload-start="isUploading = true"
                             x-on:livewire-upload-finish="isUploading = false"
                             x-on:livewire-upload-error="isUploading = false"
                             x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <x-jet-label for="evidence">{{ __('Evidencia') }}</x-jet-label>
                            <label
                                class="w-full flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue-500 hover:text-white">
                                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"/>
                                </svg>
                                <span class="mt-2 text-base leading-normal">{{ __('Select a file') }}</span>
                                <input type="file" class="hidden" wire:model="evidence"/>
                                <input type="hidden" wire:model="currentEvidence">
                            </label>

                            @error('evidence') <span class="text-red-600 text-xs font-bold">{{ $message }}</span> @enderror

                        <!-- Progress Bar -->
                            <div x-show="isUploading" class="mt-1 flex">
                                <progress max="100" x-bind:value="progress" class="w-full h-1"></progress>
                            </div>
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
    </div>

    @if($isOpen)
        @include('sales.modals.payments')
    @endif
</div>

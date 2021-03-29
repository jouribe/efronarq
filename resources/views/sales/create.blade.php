<x-app-layout>
    <!--suppress BladeUnknownComponentInspection -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add') }} {{ __('Sale') }}
        </h2>
    </x-slot>

    <div class="py-12 top-ventas">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow mb-10">
                <form wire:submit.prevent="storeOwner" autocomplete="off">
                    <div class="flex-row">
                        <div class="flex">
                            <div class="mx-auto sm:px-6 lg:px-6 p-4 w-1/2">
                                <fieldset>
                                    <legend class="text-gray-800">Detalle de la venta</legend>
                                    <p>Propietario (s):</p>
                                    <div class="datos">
                                        @if($pullApart->buyer_type === 'Soltero(a)')
                                            <p>{{ $pullApart->visit->customer->full_name }}</p>
                                            <p>DNI: {{ $pullApart->visit->customer->dni }} / Telf.: {{ $pullApart->visit->customer->phone }}</p>
                                        @else
                                            <p>{{ $pullApart->visit->customer->full_name }}</p>
                                            <p>DNI: {{ $pullApart->visit->customer->dni }} / Telf.: {{ $pullApart->visit->customer->phone }}</p>
                                            <br>
                                            @php
                                                $related = \App\Models\Customer::where('id', $pullApart->visit->customer->related->first()->customer_related_id)->first();
                                            @endphp
                                            <p>{{ $related->full_name }}</p>
                                            <p>DNI: {{ $related->dni }} / Telf.: {{ $related->phone }}</p>

                                        @endif
                                    </div>
                                    <p>Estado:</p>
                                    <div class="estado">
                                        <p>Minuta Pendiente de Aprobación</p>
                                    </div>
                                    <div class="acciones">
                                        <a href="{{ asset('storage/' . $pullApart->agreement) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 h-10 bg-blue-500">Ver Cotización</a>
                                        @if($pullApart->is_sale === 1)
                                            <form action="{{ route('sales.destroy', $pullApart->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 h-10 bg-blue-500">Anular Venta</button>
                                            </form>
                                        @endif
                                    </div>
                                </fieldset>
                            </div>
                            <div class="mx-auto sm:px-6 lg:px-6 p-4 w-1/2">
                                <fieldset>
                                    <legend class="text-gray-800">Resumen de la Venta</legend>
                                    <p>Proyecto: {{ $pullApart->visit->project->name }}</p>
                                    <div class="tabla">
                                        <table cellspadding="0" celspacind="0" border="0">
                                            <tbody>
                                            <tr>
                                                <td>Departamento</td>
                                                <td>{{ $pullApart->visit->apartment->name }}</td>
                                                <td> @if($pullApart->visit->project->currency === 'PEN') S/. @else US$. @endif {{ number_format($pullApart->visit->apartment->price, 2) }}</td>
                                            </tr>
                                            @if($pullApart->visit->parkingLots->count() > 0)
                                                @foreach($pullApart->visit->parkingLots as $parking)
                                                    <tr>
                                                        <td>Estacionamiento</td>
                                                        <td>{{ $parking->parkingLot->parking_lot }}</td>
                                                        <td>@if($pullApart->visit->project->currency === 'PEN') S/. @else US$. @endif {{ number_format($parking->parkingLot->price, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            @if($pullApart->visit->closets->count() > 0)
                                                @foreach($pullApart->visit->closets as $storage)
                                                    <tr>
                                                        <td>Depósito</td>
                                                        <td>{{ $storage->closet->closet }}</td>
                                                        <td>@if($pullApart->visit->project->currency === 'PEN') S/. @else US$. @endif {{ number_format($storage->closet->price, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <tr>
                                                <td>Total</td>
                                                <td></td>
                                                <td>@if($pullApart->visit->project->currency === 'PEN') S/. @else US$. @endif {{ number_format($pullApart->final_price,2) }}</td>
                                            </tr>
                                            @php
                                                $currentAmount = 0;

                                                if($pullApart->fees->first()->payments->count() > 0) {
                                                    foreach ($pullApart->fees->first()->payments as $pay) {
                                                        $currentAmount += $pay->amount;
                                                    }
                                                }
                                            @endphp
                                            <tr>
                                                <td>Abonado</td>
                                                <td></td>
                                                <td>@if($pullApart->visit->project->currency === 'PEN') S/. @else US$. @endif {{ number_format($currentAmount, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td>Pendiente</td>
                                                <td></td>
                                                <td>@if($pullApart->visit->project->currency === 'PEN') S/. @else US$. @endif {{ number_format($pullApart->final_price - $currentAmount ,2) }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <br />
                                    @if($pullApart->changes()->count() > 0)
                                        <p>Cambios Adicionales</p>
                                        <div class="tabla">
                                        <table cellspadding="0" celspacind="0" border="0">
                                            <tbody>
                                            <tr>
                                                <td>Pisos</td>
                                                <td>100,000</td>
                                            </tr>
                                            <tr>
                                                <td>Tope de Cocina</td>
                                                <td>50,000</td>
                                            </tr>
                                            <tr>
                                                <td>Total</td>
                                                <td>150,000</td>
                                            </tr>
                                            <tr>
                                                <td>Abonado</td>
                                                <td>50,000</td>
                                            </tr>
                                            <tr>
                                                <td>Pendiente</td>
                                                <td>100,000</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <livewire:sales.create :visit="$pullApart->visit" />
    </div>
</x-app-layout>

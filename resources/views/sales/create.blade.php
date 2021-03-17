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
                                        <p>Juan Pérez Rodriguez</p>
                                        <p>DNI: 45585415 / Telf.: 958456235</p>
                                        <br>
                                        <p>Juan Pérez Rodriguez</p>
                                        <p>DNI: 45585415 / Telf.: 958456235</p>
                                    </div>
                                    <p>Estado:</p>
                                    <div class="estado">
                                        <p>Minuta Pendiente de Aprobación</p>
                                    </div>
                                    <div class="acciones">
                                        <button type="button" name="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 h-10 bg-blue-500">Ver Cotización</button>
                                        <button type="button" name="button" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 h-10 bg-blue-500">Anular Venta</button>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="mx-auto sm:px-6 lg:px-6 p-4 w-1/2">
                                <fieldset>
                                    <legend class="text-gray-800">Resumen de la Venta</legend>
                                    <p>Proyecto: Mirador</p>
                                    <div class="tabla">
                                        <table cellspadding="0" celspacind="0" border="0">
                                            <tbody>
                                            <tr>
                                                <td>Departamento</td>
                                                <td>101</td>
                                                <td>101,000</td>
                                            </tr>
                                            <tr>
                                                <td>Estacionamiento</td>
                                                <td>10</td>
                                                <td>50,000</td>
                                            </tr>
                                            <tr>
                                                <td>Depósito</td>
                                                <td>04</td>
                                                <td>10,000</td>
                                            </tr>
                                            <tr>
                                                <td>Total</td>
                                                <td></td>
                                                <td>161,000</td>
                                            </tr>
                                            <tr>
                                                <td>Abonado</td>
                                                <td></td>
                                                <td>50,000</td>
                                            </tr>
                                            <tr>
                                                <td>Pendiente</td>
                                                <td></td>
                                                <td>110,000</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <br />
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

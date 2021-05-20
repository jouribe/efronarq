<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectApartment;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Prices extends LivewireDatatable
{
    public $searchable = 'projects.name, project_apartments.name, project_apartment_types.type_name, project_apartment_types.bedroom';

    public $exportable = false;

    public function builder()
    {
        return ProjectApartment::query()
            ->join('projects', 'project_apartments.project_id', 'projects.id')
            ->join('project_apartment_types', 'project_apartments.apartment_type_id', 'project_apartment_types.id')
            ->groupBy('project_apartments.id', 'project_apartments.name', 'project_apartment_types.type_name',
                'project_apartment_types.bedroom', 'project_apartment_types.roofed_area', 'project_apartment_types.free_area',
                'project_apartment_types.blueprint', 'project_apartments.price', 'project_apartments.availability', 'projects.currency',
                'projects.name');
    }

    /** @noinspection ClassMethodNameMatchesFieldNameInspection */
    public function columns(): array
    {
        return [
            Column::name('project_apartments.id')
                ->label('ID')
                ->hide(),

            Column::name('projects.name')
                ->label(__('Project'))
                ->filterable(),

            Column::name('project_apartments.name')
                ->label(__('Apartment')),

            Column::name('project_apartment_types.type_name')
                ->label(__('Type')),

            Column::name('project_apartment_types.bedroom')
                ->label('Nro. Dormitorios'),

            Column::name('project_apartment_types.roofed_area')
                ->label('A. Techada (m2)'),

            Column::name('project_apartment_types.free_area')
                ->label('A. Libre (m2)'),

            Column::callback(['project_apartment_types.roofed_area', 'project_apartment_types.free_area'], function ($roofed, $free) {
                return number_format($roofed + $free, 2);
            })
                ->label('A. Total (m2)'),

            Column::callback('project_apartment_types.blueprint', function ($blueprint) {
                return '<a href="/storage/' . $blueprint . '" class="text-blue-500" target="_blank">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.75 13.25L18 12C19.6569 10.3431 19.6569 7.65685 18 6C16.3431 4.34314 13.6569 4.34314 12 5.99999L10.75 7.25" stroke="#141414" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M7.25003 10.75L6.00003 12C4.34317 13.6569 4.34317 16.3431 6.00003 18C7.65688 19.6569 10.3432 19.6569 12 18L13.25 16.75" stroke="#141414" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M14.25 9.75L9.75 14.25" stroke="#141414" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>';
            })
                ->label(__('Blueprint')),

            Column::callback([
                'project_apartments.price',
                'project_apartments.availability',
                'projects.currency'
            ],
                function ($price, $availability, $currency) {

                    $prefix = $currency === 'PEN' ? 'S/. ' : 'US$. ';

                    switch ($availability) {
                        case "Vendido":
                        case "Separado":
                            return strtoupper($availability);
                        default:
                            return $prefix . number_format($price, 2);
                    }
                })
                ->label('Precio venta'),

            Column::callback([
                'project_apartments.price',
                'project_apartments.availability',
                'projects.currency',
                'project_apartment_types.roofed_area'
            ],
                function ($price, $availability, $currency, $roofed) {

                    $prefix = $currency === 'PEN' ? 'S/. ' : 'US$. ';

                    switch ($availability) {
                        case "Vendido":
                        case "Separado":
                            return strtoupper($availability);
                        default:
                            return $prefix . number_format($price, 2);
                    }
                })
                ->label('Precio construcción'),

            Column::callback([
                'project_apartments.price',
                'project_apartments.availability',
                'projects.currency',
                'project_apartment_types.free_area'
            ],
                function ($price, $availability, $currency, $free) {

                    $prefix = $currency === 'PEN' ? 'S/. ' : 'US$. ';

                    switch ($availability) {
                        case "Vendido":
                        case "Separado":
                            return strtoupper($availability);
                        default:
                            return $prefix . number_format($price, 2);
                    }
                })
                ->label('Precio entrega')
        ];
    }
}

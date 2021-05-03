<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectApartment;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Prices extends LivewireDatatable
{
    public $searchable = 'project_apartments.name, project_apartment_types.type_name, project_apartment_types.bedroom';

    public $exportable = true;

    public function builder()
    {
        return ProjectApartment::query()
            ->join('projects', 'project_apartments.project_id', 'projects.id')
            ->join('project_apartment_types', 'project_apartments.apartment_type_id', 'project_apartment_types.id')
            ->groupBy('project_apartments.id', 'project_apartments.name', 'project_apartment_types.type_name',
                'project_apartment_types.bedroom', 'project_apartment_types.roofed_area', 'project_apartment_types.free_area',
                'project_apartment_types.blueprint', 'project_apartments.price', 'project_apartments.availability', 'projects.currency');
    }

    /** @noinspection ClassMethodNameMatchesFieldNameInspection */
    public function columns(): array
    {
        return [
            Column::name('project_apartments.id')
                ->label('ID')
                ->hide(),

            Column::name('project_apartments.name')
                ->label(__('Apartment'))
                ->filterable(),

            Column::name('project_apartment_types.type_name')
                ->label(__('Type'))
                ->filterable(),

            Column::name('project_apartment_types.bedroom')
                ->label('Nro. Dormitorios'),

            Column::name('project_apartment_types.roofed_area')
                ->label('A. Techada (m2)')
                ->filterable(),

            Column::name('project_apartment_types.free_area')
                ->label('A. Libre (m2)')
                ->filterable(),

            Column::callback(['project_apartment_types.roofed_area', 'project_apartment_types.free_area'], function ($roofed, $free) {
                return number_format($roofed + $free, 2);
            })
                ->label('A. Total (m2)'),

            Column::callback('project_apartment_types.blueprint', function ($blueprint) {
                return '<a href="storage/' . $blueprint . '" class="text-blue-500">Ver plano</a>';
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
                ->label('Precio venta')
                ->filterable(),

            //            Column::callback([
            //                'project_apartments.price',
            //                'project_apartments.availability',
            //                'projects.currency'
            //            ],
            //                function ($price, $availability, $currency) {
            //
            //                    $prefix = $currency === 'PEN' ? 'S/. ' : 'US$. ';
            //
            //                    return $prefix . number_format($price, 2);
            //                })
            //                ->label('Precio construcción'),
            //
            //            Column::callback([
            //                'project_apartments.price',
            //                'project_apartments.availability',
            //                'projects.currency'
            //            ],
            //                function ($price, $availability, $currency) {
            //
            //                    $prefix = $currency === 'PEN' ? 'S/. ' : 'US$. ';
            //
            //                    return $prefix . number_format($price, 2);
            //                })
            //                ->label('Precio entrega')
        ];
    }
}

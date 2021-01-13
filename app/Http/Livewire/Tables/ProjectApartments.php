<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectApartment;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ProjectApartments extends LivewireDatatable
{
    public $model = ProjectApartment::class;

    public $searchable = 'availability, order, start_floor';

    public function builder()
    {
        return ProjectApartment::query()
            ->leftJoin('project_apartment_types', 'project_apartment_types.id', 'project_apartments.apartment_type_id')
            ->leftJoin('project_price_apartments', 'project_price_apartments.project_apartment_type_id', 'project_apartment_types.id')
            ->groupBy('availability', 'project_apartment_types.type_name', 'start_floor', 'project_apartment_types.roofed_area', 'project_apartment_types.free_area',
                'project_price_apartments.price_area', 'parking_lots', 'closets', 'order', 'id');
    }

    public function columns()
    {
        return [
            Column::name('availability')
                ->label(__('Availability')),

            Column::name('project_apartment_types.type_name')
                ->label(__('Type')),

            Column::name('start_floor')
                ->label(__('Floor')),

            Column::callback('project_apartment_types.type_name', function ($type_name) {
                return $type_name;
            })
                ->label(__('Apartment name')),

            Column::callback([
                'project_price_apartments.price_area',
                'project_apartment_types.roofed_area',
                'project_apartment_types.free_area'
            ], function ($price, $roofed, $free) {
                return '<pre>US$ ' . number_format($price * ($roofed + $free), 2) . '</pre>';
            })
                ->label(__('Sale value')),

            Column::name('parking_lots')
                ->label(__('Parking lots')),

            Column::name('closets')
                ->label(__('Closets')),

            Column::name('order')
                ->label(__('Order')),

            Column::name('id')
                ->label(__('Actions'))
                ->view('projects.actions.apartment')
        ];
    }
}

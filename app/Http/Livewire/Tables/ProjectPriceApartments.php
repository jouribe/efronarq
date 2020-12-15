<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectPriceApartment;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ProjectPriceApartments extends LivewireDatatable
{
    public $model = ProjectPriceApartment::class;

    public $searchable = 'project_apartment_types.type_name';

    public function builder()
    {
        return ProjectPriceApartment::query()
            ->leftJoin('project_apartment_types', 'project_apartment_types.id', 'project_price_apartments.project_apartment_type_id')
            ->groupBy('start_floor', 'end_floor', 'price_area', 'project_apartment_types.type_name', 'project_price_apartments.id');
    }

    public function columns()
    {
        return [
            Column::name('project_apartment_types.type_name')
                ->label(__('Type')),

            Column::name('start_floor')
                ->label(__('Start floor')),

            Column::name('end_floor')
                ->label(__('Start floor')),

            Column::callback('price_area', function ($price_area) {
                return '<code>US$ ' . number_format($price_area, 2) . ' m<sup>2</sup></code>';
            })
                ->label(__('Price area')),

            Column::name('project_price_apartments.id')
                ->label(__('Actions'))
                ->view('projects.actions.priceApartment')
        ];
    }
}

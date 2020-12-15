<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectApartmentType;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class ProjectApartmentTypes extends LivewireDatatable
{
    public $model = ProjectApartmentType::class;

    public $searchable = "type_name";

    public function columns()
    {
        return [
            Column::name('type_name')
                ->label(__('Name')),

            Column::callback('roofed_area', function ($roofed_area) {
                return '<code>' . $roofed_area . ' m<sup>2</sup></code>';
            })
                ->label(__('Roofed area')),

            Column::callback('free_area', function ($free_area) {
                return '<code>' . $free_area . ' m<sup>2</sup></code>';
            })
                ->label(__('Free area')),

            Column::name('view')
                ->label(__('View')),

            NumberColumn::name('bedroom')
                ->label(__('Bedroom')),

            NumberColumn::name('bathroom')
                ->label(__('Bathroom')),

            Column::callback('blueprint', function ($blueprint) {
                return '<a href="javascript:">VER</a>';
            })
                ->label(__('Blueprint')),

            BooleanColumn::name('service_room')
                ->label(__('Service room')),

            Column::name('id')
                ->label(__('Actions'))
                ->view('projects.actions.apartmentType')
        ];
    }
}

<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectPriceParkingLot;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ProjectPriceParkingLots extends LivewireDatatable
{
    public $model = ProjectPriceParkingLot::class;

    public $searchable = 'type';

    public function columns()
    {
        return [
            Column::name('floor')
                ->label(__('Floor')),

            Column::name('type')
                ->label(__('Type')),

            Column::callback('price', function ($price) {
                return '<pre>US$ ' . number_format($price) . '</pre>';
            })
                ->label(__('Price')),

            Column::name('id')
                ->label(__('Actions'))
                ->view('projects.actions.priceParkingLot')
        ];
    }
}

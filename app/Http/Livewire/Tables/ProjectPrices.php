<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectPrice;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ProjectPrices extends LivewireDatatable
{
    public $model = ProjectPrice::class;

    public function columns()
    {
        return [
            Column::callback('free_area', function ($free_area) {
                return '<code>' . $free_area . ' %</sup></code>';
            })
                ->label('Factor ' . __('Free area')),

            Column::callback('discount_presale', function ($discount_presale) {
                return '<code>' . $discount_presale . ' %</sup></code>';
            })
                ->label('Factor ' . __('Discount presale')),

            Column::callback('delivery_increment', function ($delivery_increment) {
                return '<code>' . $delivery_increment . ' %</sup></code>';
            })
                ->label('Factor ' . __('Delivery increment')),

            Column::callback('parking_discount', function ($parking_discount) {
                return '<code>' . $parking_discount . ' %</sup></code>';
            })
                ->label(__('Parking discount')),

            Column::callback('currency', function ($currency) {
                return $currency === 'USD'
                    ? '<span>Dólares</span>'
                    : '<span>Soles</span>';
            })
            ->label(__('Currency')),

            Column::name('id')
                ->label(__('Actions'))
                ->view('projects.actions.prices')
        ];
    }
}

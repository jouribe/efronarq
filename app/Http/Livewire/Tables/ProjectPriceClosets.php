<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectPriceCloset;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ProjectPriceClosets extends LivewireDatatable
{
    public $model = ProjectPriceCloset::class;

    public function columns()
    {
        return [
            Column::callback('price', function ($price) {
                return '<pre>US$ ' . number_format($price, 2) . '</pre>';
            })
                ->label(__('Storage or closet value per area') . ' (m2)'),

            Column::name('id')
                ->label(__('Actions'))
                ->view('projects.actions.priceCloset')
        ];
    }
}

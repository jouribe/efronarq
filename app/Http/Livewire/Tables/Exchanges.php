<?php

namespace App\Http\Livewire\Tables;

use App\Models\Exchange;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class Exchanges extends LivewireDatatable
{
    /**
     * @var mixed $hideable
     */
    public $hideable = 'add-modal';

    /**
     * @var mixed $event
     */
    public $event = 'createExchange';

    /**
     * @var bool $hideCreate
     */
    public bool $hideCreate = false;

    /**
     * @var mixed $customExport
     */
    public $customExport = false;

    public function builder()
    {
        return Exchange::query();
    }

    public function columns()
    {
        return [
            DateColumn::name('created_at')
                ->label(__('Fecha de registro')),

            NumberColumn::name('buy')
                ->label(__('Compra')),

            NumberColumn::name('sale')
                ->label(__('Venta')),

            Column::name('id')
                ->label(__('Actions'))
                ->view('exchanges.actions.exchange')

        ];
    }
}

<?php

namespace App\Http\Livewire\Tables;

use App\Models\Origin;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Origins extends LivewireDatatable
{
    /**
     * @var mixed $hideable
     */
    public $hideable = 'add-modal';

    /**
     * @var mixed $event
     */
    public $event = 'createOrigin';

    /**
     * @var bool $hideCreate
     */
    public bool $hideCreate = false;

    /**
     * @var mixed $searchable
     */
    public $searchable = 'name';

    /**
     * @var mixed $customExport
     */
    public $customExport = false;

    public function builder()
    {
        return Origin::query();
    }

    public function columns()
    {
        return [
            Column::callback('id', function ($id) {
                return $id;
            })
                ->label(__('ID')),

            Column::name('name')
                ->label(__('Name')),

            Column::name('id')
                ->label(__('Actions'))
                ->view('origins.actions.origin')
        ];
    }
}

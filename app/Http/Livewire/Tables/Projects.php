<?php

namespace App\Http\Livewire\Tables;

use App\Models\Project;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class Projects extends LivewireDatatable
{
     /**
     * @var string $model
     */
    public $model = Project::class;

    /**
     * @var string $searchable
     */
    public $searchable = "name";

    /**
     * @var bool $exportable
     */
    public $exportable = true;

    /**
     * @var string $sort
     */
    public $sort = "name|asc";

    public function columns()
    {
        return [
            NumberColumn::name('id')
                ->label('ID')
                ->hide(),

            Column::name('name')
                ->label(__('Name')),

            Column::name('status')
                ->label(__('Status')),

            DateColumn::name('created_at')
                ->label(__('Created At'))
        ];
    }
}

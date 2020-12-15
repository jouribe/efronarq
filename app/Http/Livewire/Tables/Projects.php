<?php

namespace App\Http\Livewire\Tables;

use App\Models\Project;
use Carbon\Carbon;
use Mediconesystems\LivewireDatatables\BooleanColumn;
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

            Column::callback(['status'], function ($status) {
                return '<code class="text-sm">' . $status . '</code>';
            })
                ->label(__('Status')),

            BooleanColumn::callback(['is_active'], function ($is_active) {
                return !$is_active
                    ? '<span class="text-red-500 font-bold">' . __('No') . '</span>'
                    : '<span class="text-green-500 font-bold">' . __('Yes') . '</span>';
            })
                ->label(__('Active?')),

            DateColumn::callback(['created_at'], function ($created_at) {
                return '<code class="text-gray-400">' . Carbon::createFromDate($created_at)->format('d/m/Y H:i:s') . '</code>';
            })
                ->label(__('Created At')),

            Column::name('projects.id')
                ->label(__('Actions'))
                ->view('components.table-actions')
        ];
    }
}

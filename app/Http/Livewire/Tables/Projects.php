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
     * @var mixed $model
     */
    public $model = Project::class;

    /**
     * @var mixed $searchable
     */
    public $searchable = "name";

    /**
     * @var mixed $exportable
     */
    public $exportable = false;

    /**
     * @var mixed $sort
     */
    public $sort = "name|asc";

    /**
     * @var mixed $hideable
     */
    public $hideable = 'add';

    /**
     * @var mixed
     */
    public $route;

    /**
     * @var bool $isAdmin
     */
    public bool $isAdmin;

    /**
     * Table columns
     *
     * @return array
     *
     * @noinspection ClassMethodNameMatchesFieldNameInspection
     */
    public function columns(): array
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

            BooleanColumn::callback(['is_active', 'id'], function ($is_active, $id) {
                return !$is_active
                    ? '<a class="text-red-500 font-bold" href="javascript:" wire:click="active('.$id.')">' . __('No') . '</a>'
                    : '<a class="text-green-500 font-bold" href="javascript:" wire:click="active('.$id.')">' . __('Yes') . '</a>';
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

    /**
     * Update project status
     *
     * @param $id
     */
    public function active($id): void
    {
        $project = Project::whereId($id);

        $project->update([
            'is_active' => !$project->first()->is_active
        ]);
    }
}

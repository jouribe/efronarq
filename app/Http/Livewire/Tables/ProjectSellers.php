<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectSeller;
use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ProjectSellers extends LivewireDatatable
{
    /**
     * @var mixed $projectId
     */
    public $projectId;

    /**
     * @var mixed $searchable
     */
    public $searchable = 'users.name';

    /**
     * @var mixed $hideable
     */
    public $hideable = 'add-modal';

    /**
     * @var mixed $event
     */
    public $event = 'createSellers';

    /**
     * @var bool $hideCreate
     */
    public bool $hideCreate = false;

    /**
     * @var bool $isAdmin
     */
    public bool $isAdmin;

    /**
     * Build query
     *
     * @return Builder
     */
    public function builder(): Builder
    {
        return ProjectSeller::query()
            ->leftJoin('users', 'project_sellers.user_id', 'users.id')
            ->Where('project_sellers.project_id', $this->projectId)
            ->groupBy('users.name', 'project_sellers.profit_percentage', 'project_sellers.id');
    }

    /**
     * Table columns
     *
     * @return array
     * @noinspection ClassMethodNameMatchesFieldNameInspection
     */
    public function columns(): array
    {
        return [
            Column::name('users.name')
                ->label(__('Name')),

            Column::callback('project_sellers.profit_percentage', function ($profit) {
                return '<span>' . $profit . ' %</span>';
            })
                ->label(__('Profit')),

            Column::name('project_sellers.id')
                ->label(__('Actions'))
                ->view('projects.actions.sellers')
        ];
    }
}

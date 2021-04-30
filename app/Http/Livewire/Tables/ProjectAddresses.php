<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectAddress;
use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ProjectAddresses extends LivewireDatatable
{
    /**
     * @var mixed $projectId
     */
    public $projectId;

    /**
     * @var mixed $model
     */
    public $model = ProjectAddress::class;

    /**
     * @var mixed $searchable
     */
    public $searchable = 'districts.name';

    /**
     * @var mixed $sort
     */
    public $sort = 'districts.name|asc';

    /**
     * @var mixed $hideable
     */
    public $hideable = 'add-modal';

    /**
     * @var mixed $event
     */
    public $event = 'createAddress';

    /**
     * @var bool $hideCreate
     */
    public bool $hideCreate = false;

    /**
     * @var bool $isAdmin
     */
    public bool $isAdmin;

    /**
     * Query builder.
     *
     * @return Builder
     */
    public function builder(): Builder
    {
        return ProjectAddress::query()
            ->leftJoin('districts', 'districts.id', 'project_addresses.district_id')
            ->where('type', '<>', 'Principal')
            ->whereProjectId($this->projectId)
            ->groupBy('project_addresses.id', 'districts.name', 'type', 'address');
    }

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
            Column::name('type')
                ->label(__('Type')),

            Column::name('districts.name')
                ->label(__('District')),

            Column::name('address')
                ->label(__('Address')),

            Column::name('project_addresses.id')
                ->label(__('Actions'))
                ->view('projects.actions.address')
        ];
    }
}

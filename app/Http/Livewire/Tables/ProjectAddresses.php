<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectAddress;
use Illuminate\Database\Eloquent\Builder;
use LaravelIdea\Helper\App\Models\_ProjectAddressQueryBuilder;
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
     * Query builder.
     *
     * @return Builder|_ProjectAddressQueryBuilder
     */
    public function builder(): Builder|_ProjectAddressQueryBuilder
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

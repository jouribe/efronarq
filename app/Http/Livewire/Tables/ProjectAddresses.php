<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectAddress;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ProjectAddresses extends LivewireDatatable
{
    /**
     * @var string $model
     */
    public $model = ProjectAddress::class;

    /**
     * @var string $searchable
     */
    public $searchable = 'districts.name';

    /**
     * @var string $sort
     */
    public $sort = 'districts.name|asc';

    public function builder()
    {
        return ProjectAddress::query()
            ->leftJoin('districts', 'districts.id', 'project_addresses.district_id')
            ->where('type', '<>', 'Principal')
            ->groupBy('project_addresses.id', 'districts.name', 'type', 'address');
    }

    public function columns()
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

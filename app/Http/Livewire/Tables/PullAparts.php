<?php

namespace App\Http\Livewire\Tables;

use App\Models\PullApart;
use Illuminate\Database\Eloquent\Builder;
use LaravelIdea\Helper\App\Models\_PullApartQueryBuilder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class PullAparts extends LivewireDatatable
{
    /**
     * @var mixed $model
     */
    public $model = PullApart::class;

    /**
     * @var mixed $searchable
     */
    public $searchable = 'id';

    /**
     * Query builder
     *
     * @return Builder|_PullApartQueryBuilder
     */
    public function builder(): Builder|_PullApartQueryBuilder
    {
        return PullApart::query()
            ->leftJoin('visits', 'pull_aparts.visit_id', 'visits.id')
            ->leftJoin('customers', 'visits.customer_id', 'customers.id')
            ->leftJoin('projects', 'visits.project_id', 'projects.id')
            ->leftJoin('project_apartments', 'visits.project_apartment_id', 'project_apartments.id')
            ->leftJoin('project_apartment_types', 'project_apartments.apartment_type_id', 'project_apartment_types.id')
            ->groupBy('visits.id', 'projects.name', 'customers.first_name', 'customers.last_name', 'project_apartment_types.type_name');
    }

    /**
     * Columns
     *
     * @return array
     *
     * @noinspection ClassMethodNameMatchesFieldNameInspection
     */
    public function columns(): array
    {
        return [
            Column::name('visits.id')
                ->label(__('ID')),

            Column::name('projects.name')
                ->label(__('Project')),

            Column::callback(['customers.first_name', 'customers.last_name'], function ($firstName, $lastName) {
                return $firstName . ' ' . $lastName;
            })
                ->label(__('Project')),

            Column::name('project_apartment_types.type_name')
                ->label(__('Apartment')),

            Column::callback(['visits.id'], function ($id) {
                return '<a href="' . route('pull-apart.create', ['visitId' => $id]) . '">Ver</a>';
            })
                ->label(__('Action'))
        ];
    }
}

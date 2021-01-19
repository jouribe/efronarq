<?php

namespace App\Http\Livewire\Tables;

use App\Models\Visit;
use Illuminate\Database\Eloquent\Builder;
use LaravelIdea\Helper\App\Models\_VisitQueryBuilder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class VisitPullAparts extends LivewireDatatable
{
    /**
     * @var mixed $model
     */
    public $model = Visit::class;

    /**
     * @var mixed $searchable
     */
    public $searchable = 'visits.id';

    /**
     * Query builder.
     *
     * @return Builder|_VisitQueryBuilder
     */
    public function builder(): _VisitQueryBuilder|Builder
    {
        return Visit::query()
            ->leftJoin('projects', 'visits.project_id', 'projects.id')
            ->leftJoin('customers', 'visits.customer_id', 'customers.id')
            ->leftJoin('project_apartments', 'visits.project_apartment_id', 'project_apartments.id')
            ->leftJoin('project_apartment_types', 'project_apartments.apartment_type_id', 'project_apartment_types.id')
            ->where('visits.status', 'Cotización')
            ->groupBy('visits.id', 'projects.name', 'customers.first_name', 'customers.last_name', 'project_apartments.name');
    }

    /**
     * Table columns.
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
                ->label(__('Name')),

            Column::callback(['customers.first_name', 'customers.last_name'], function ($firstName, $lastName) {
                return "{$firstName} {$lastName}";
            })
                ->label(__('Customer')),

            Column::name('project_apartments.name')
                ->label(__('Apartment')),

            Column::callback('visits.id', function ($id) {
                return '<a class="text-blue-600 hover:text-blue-800" href="' . route('pull-apart.create', ['visitId' => $id]) . '">Separar</a>';
            })
        ];
    }
}

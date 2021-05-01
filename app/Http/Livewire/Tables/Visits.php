<?php

namespace App\Http\Livewire\Tables;

use App\Models\Visit;
use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Visits extends LivewireDatatable
{
    /**
     * @var mixed $model
     */
    public $model = Visit::class;

    /**
     * @var mixed $searchable
     */
    public $searchable = 'projects.name, customers.full_name, origins.name, visits.status';

    /**
     * @var mixed $exportable
     */
    public $exportable = true;

    /**
     * @var mixed $route
     */
    public $route;

    /**
     * @var mixed $hideable
     */
    public $hideable = 'add';

    /**
     * @var bool $isAdmin
     */
    public bool $isAdmin;

    /**
     * Table builder.
     *
     * @return Builder
     */
    public function builder(): Builder
    {
        return Visit::query()
            //->leftJoin('visit_tracking', 'visit_tracking.visit_id', 'visits.id')
            ->leftJoin('projects', 'visits.project_id', 'projects.id')
            ->leftJoin('customers', 'visits.customer_id', 'customers.id')
            ->leftJoin('origins', 'visits.origin_id', 'origins.id')
            ->leftJoin('project_apartments', 'visits.project_apartment_id', 'project_apartments.id')
            ->leftJoin('project_apartment_types', 'project_apartments.apartment_type_id', 'project_apartment_types.id')
            //->latestTracking()
            ->onlyForMe()
            ->groupBy('visits.id', 'visits.created_at', 'projects.name', 'customers.full_name', 'origins.name', 'visits.interested',
                'visits.status', 'project_apartments.name',
            //'visit_tracking.action', 'visit_tracking.action_at', 'visit_tracking.status'
            );
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
            Column::callback('visits.id', function ($id) {
                return $id;
            })
                ->label(__('ID')),

            DateColumn::name('visits.created_at')
                ->label(__('Visit date'))
                ->filterable(),

            Column::name('customers.full_name')
                ->label(__('Customer')),

            Column::name('projects.name')
                ->label(__('Project'))
                ->filterable(),

            Column::name('origins.name')
                ->label(__('Origin'))
                ->filterable(),

            Column::name('project_apartments.name')
                ->label(__('Apartment')),

            Column::callback('visits.interested', function ($interested) {
                return $interested ? '<span class="font-bold text-green-600">Si</span>' : '<span class="font-bold text-red-600">No</span>';
            })
                ->label(__('Interested')),

            //            Column::name('visit_tracking.action')
            //                ->label(__('Next action')),
            //
            //            DateColumn::name('visit_tracking.action_at')
            //                ->label(__('Action at')),
            //
            //            Column::name('visit_tracking.status')
            //                ->label(__('Action status')),

            Column::name('visits.status')
                ->label(__('Status'))
                ->filterable(),

            Column::name('visits.id')
                ->label(__('Actions'))
                ->view('visits.actions.table-actions')
        ];
    }
}

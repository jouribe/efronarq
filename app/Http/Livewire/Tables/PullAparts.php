<?php

namespace App\Http\Livewire\Tables;

use App\Models\PullApart;
use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
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
    public $searchable = 'visits.id, projects.name, customers.full_name, pull_aparts.status';

    /**
     * @var mixed $hideable
     */
    public $hideable = 'add-pull-apart';

    /**
     * Query builder
     *
     * @return Builder
     */
    public function builder(): Builder
    {
        return PullApart::query()
            ->leftJoin('visits', 'pull_aparts.visit_id', 'visits.id')
            ->leftJoin('customers', 'visits.customer_id', 'customers.id')
            ->leftJoin('projects', 'visits.project_id', 'projects.id')
            ->leftJoin('project_apartments', 'visits.project_apartment_id', 'project_apartments.id')
            ->leftJoin('project_apartment_types', 'project_apartments.apartment_type_id', 'project_apartment_types.id')
            ->onlyForMe()
            ->isNotASale()
            ->groupBy('visits.id', 'projects.name', 'customers.full_name', 'project_apartments.name',
                'pull_aparts.status', 'pull_aparts.created_at');
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
        /** @noinspection DuplicatedCode */
        return [
            Column::name('visits.id')
                ->label(__('Quotation')),

            Column::name('projects.name')
                ->label(__('Project')),

            Column::name('customers.full_name')
                ->label(__('Customer')),

            Column::name('project_apartments.name')
                ->label(__('Apartment')),

            DateColumn::name('pull_aparts.created_at')
                ->label(__('Pull apart at')),

            Column::callback(['visits.id'], function ($id) {
                return '<a href="' . route('pull-apart.create', ['visitId' => $id]) . '" class="inline-block p-1 text-yellow-600 hover:bg-yellow-600 hover:text-white rounded">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                            </svg>
                        </a>';
            })
                ->label(__('Actions')),

            Column::name('pull_aparts.status')
                ->label(__('Status'))
        ];
    }
}

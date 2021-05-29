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
     * @var bool $isAdmin
     */
    public bool $isAdmin;

    /**
     * @var mixed $customExport
     */
    public $customExport = false;

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
            ->leftJoin('users', 'visits.user_id', 'users.id')
            ->onlyForMe()
            ->isNotASale()
            ->groupBy('visits.id', 'projects.name', 'customers.full_name', 'project_apartments.name',
                'pull_aparts.status', 'pull_aparts.created_at', 'pull_aparts.agreement', 'users.name');
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
        $columns = [
            Column::name('visits.id')
                ->label(__('Quotation')),

            Column::name('projects.name')
                ->label(__('Project'))
                ->filterable(),

            Column::name('customers.full_name')
                ->label(__('Customer'))
                ->filterable(),

            Column::name('project_apartments.name')
                ->label(__('Apartment'))
                ->filterable(),

            DateColumn::name('pull_aparts.created_at')
                ->label(__('Pull apart at'))
                ->filterable(),

            Column::callback(['visits.id', 'pull_aparts.status', 'pull_aparts.agreement'], function ($id, $status, $agreement) {
                $actions = '';

                /** @noinspection NullPointerExceptionInspection */
                if (auth()->user()->hasRole('vendedor')) {
                    switch ($status) {
                        case "Rechazado":
                        case "Registrado":
                            $actions = '<a href="' . route('pull-apart.create', ['visitId' => $id]) . '" class="inline-block p-1 text-yellow-600 hover:bg-yellow-600 hover:text-white rounded">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </a>';
                            break;
                        case "Aprobado":
                        case "Pendiente Aprobación":
                            $actions = '<a href="' . route('pull-apart.create', ['visitId' => $id]) . '" class="inline-block p-1 text-yellow-600 hover:bg-yellow-600 hover:text-white rounded">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                            </svg>
                        </a>';
                            break;
                    }
                } /** @noinspection NullPointerExceptionInspection */ elseif (auth()->user()->hasRole('admin')) {
                    switch ($status) {
                        case "Pendiente Aprobación":
                            $actions = '<a href="' . route('pull-apart.create', ['visitId' => $id]) . '" class="inline-block p-1 text-yellow-600 hover:bg-yellow-600 hover:text-white rounded">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </a>';
                            break;
                        case "Registrado":
                        case "Aprobado":
                        case "Rechazado":
                            $actions = '<a href="' . route('pull-apart.create', ['visitId' => $id]) . '" class="inline-block p-1 text-yellow-600 hover:bg-yellow-600 hover:text-white rounded">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                            </svg>
                        </a>';
                            break;
                    }
                }

                if ($status === 'Aprobado' && ($agreement !== null || $agreement !== '')) {
                    $actions .= '<a href="storage/' . $agreement . '" class="inline-block p-1 text-green-600 hover:bg-green-600 hover:text-white rounded" target="_blank" title="Cotización">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
</svg>
                        </a>';
                }

                return $actions;
            })
                ->label(__('Actions')),

            Column::name('pull_aparts.status')
                ->label(__('Status'))
                ->filterable()
        ];

        /** @noinspection NullPointerExceptionInspection */
        if(auth()->user()->hasRole(['admin', 'user'])) {
            array_unshift($columns, Column::name('users.name')->label('Vendedor')->filterable());
        }

        return $columns;
    }
}

<?php

namespace App\Http\Livewire\Tables;

use App\Models\PullApart;
use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class PullApartSales extends LivewireDatatable
{
    /**
     * @var mixed $model
     */
    public $model = PullApart::class;

    /**
     * @var mixed $searchable
     */
    public $searchable = 'pull_aparts.id, projects.name, customers.full_name';

    /**
     * Query builder.
     *
     * @return Builder
     */
    public function builder() : Builder
    {
        return PullApart::query()
            ->leftJoin('visits', 'pull_aparts.visit_id', 'visits.id')
            ->leftJoin('projects', 'visits.project_id', 'projects.id')
            ->leftJoin('customers', 'visits.customer_id', 'customers.id')
            ->leftJoin('project_apartments', 'visits.project_apartment_id', 'project_apartments.id')
            ->leftJoin('project_apartment_types', 'project_apartments.apartment_type_id', 'project_apartment_types.id')
            //->whereNotIn('visits.id', DB::table('pull_aparts')->select('visit_id'))
            //->where('visits.status', 'Cotización')
            ->onlyForMe()
            ->selectableForSale()
            ->groupBy('pull_aparts.id', 'projects.name', 'customers.first_name', 'customers.full_name', 'project_apartments.name',
                'project_apartments.price');
    }

    /**
     * Table columns.
     *
     * @return array
     * @noinspection ClassMethodNameMatchesFieldNameInspection
     */
    public function columns(): array
    {
        /** @noinspection DuplicatedCode */
        return [
            Column::name('pull_aparts.id')
                ->label(__('Quotation')),

            Column::name('projects.name')
                ->label(__('Project')),

            Column::name('customers.full_name')
                ->label(__('Customer')),

            Column::name('project_apartments.name')
                ->label(__('Apartment')),

            Column::callback(['project_apartments.price'], function ($apartmentPrice) {
                return '<code> US$ ' . number_format($apartmentPrice, 2) . '</code>';
            })
                ->label(__('Total')),

            Column::callback('pull_aparts.id', function ($id) {
                return '<a class="text-blue-500 hover:text-blue-800" href="' . route('sales.create', ['pullApartId' => $id]) . '">Vender</a>';
            })
                ->label(__('Actions'))
        ];
    }
}

<?php

namespace App\Http\Livewire\Tables;

use App\Models\Visit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
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
    public $searchable = 'visits.id, projects.name, customers.full_name';

    /**
     * @var mixed $customExport
     */
    public $customExport = false;

    /**
     * Query builder.
     *
     * @return Builder
     */
    public function builder(): Builder
    {
        return Visit::query()
            ->leftJoin('projects', 'visits.project_id', 'projects.id')
            ->leftJoin('customers', 'visits.customer_id', 'customers.id')
            ->leftJoin('project_apartments', 'visits.project_apartment_id', 'project_apartments.id')
            ->leftJoin('project_apartment_types', 'project_apartments.apartment_type_id', 'project_apartment_types.id')
            ->leftJoin('pull_aparts', 'visits.id', 'pull_aparts.visit_id')
            ->leftJoin('exchanges', 'visits.exchange_id', 'exchanges.id')
            ->whereNotIn('visits.id', DB::table('pull_aparts')->select('visit_id'))
            ->where('visits.status', 'Cotización')
            ->onlyForMe()
            ->groupBy('visits.id', 'projects.name', 'customers.first_name', 'customers.full_name', 'project_apartments.name',
                'project_apartments.price', 'visits.exchange_id', 'projects.currency', 'exchanges.sale', 'exchanges.buy');
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
            Column::name('visits.id')
                ->label(__('ID')),

            Column::name('projects.name')
                ->label(__('Project')),

            Column::name('customers.full_name')
                ->label(__('Customer')),

            Column::name('project_apartments.name')
                ->label(__('Apartment')),

            Column::callback([
                'project_apartments.price',
                'visits.exchange_id',
                'projects.currency',
                'exchanges.sale',
                'exchanges.buy'
            ], function ($apartmentPrice, $exchange, $currency, $sale, $buy) {

                $prefix = $currency === 'PEN' ? 'S/.' : 'US$.';

                $exchangeRate = 1;

                if (!is_null($exchange)) {
                    switch ($prefix) {
                        case 'S/.':
                            $prefix = 'US$.';
                            $exchangeRate /= $sale;
                            break;
                        case 'US$.':
                            $prefix = 'S/.';
                            $exchangeRate *= $buy;
                            break;
                    }
                }


                return '<code>' . $prefix . number_format($apartmentPrice * $exchangeRate, 2) . '</code>';
            })
                ->label(__('Total')),

            Column::callback('visits.id', function ($id) {
                return '<a class="text-blue-500 hover:text-blue-800" href="' . route('pull-apart.create', ['visitId' => $id]) . '">Separar</a>';
            })
                ->label(__('Actions'))
        ];
    }
}

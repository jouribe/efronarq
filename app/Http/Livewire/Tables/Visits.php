<?php

namespace App\Http\Livewire\Tables;

use App\Models\Visit;
use Carbon\Carbon;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Visits extends LivewireDatatable
{
    /**
     * @var string $model
     */
    public $model = Visit::class;

    /**
     * @var string
     */
    public $searchable = 'projects.name, customers.first_name, customers.last_name, origins.name, visits.status';

    /**
     * @var bool $exportable
     */
    public $exportable = true;

    /**
     * Table builder.
     */
    public function builder()
    {
        return Visit::query()
            ->leftJoin('projects', 'visits.project_id', 'projects.id')
            ->leftJoin('customers', 'visits.customer_id', 'customers.id')
            ->leftJoin('origins', 'visits.origin_id', 'origins.id')
            ->leftJoin('project_apartments', 'projects.id', 'project_apartments.project_id')
            ->groupBy('visits.id', 'visits.created_at', 'projects.name', 'customers.first_name', 'customers.last_name', 'origins.name', 'visits.interested', 'visits.status');
    }

    public function columns()
    {
        return [
            Column::callback('created_at', function ($created) {
                return '<pre>' . Carbon::parse($created)->format('d/m/Y') . '</pre>';
            })
                ->label(__('Visit date')),

            Column::callback(['customers.first_name', 'customers.last_name'], function ($first_name, $last_name) {
                return $first_name . ' ' . $last_name;
            })
                ->label(__('Name')),

            Column::name('projects.name')
                ->label(__('Project')),

            Column::name('origins.name')
                ->label(__('Origin')),

            Column::callback('visits.interested', function ($interested) {
                return $interested ? '<span class="font-bold text-green-600">Si</span>' : '<span class="font-bold text-red-600">No</span>';
            })
                ->label(__('Interested')),

            Column::name('visits.status')
                ->label(__('Status')),

            Column::name('visits.id')
                ->label(__('Actions'))
                ->view('visits.actions.table-actions')
        ];
    }
}

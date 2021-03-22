<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectApartment;
use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ProjectApartments extends LivewireDatatable
{
    /**
     * @var mixed $projectId
     */
    public $projectId;

    /**
     * @var mixed $searchable
     */
    public $searchable = 'availability, order, start_floor, project_apartments.name';

    /**
     * @var mixed $hideable
     */
    public $hideable = 'add-modal';

    /**
     * @var mixed $event
     */
    public $event = 'createApartments';

    /**
     * @var bool $hideCreate
     */
    public bool $hideCreate = false;

    /**
     * Query Builder
     *
     * @return Builder
     */
    public function builder(): Builder
    {
        return ProjectApartment::query()
            ->leftJoin('project_apartment_types', 'project_apartment_types.id', 'project_apartments.apartment_type_id')
            ->leftJoin('project_price_apartments', function ($join) {
                $join->on('project_price_apartments.project_apartment_type_id', 'project_apartment_types.id');
            })
            ->where('project_apartments.project_id', $this->projectId)
            ->groupBy('availability', 'project_apartment_types.type_name', 'start_floor', 'project_apartment_types.roofed_area', 'project_apartment_types.free_area',
                'project_price_apartments.price_area', 'parking_lots', 'closets', 'order', 'id', 'project_apartments.name', 'project_apartments.price');
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
            Column::name('availability')
                ->label(__('Availability')),

            Column::name('project_apartment_types.type_name')
                ->label(__('Type')),

            Column::name('start_floor')
                ->label(__('Floor')),

            Column::name('project_apartments.name')
                ->label(__('Apartment name')),

            Column::callback('project_apartments.price', function ($price) {
                return '<pre>US$ ' . number_format((float)$price, 2) . '</pre>';
            })
                ->label(__('Sale value')),

            Column::name('parking_lots')
                ->label(__('Parking lots')),

            Column::name('closets')
                ->label(__('Closets')),

            Column::name('order')
                ->label(__('Order')),

            Column::name('id')
                ->label(__('Actions'))
                ->view('projects.actions.apartment')
        ];
    }
}

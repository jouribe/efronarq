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
     * @var bool $isAdmin
     */
    public bool $isAdmin;

    /**
     * @var mixed $customExport
     */
    public $customExport = false;

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
            ->leftJoin('projects', 'project_apartments.project_id', 'projects.id')
            ->where('project_apartments.project_id', $this->projectId)
            ->groupBy('project_apartments.availability', 'project_apartment_types.type_name', 'project_apartments.start_floor',
                'project_apartment_types.roofed_area', 'project_apartment_types.free_area', 'project_price_apartments.price_area',
                'project_apartments.parking_lots', 'project_apartments.closets', 'project_apartments.order', 'project_apartments.id',
                'project_apartments.name', 'project_apartments.price', 'projects.currency')
            ->distinct();
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
            Column::name('project_apartments.availability')
                ->label(__('Availability')),

            Column::name('project_apartment_types.type_name')
                ->label(__('Type')),

            Column::name('project_apartments.start_floor')
                ->label(__('Floor')),

            Column::name('project_apartments.name')
                ->label(__('Apartment name')),

            Column::callback(['project_apartments.price', 'projects.currency'], function ($price, $currency) {
                $prefix = $currency === 'PEN' ? 'S/. ' : 'US$. ';

                return '<pre>' . $prefix . number_format((float)$price, 2) . '</pre>';
            })
                ->label(__('Sale value')),

            Column::name('project_apartments.parking_lots')
                ->label(__('Parking lots')),

            Column::name('project_apartments.closets')
                ->label(__('Closets')),

            Column::name('project_apartments.order')
                ->label(__('Order')),

            Column::name('project_apartments.id')
                ->label(__('Actions'))
                ->view('projects.actions.apartment')
        ];
    }
}

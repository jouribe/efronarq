<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectPriceApartment;
use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ProjectPriceApartments extends LivewireDatatable
{
    /**
     * @var mixed $projectId
     */
    public $projectId;

    /**
     * @var mixed $searchable
     */
    public $searchable = 'project_apartment_types.type_name';

    /**
     * @var mixed $hideable
     */
    public $hideable = 'add-modal';

    /**
     * @var mixed $event
     */
    public $event = 'createPriceApartment';

    /**
     * @var bool $hideCreate
     */
    public bool $hideCreate = false;

    /**
     * @var bool $isAdmin
     */
    public bool $isAdmin;

    /**
     * Query Builder
     *
     * @return Builder
     */
    public function builder(): Builder
    {
        return ProjectPriceApartment::query()
            ->leftJoin('project_apartment_types', 'project_apartment_types.id', 'project_price_apartments.project_apartment_type_id')
            ->leftJoin('projects', 'project_apartment_types.project_id', 'projects.id')
            ->where('project_price_apartments.project_id', $this->projectId)
            ->groupBy('start_floor', 'end_floor', 'price_area', 'project_apartment_types.type_name', 'project_price_apartments.id',
                'projects.currency');
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
            Column::name('project_apartment_types.type_name')
                ->label(__('Type')),

            Column::name('start_floor')
                ->label(__('Start floor')),

            Column::name('end_floor')
                ->label(__('End floor')),

            Column::callback(['price_area', 'projects.currency'], function ($price_area, $currency) {
                $prefix = $currency === 'PEN' ? 'S/. ' : 'US$. ';

                return '<code>' . $prefix . number_format($price_area, 2) . ' x M<sup>2</sup></code>';
            })
                ->label(__('Price area')),

            Column::name('project_price_apartments.id')
                ->label(__('Actions'))
                ->view('projects.actions.priceApartment')
        ];
    }
}

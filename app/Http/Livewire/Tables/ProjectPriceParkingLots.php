<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectPriceParkingLot;
use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ProjectPriceParkingLots extends LivewireDatatable
{
    /**
     * @var mixed $projectId
     */
    public $projectId;

    /**
     * @var mixed $searchable
     */
    public $searchable = 'type';

    /**
     * @var mixed $hideable
     */
    public $hideable = 'add-modal';

    /**
     * @var mixed $event
     */
    public $event = 'createPriceParkingLot';

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
     * Query Builder.
     *
     * @return Builder
     */
    public function builder(): Builder
    {
        return ProjectPriceParkingLot::query()
            ->leftJoin('projects', 'project_price_parking_lots.project_id', 'projects.id')
            ->where('project_price_parking_lots.project_id', $this->projectId);
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
            Column::name('floor')
                ->label(__('Floor')),

            Column::name('type')
                ->label(__('Type')),

            Column::callback(['price', 'projects.currency'], function ($price, $currency) {
                $prefix = $currency === 'PEN' ? 'S/. ' : 'US$. ';

                return '<pre>' . $prefix . number_format($price, 2) . '</pre>';
            })
                ->label(__('Price')),

            Column::name('id')
                ->label(__('Actions'))
                ->view('projects.actions.priceParkingLot')
        ];
    }
}

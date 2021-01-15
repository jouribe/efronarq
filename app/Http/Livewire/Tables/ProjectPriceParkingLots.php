<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectPriceParkingLot;
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
     * Query Builder.
     *
     * @noinspection PhpMissingReturnTypeInspection
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function builder()
    {
        return ProjectPriceParkingLot::query()->whereProjectId($this->projectId);
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

            Column::callback('price', function ($price) {
                return '<pre>US$ ' . number_format($price, 2) . '</pre>';
            })
                ->label(__('Price')),

            Column::name('id')
                ->label(__('Actions'))
                ->view('projects.actions.priceParkingLot')
        ];
    }
}

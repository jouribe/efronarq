<?php

/** @noinspection UnknownInspectionInspection */

namespace App\Http\Livewire\Tables;

use App\Models\ProjectPrice;
use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ProjectPrices extends LivewireDatatable
{
    /**
     * @var mixed $projectId
     */
    public $projectId;

    /**
     * @var mixed $hideable
     */
    public $hideable = 'add-modal';

    /**
     * @var mixed $event
     */
    public $event = 'createPrice';

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
     * @var mixed $listeners
     */
    protected $listeners = [
        'refreshLivewireDatatable',
        'GeneralPriceCreated' => 'generalPriceCreated'
    ];

    /**
     * Query builder.
     *
     * @return Builder
     */
    public function builder(): Builder
    {
        return ProjectPrice::query()->whereProjectId($this->projectId);
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
            Column::callback('free_area', function ($free_area) {
                return '<code>' . $free_area . ' %</sup></code>';
            })
                ->label('Factor ' . __('Free area')),

            Column::callback('discount_presale', function ($discount_presale) {
                return '<code>' . $discount_presale . ' %</sup></code>';
            })
                ->label('Factor ' . __('Discount presale')),

            Column::callback('delivery_increment', function ($delivery_increment) {
                return '<code>' . $delivery_increment . ' %</sup></code>';
            })
                ->label('Factor ' . __('Delivery increment')),

            Column::callback('parking_discount', function ($parking_discount) {
                return '<code>' . $parking_discount . ' %</sup></code>';
            })
                ->label(__('Parking discount')),

            //            Column::callback('currency', function ($currency) {
            //                return $currency === 'USD'
            //                    ? '<span>Dólares</span>'
            //                    : '<span>Soles</span>';
            //            })
            //                ->label(__('Currency')),

            Column::name('id')
                ->label(__('Actions'))
                ->view('projects.actions.prices')
        ];
    }

    /**
     * Hide create modal button
     *
     * @noinspection PhpUnused
     */
    public function generalPriceCreated(): void
    {
        $this->hideCreate = !$this->hideCreate;
    }
}

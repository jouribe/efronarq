<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectParkingLot;
use App\Traits\Prices;
use Illuminate\Database\Eloquent\Builder;
use LaravelIdea\Helper\App\Models\_ProjectParkingLotQueryBuilder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ProjectParkingLots extends LivewireDatatable
{
    use Prices;

    /**
     * @var mixed $projectId
     */
    public $projectId;

    /**
     * @var mixed $searchable
     */
    public $searchable = 'floor, type, parking_lot, availability';

    /**
     * @var mixed $hideable
     */
    public $hideable = 'add-modal';

    /**
     * @var mixed $event
     */
    public $event = 'createParkingLots';

    /**
     * @var bool $hideCreate
     */
    public bool $hideCreate = false;

    /**
     * Query Builder
     *
     * @return Builder|_ProjectParkingLotQueryBuilder
     */
    public function builder(): Builder|_ProjectParkingLotQueryBuilder
    {
        return ProjectParkingLot::query()
            ->leftJoin('projects', 'projects.id', 'project_parking_lots.project_id')
            ->leftJoin('project_prices', 'project_prices.project_id', 'projects.id')
            ->leftJoin('project_price_parking_lots', function ($join) {
                $join->on('project_price_parking_lots.project_id', '=', 'projects.id');
                $join->on('project_price_parking_lots.type', '=', 'project_parking_lots.type');
                $join->on('project_price_parking_lots.floor', '=', 'project_parking_lots.floor');
            })
            ->leftJoin('project_addresses', 'project_addresses.id', 'project_parking_lots.address_id')
            ->where('project_parking_lots.project_id', $this->projectId)
            ->groupBy('project_parking_lots.id', 'project_parking_lots.floor', 'project_parking_lots.parking_lot', 'project_parking_lots.roofed_area', 'project_parking_lots.free_area',
                'project_parking_lots.type', 'project_parking_lots.availability', 'project_parking_lots.discount', 'project_parking_lots.closet', 'project_price_parking_lots.type',
                'project_price_parking_lots.floor', 'project_price_parking_lots.price', 'project_prices.free_area', 'project_prices.discount_presale', 'project_prices.delivery_increment',
                'project_prices.parking_discount', 'project_parking_lots.blueprint');
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
            Column::name('project_parking_lots.floor')
                ->label(__('Floor')),

            Column::name('project_parking_lots.parking_lot')
                ->label(__('Parking lot')),

            Column::callback('project_parking_lots.roofed_area', function ($roofed_area) {
                return '<pre>' . $roofed_area . ' m<sup>2</sup></pre>';
            })
                ->label(__('Roofed area')),

            Column::callback('project_parking_lots.free_area', function ($free_area) {
                return '<pre>' . $free_area . ' m<sup>2</sup></pre>';
            })
                ->label(__('Free area')),

            Column::name('project_parking_lots.type')
                ->label(__('Type')),

            Column::name('project_parking_lots.availability')
                ->label(__('Availability')),

            //            BooleanColumn::name('discount')
            //                ->label(__('Discount')),
            //
            //            BooleanColumn::name('closet')
            //                ->label(__('Closet')),

            Column::callback([
                'project_parking_lots.roofed_area',
                'project_parking_lots.free_area',
                'project_parking_lots.type',
                'project_price_parking_lots.type',
                'project_parking_lots.floor',
                'project_price_parking_lots.floor',
                'project_price_parking_lots.price',
                'project_prices.free_area',
                'project_prices.discount_presale',
                'project_prices.delivery_increment',
                'project_prices.parking_discount'
            ], function ($parking_roofed_area, $parking_free_area, $parking_type, $price_type, $parking_floor, $price_floor, $price, $price_free_area, $presale, $delivery, $parking) {
                if ($parking_type === $price_type && $parking_floor === $price_floor) {
                    return '<pre>US$ ' . number_format($price - ($price * $price_free_area / 100), 2) . '</pre>';
                }

                return '<span class="text-red">SIN VALOR</span>';
            })
                ->label(__('Sale value')),

            Column::callback('project_parking_lots.blueprint', function ($blueprint) {
                if ($blueprint === null || $blueprint === '') {
                    return '<svg class="h-5 w-5 stroke-current text-red-300 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>';
                }

                return '<a href="/storage/' . $blueprint . '" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="h-5 w-5 stroke-current text-green-600 hover:text-green-900 mx-auto">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>';
            })
                ->label(__('Blueprint')),

            Column::name('project_parking_lots.id')
                ->label(__('Actions'))
                ->view('projects.actions.parkingLot')
        ];
    }
}

<?php

namespace App\Http\Livewire\Tables;

use App\Exports\ApartmentPricesExport;
use App\Models\Project;
use App\Models\ProjectApartment;
use App\Models\ProjectCloset;
use App\Models\ProjectParkingLot;
use Maatwebsite\Excel\Facades\Excel;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Prices extends LivewireDatatable
{
    public $searchable = 'project_apartments.name, project_apartment_types.type_name, project_apartment_types.bedroom';

    public $exportable = false;

    /**
     * @var mixed $customExport
     */
    public $customExport = true;

    public $beforeTableSlot = "reports.filters";

    /**
     * @var array|string[] $priceTypeList
     */
    public array $priceTypeList = [
        'Departamento' => 'Departamento',
        'Estacionamiento' => 'Estacionamiento',
        'Deposito' => 'Depósito/Closet',
    ];

    /**
     * @var mixed $priceType
     */
    public $priceType;

    /**
     * @var mixed $projectList
     */
    public $projectList;

    /**
     * @var mixed $projectId
     */
    public $projectId;

    /**
     * @var mixed $typeText
     */
    public $typeText;

    /**
     * @var mixed $project
     */
    public $project;

    public function mount(
        $model = null,
        $include = [],
        $exclude = [],
        $hide = [],
        $dates = [],
        $times = [],
        $searchable = [],
        $sort = null,
        $hideHeader = null,
        $hidePagination = null,
        $perPage = 10,
        $exportable = false,
        $hideable = false,
        $beforeTableSlot = false,
        $afterTableSlot = false,
        $params = []
    ) {
        parent::mount($model, $include, $exclude, $hide, $dates, $times, $searchable, $sort, $hideHeader, $hidePagination, $perPage, $exportable, $hideable, $beforeTableSlot, $afterTableSlot,
            $params);

        $this->projectList = Project::whereIsActive(true)->pluck('name', 'id');
    }

    public function render()
    {
        if (!is_null($this->project)) {
            $this->projectId = $this->project;
        }

        if (!is_null($this->priceType)) {
            $this->typeText = $this->priceType;
        }

        return parent::render();
    }

    public function builder()
    {
        if ($this->typeText === 'Estacionamiento') {
            return ProjectParkingLot::query()
                ->leftJoin('projects', 'project_parking_lots.project_id', 'projects.id')
                ->where('projects.id', $this->projectId);
        }

        if ($this->typeText === 'Deposito') {
            return ProjectCloset::query()
                ->leftJoin('projects', 'project_closets.project_id', 'projects.id')
                ->where('projects.id', $this->projectId);
        }

        return ProjectApartment::query()
            ->join('projects', 'project_apartments.project_id', 'projects.id')
            ->join('project_apartment_types', 'project_apartments.apartment_type_id', 'project_apartment_types.id')
            ->where('projects.id', $this->projectId)
            ->groupBy('project_apartments.id', 'project_apartments.name', 'project_apartment_types.type_name',
                'project_apartment_types.bedroom', 'project_apartment_types.roofed_area', 'project_apartment_types.free_area',
                'project_apartment_types.blueprint', 'project_apartments.price', 'project_apartments.availability', 'projects.currency',
                'projects.name', 'projects.id', 'project_apartments.project_id', 'project_apartments.apartment_type_id', 'project_apartments.start_floor',
                'project_apartments.end_floor', 'project_apartments.parking_lots', 'project_apartments.closets', 'project_apartments.order',
                'project_apartments.created_at', 'project_apartments.updated_at', 'projects.logo', 'projects.description', 'projects.legal',
                'projects.status', 'projects.bank_id', 'projects.account_nro_mn', 'projects.account_nro_me', 'projects.is_active',
                'projects.created_at', 'projects.updated_at', 'projects.deleted_at', 'project_apartment_types.id', 'project_apartment_types.project_id',
                'project_apartment_types.bathroom', 'project_apartment_types.view', 'project_apartment_types.service_room', 'project_apartment_types.created_at',
                'project_apartment_types.updated_at');
    }

    /** @noinspection ClassMethodNameMatchesFieldNameInspection */
    public function columns(): array
    {
        if ($this->typeText === 'Estacionamiento') {
            /** @noinspection DuplicatedCode */
            return [
                Column::name('projects.name')
                    ->label(__('Project'))
                    ->filterable(),

                Column::name('project_parking_lots.floor')
                    ->label(__('Floor')),

                Column::name('project_parking_lots.type')
                    ->label(__('Type')),

                Column::name('project_parking_lots.roofed_area')
                    ->label(__('A. Techada (m2)')),

                Column::name('project_parking_lots.free_area')
                    ->label(__('A. Libre (m2)')),

                Column::callback(['project_parking_lots.roofed_area', 'project_parking_lots.free_area'], function ($roofed, $free) {
                    return number_format($roofed + $free, 2);
                })
                    ->label('A. Total (m2)'),

                Column::name('project_parking_lots.closet')
                    ->label(__('Closet'))
                    ->filterable(),

                Column::callback('project_parking_lots.blueprint', function ($blueprint) {
                    return '<a href="/storage/' . $blueprint . '" class="text-blue-500" target="_blank">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.75 13.25L18 12C19.6569 10.3431 19.6569 7.65685 18 6C16.3431 4.34314 13.6569 4.34314 12 5.99999L10.75 7.25" stroke="#141414" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M7.25003 10.75L6.00003 12C4.34317 13.6569 4.34317 16.3431 6.00003 18C7.65688 19.6569 10.3432 19.6569 12 18L13.25 16.75" stroke="#141414" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M14.25 9.75L9.75 14.25" stroke="#141414" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>';
                })
                    ->label(__('Blueprint')),

                Column::callback([
                    'project_parking_lots.price',
                    'project_parking_lots.availability',
                    'projects.currency'
                ],
                    function ($price, $availability, $currency) {

                        $prefix = $currency === 'PEN' ? 'S/. ' : 'US$. ';

                        switch ($availability) {
                            case "Vendido":
                            case "Separado":
                                return strtoupper($availability);
                            default:
                                return $prefix . number_format($price, 2);
                        }
                    })
                    ->label('Precio venta'),
            ];
        }

        if ($this->typeText === 'Deposito') {
            /** @noinspection DuplicatedCode */
            return [
                Column::name('projects.name')
                    ->label(__('Project'))
                    ->filterable(),

                Column::name('project_closets.floor')
                    ->label(__('Floor')),

                Column::name('project_closets.closet')
                    ->label(__('Closet')),

                Column::name('project_closets.roofed_area')
                    ->label(__('A. Techada (m2)')),

                Column::callback('project_closets.blueprint', function ($blueprint) {
                    return '<a href="/storage/' . $blueprint . '" class="text-blue-500" target="_blank">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.75 13.25L18 12C19.6569 10.3431 19.6569 7.65685 18 6C16.3431 4.34314 13.6569 4.34314 12 5.99999L10.75 7.25" stroke="#141414" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M7.25003 10.75L6.00003 12C4.34317 13.6569 4.34317 16.3431 6.00003 18C7.65688 19.6569 10.3432 19.6569 12 18L13.25 16.75" stroke="#141414" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M14.25 9.75L9.75 14.25" stroke="#141414" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>';
                })
                    ->label(__('Blueprint')),

                Column::callback([
                    'project_closets.price',
                    'project_closets.availability',
                    'projects.currency'
                ],
                    function ($price, $availability, $currency) {

                        $prefix = $currency === 'PEN' ? 'S/. ' : 'US$. ';

                        switch ($availability) {
                            case "Vendido":
                            case "Separado":
                                return strtoupper($availability);
                            default:
                                return $prefix . number_format($price, 2);
                        }
                    })
                    ->label('Precio venta'),
            ];
        }

        if ($this->typeText === 'Departamento') {
            return [
                Column::name('project_apartments.id')
                    ->label('ID')
                    ->hide(),

                Column::name('projects.name')
                    ->label(__('Project'))
                    ->filterable(),

                Column::name('project_apartments.name')
                    ->label(__('Apartment')),

                Column::name('project_apartment_types.type_name')
                    ->label(__('Type')),

                Column::name('project_apartment_types.bedroom')
                    ->label('Nro. Dormitorios'),

                Column::name('project_apartment_types.roofed_area')
                    ->label('A. Techada (m2)'),

                Column::name('project_apartment_types.free_area')
                    ->label('A. Libre (m2)'),

                Column::callback(['project_apartment_types.roofed_area', 'project_apartment_types.free_area'], function ($roofed, $free) {
                    return number_format($roofed + $free, 2);
                })
                    ->label('A. Total (m2)'),

                Column::callback('project_apartment_types.blueprint', function ($blueprint) {
                    return '<a href="/storage/' . $blueprint . '" class="text-blue-500" target="_blank">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.75 13.25L18 12C19.6569 10.3431 19.6569 7.65685 18 6C16.3431 4.34314 13.6569 4.34314 12 5.99999L10.75 7.25" stroke="#141414" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M7.25003 10.75L6.00003 12C4.34317 13.6569 4.34317 16.3431 6.00003 18C7.65688 19.6569 10.3432 19.6569 12 18L13.25 16.75" stroke="#141414" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M14.25 9.75L9.75 14.25" stroke="#141414" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>';
                })
                    ->label(__('Blueprint')),

                Column::callback([
                    'project_apartments.price',
                    'project_apartments.availability',
                    'projects.currency'
                ],
                    function ($price, $availability, $currency) {

                        $prefix = $currency === 'PEN' ? 'S/. ' : 'US$. ';

                        switch ($availability) {
                            case "Vendido":
                            case "Separado":
                                return strtoupper($availability);
                            default:
                                return $prefix . number_format($price, 2);
                        }
                    })
                    ->label('Precio venta'),

                Column::callback([
                    'project_apartments.price',
                    'project_apartments.availability',
                    'projects.currency',
                    'project_apartment_types.roofed_area'
                ],
                    function ($price, $availability, $currency, $roofed) {

                        $prefix = $currency === 'PEN' ? 'S/. ' : 'US$. ';

                        switch ($availability) {
                            case "Vendido":
                            case "Separado":
                                return strtoupper($availability);
                            default:
                                return $prefix . number_format($price, 2);
                        }
                    })
                    ->label('Precio construcción'),

                Column::callback([
                    'project_apartments.price',
                    'project_apartments.availability',
                    'projects.currency',
                    'project_apartment_types.free_area'
                ],
                    function ($price, $availability, $currency, $free) {

                        $prefix = $currency === 'PEN' ? 'S/. ' : 'US$. ';

                        switch ($availability) {
                            case "Vendido":
                            case "Separado":
                                return strtoupper($availability);
                            default:
                                return $prefix . number_format($price, 2);
                        }
                    })
                    ->label('Precio entrega')
            ];
        }

        return [];
    }

    /**
     * Export
     *
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        return Excel::download(new ApartmentPricesExport, 'precios-departamento.xlsx');
    }
}

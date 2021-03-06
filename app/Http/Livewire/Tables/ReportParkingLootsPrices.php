<?php

namespace App\Http\Livewire\Tables;

use App\Exports\ParkingLotPricesExport;
use App\Models\ProjectParkingLot;
use Maatwebsite\Excel\Facades\Excel;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportParkingLootsPrices extends LivewireDatatable
{
    public $searchable = 'projects.name, project_parking_lots.floor, project_parking_lots.type';

    /**
     * @var mixed $customExport
     */
    public $customExport = true;

    /**
     * @var mixed $projectId
     */
    public $projectId;

    /**
     * @var mixed $typeText
     */
    public $typeText;

    protected $listeners = ['setProjectId'];

    public function builder()
    {
        return ProjectParkingLot::query()
            ->leftJoin('projects', 'project_parking_lots.project_id', 'projects.id')
            ->where('projects.id', $this->projectId);
    }

    public function columns()
    {
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

    /**
     * Export
     *
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        return Excel::download(new ParkingLotPricesExport($this->projectId), 'precios-estacionamientos.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function setProjectId($id): void
    {
        $this->projectId = $id;
    }
}

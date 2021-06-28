<?php

namespace App\Exports;

use App\Models\ProjectParkingLot;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\BeforeWriting;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class ParkingLotPricesExport implements FromView
{
    private int $projectId;

    /**
     * ParkingLotPricesExport constructor.
     */
    public function __construct(int $projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.parking-prices', [
            'parkingLots' => ProjectParkingLot::whereProjectId($this->projectId)->get()
        ]);
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            // Array callable, refering to a static method.
            BeforeWriting::class => [self::class, 'beforeWriting'],
        ];
    }

    /**
     * @param BeforeWriting $event
     */
    public static function beforeWriting(BeforeWriting $event): void
    {
        $event->getWriter()->getDelegate()->getActiveSheet()->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
    }
}

<?php

namespace App\Exports;

use App\Models\ProjectApartment;
use App\Models\ProjectCloset;
use App\Models\ProjectParkingLot;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeWriting;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class ApartmentPricesExport implements FromView, WithEvents
{
    /**
     * @var int $projectId
     */
    private int $projectId;

    /**
     * ApartmentPricesExport constructor.
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
        return view('exports.apartment-price', [
            'apartments' => ProjectApartment::whereProjectId($this->projectId)->get()
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

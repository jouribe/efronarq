<?php

namespace App\Exports;

use App\Models\ProjectParkingLot;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ParkingLotPricesExport implements FromView
{
    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.parking-prices', [
            'parkingLots' => ProjectParkingLot::all()
        ]);
    }
}

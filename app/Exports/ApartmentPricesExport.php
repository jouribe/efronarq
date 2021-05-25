<?php

namespace App\Exports;


use App\Models\ProjectApartment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ApartmentPricesExport implements FromView
{

    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.apartment-price', [
            'apartments' => ProjectApartment::all()
        ]);
    }
}

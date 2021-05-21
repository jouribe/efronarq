<?php

namespace App\Exports;

use App\Models\Visit;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class VisitsExport implements FromView
{

    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.visits', [
            'visits' => Visit::all()
        ]);
    }
}

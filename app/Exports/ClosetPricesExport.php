<?php

namespace App\Exports;

use App\Models\ProjectCloset;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ClosetPricesExport implements FromView
{
    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.deposit-price', [
            'closets' => ProjectCloset::all()
        ]);
    }
}

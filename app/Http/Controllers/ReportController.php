<?php

namespace App\Http\Controllers;

class ReportController extends Controller
{
    public function prices()
    {
        return view('reports.prices');
    }
}

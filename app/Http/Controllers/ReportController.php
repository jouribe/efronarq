<?php

namespace App\Http\Controllers;

class ReportController extends Controller
{
    public function prices()
    {
        return view('reports.prices');
    }

    public function documents()
    {
        return view('reports.documents');
    }
}

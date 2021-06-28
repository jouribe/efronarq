<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ReportController extends Controller
{
    public function prices()
    {
        return view('reports.prices')->with(['projects' => Project::whereIsActive(true)->get()]);
    }

    public function documents()
    {
        return view('reports.documents');
    }
}

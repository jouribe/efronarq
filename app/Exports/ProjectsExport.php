<?php

namespace App\Exports;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProjectsExport implements FromView
{
    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.projects', [
            'projects' => Project::all()
        ]);
    }
}

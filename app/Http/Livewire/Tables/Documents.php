<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectDocument;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Documents extends LivewireDatatable
{
    public $searchable = 'projects.name, project_documents.type, project_documents.name';

    public $exportable = false;

    /**
     * @var mixed $customExport
     */
    public $customExport = false;

    public function builder()
    {
        return ProjectDocument::query()
            ->leftJoin('projects', 'project_documents.project_id', 'projects.id')
            ->groupBy('project_documents.type', 'project_documents.name', 'projects.name', 'project_documents.id', 'project_documents.file');
    }

    public function columns()
    {
        return [
            Column::name('project_documents.id')
                ->label(__('ID')),

            Column::name('projects.name')
                ->label(__('Project'))
                ->filterable(),

            Column::name('project_documents.type')
                ->label(__('Type')),

            Column::callback(['project_documents.name', 'project_documents.file'], function ($name, $file) {
	                return '<a href="'.$file.'" target="_blank" class="text-blue-500 hover:underline">'.$name.'</a>';
            })
                ->label(__('Document'))
        ];
    }
}

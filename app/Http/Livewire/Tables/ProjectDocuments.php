<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectDocument;
use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ProjectDocuments extends LivewireDatatable
{
    /**
     * @var mixed $projectId
     */
    public $projectId;

    /**
     * @var mixed $searchable
     */
    public $searchable = 'type, name, file';

    /**
     * @var mixed $hideable
     */
    public $hideable = 'add-modal';

    /**
     * @var mixed $event
     */
    public $event = 'createDocuments';

    /**
     * @var bool $hideCreate
     */
    public bool $hideCreate = false;

    /**
     * @var bool $isAdmin
     */
    public bool $isAdmin;

    /**
     * Query Builder
     *
     * @return Builder
     */
    public function builder(): Builder
    {
        return ProjectDocument::query()->whereProjectId($this->projectId);
    }

    /**
     * Table columns
     *
     * @return array
     *
     * @noinspection ClassMethodNameMatchesFieldNameInspection
     */
    public function columns(): array
    {
        return [
            Column::name('type')
                ->label(__('Type')),

            Column::name('name')
                ->label(__('Name')),

            Column::callback('file', function ($file) {
                if ($file === null || $file === '') {
                    return '<svg class="h-5 w-5 stroke-current text-red-300 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>';
                }

                return '<a href="/storage/' . $file . '" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="h-5 w-5 stroke-current text-green-600 hover:text-green-900 mx-auto">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>';
            })
                ->label(__('File')),

            Column::name('id')
                ->label(__('Actions'))
                ->view('projects.actions.document')
        ];
    }
}

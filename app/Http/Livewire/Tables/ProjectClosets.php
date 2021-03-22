<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectCloset;
use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ProjectClosets extends LivewireDatatable
{
    /**
     * @var mixed $projectId
     */
    public $projectId;

    /**
     * @var mixed $searchable
     */
    public $searchable = 'project_closets.floor, project_closets.closet, project_closets.availability';

    /**
     * @var mixed $hideable
     */
    public $hideable = 'add-modal';

    /**
     * @var mixed $event
     */
    public $event = 'createClosets';

    /**
     * @var bool $hideCreate
     */
    public bool $hideCreate = false;

    /**
     * Query builder
     *
     * @return Builder
     */
    public function builder(): Builder
    {
        return ProjectCloset::query()
            ->leftJoin('projects', 'projects.id', 'project_closets.project_id')
            ->leftJoin('project_price_closets', 'project_price_closets.project_id', 'projects.id')
            ->where('project_closets.project_id', $this->projectId)
            ->groupBy('project_closets.id', 'project_closets.floor', 'project_closets.closet', 'project_closets.roofed_area', 'project_closets.availability', 'project_closets.blueprint',
                'project_price_closets.price');
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
            Column::name('project_closets.floor')
                ->label(__('Floor')),

            Column::name('project_closets.closet')
                ->label(__('Closet')),

            Column::callback('project_closets.roofed_area', function ($roofed) {
                return '<pre>' . $roofed . ' m<sup>2</sup></pre>';
            })
                ->label(__('Roofed area')),

            Column::name('project_closets.availability')
                ->label(__('Availability')),

            Column::callback(['project_closets.roofed_area', 'project_price_closets.price'], function ($area, $price) {
                return '<pre>US$ ' . number_format(($area * $price), 2) . '</pre>';
            })
                ->label(__('Sale value')),

            Column::callback('blueprint', function ($blueprint) {
                if ($blueprint === null || $blueprint === '') {
                    return '<svg class="h-5 w-5 stroke-current text-red-300 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>';
                }

                return '<a href="/storage/' . $blueprint . '" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="h-5 w-5 stroke-current text-green-600 hover:text-green-900 mx-auto">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>';
            })
                ->label(__('Blueprint')),

            Column::name('project_closets.id')
                ->label(__('Actions'))
                ->view('projects.actions.closet')
        ];
    }
}

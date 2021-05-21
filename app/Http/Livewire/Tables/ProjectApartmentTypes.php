<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectApartmentType;
use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class ProjectApartmentTypes extends LivewireDatatable
{
    /**
     * @var mixed $projectId
     */
    public $projectId;

    /**
     * @var mixed $searchable
     */
    public $searchable = "type_name";

    /**
     * @var mixed $hideable
     */
    public $hideable = 'add-modal';

    /**
     * @var mixed $event
     */
    public $event = 'createApartmentType';

    /**
     * @var bool $hideCreate
     */
    public bool $hideCreate = false;

    /**
     * @var mixed $customExport
     */
    public $customExport = false;

    /**
     * Query builder.
     *
     * @return Builder
     */
    public function builder(): Builder
    {
        return ProjectApartmentType::query()
            ->whereProjectId($this->projectId);
    }

    /**
     * @return array
     *
     * @noinspection ClassMethodNameMatchesFieldNameInspection
     */
    public function columns(): array
    {
        return [
            Column::name('type_name')
                ->label(__('Name')),

            Column::callback('roofed_area', function ($roofed_area) {
                return '<code>' . $roofed_area . ' m<sup>2</sup></code>';
            })
                ->label(__('Roofed area')),

            Column::callback('free_area', function ($free_area) {
                return '<code>' . $free_area . ' m<sup>2</sup></code>';
            })
                ->label(__('Free area')),

            Column::name('view')
                ->label(__('View')),

            NumberColumn::name('bedroom')
                ->label(__('Bedroom')),

            NumberColumn::name('bathroom')
                ->label(__('Bathroom')),

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

            BooleanColumn::name('service_room')
                ->label(__('Service room')),

            Column::name('id')
                ->label(__('Actions'))
                ->view('projects.actions.apartmentType')
        ];
    }
}

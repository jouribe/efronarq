<?php

namespace App\Http\Livewire\Tables;

use App\Models\VisitTracking;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class VisitsTracking extends LivewireDatatable
{
    /**
     * @var mixed $visitId
     */
    public $visitId;

    /**
     * @var mixed $searchable
     */
    public $searchable = 'action, status';

    /**
     * @var mixed $sort
     */
    public $sort = 'created_at';

    /**
     * @var mixed $hideable
     */
    public $hideable;

    /**
     * @var mixed $event
     */
    public $event = 'createTracking';

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
        return VisitTracking::query()->whereVisitId($this->visitId);
    }

    /**
     * Table columns
     *
     * @return array
     * @noinspection ClassMethodNameMatchesFieldNameInspection
     */
    public function columns(): array
    {
        return [
            DateColumn::name('created_at')
                ->label(__('Created at')),

            DateColumn::name('action_at')
                ->label(__('Action at')),

            Column::name('action')
                ->label(__('Action')),

            Column::name('comments')
                ->label(__('Comment')),

            Column::callback(['status', 'action_at'], function ($status, $action_at) {
                switch ($status) {
                    case 'Pendiente':
                        if (Carbon::today() < $action_at) {
                            return '<span>' . $status . '</span>';
                        }

                        return '<span class="text-red-600 font-bold">' . $status . '</span>';

                    case 'Finalizado':
                        return '<span class="text-green-600 font-bold">' . $status . '</span>';

                    default:
                        return $status;
                }
            })
                ->label(__('Status')),

            Column::name('id')
                ->label(__('Actions'))
                ->view('visits.actions.tracking'),
        ];
    }
}

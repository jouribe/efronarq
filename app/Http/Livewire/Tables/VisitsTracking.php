<?php

namespace App\Http\Livewire\Tables;

use App\Models\VisitTracking;
use Carbon\Carbon;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class VisitsTracking extends LivewireDatatable
{
    /**
     * @var string $model
     */
    public $model = VisitTracking::class;

    /**
     * @var string $searchable
     */
    public $searchable = 'action, status';

    /**
     * @var string $sort
     */
    public $sort = 'created_at';

    //    public function builder()
    //    {
    //        //
    //    }

    public function columns()
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
                ->view('visits.actions.tracking')
        ];
    }
}

<?php

namespace App\Http\Livewire\Tables;

use App\Models\Promotion;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Promotions extends LivewireDatatable
{
    /**
     * @var mixed $hideable
     */
    public $hideable = 'add-modal';

    /**
     * @var mixed $event
     */
    public $event = 'createPromotion';

    /**
     * @var bool $hideCreate
     */
    public bool $hideCreate = false;

    /**
     * @var string $searchable
     */
    public $searchable = 'projects.name, promotions.name';

    public function builder()
    {
        return Promotion::query()
            ->leftJoin('projects', 'promotions.project_id', 'projects.id')
            ->groupBy('promotions.id', 'projects.name', 'promotions.name', 'promotions.discount', 'promotions.start_at',
                'promotions.end_at');
    }

    public function columns()
    {
        return [
            Column::name('projects.name')
                ->label(__('Project')),

            Column::name('promotions.name')
                ->label(__('Promotion')),

            Column::callback(['promotions.discount'], function ($discount) {
                return $discount . ' %';
            })
                ->label(__('Discount')),

            DateColumn::name('promotions.start_at')
                ->label(__('Start at')),

            DateColumn::name('promotions.end_at')
                ->label(__('End at')),

            Column::name('promotions.id')
                ->label(__('Actions'))
                ->view('promotions.actions.promotion')
        ];
    }
}

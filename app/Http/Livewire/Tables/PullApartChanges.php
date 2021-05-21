<?php

namespace App\Http\Livewire\Tables;

use App\Models\PullApartChange;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class PullApartChanges extends LivewireDatatable
{
    /**
     * @var mixed $pullApartId
     */
    public $pullApartId;

    /**
     * @var mixed $searchable
     */
    public $searchable = 'estimate_days, delivery_at, id, payment_at';

    /**
     * @var mixed $customExport
     */
    public $customExport = false;

    public function builder()
    {
        return PullApartChange::query()
            ->where('pull_apart_id', $this->pullApartId);
    }

    public function columns()
    {
        return [
            Column::name('id')
                ->label('ID'),

            Column::callback('estimate', function ($estimate) {
                return '<a href="/storage/' . $estimate . '">Ver</a>';
            })
                ->label('Cambio Aprobado'),

            Column::callback('blueprint', function ($blueprint) {
                return '<a href="/storage/' . $blueprint . '">Ver</a>';
            })
                ->label('Plano'),

            Column::callback(['amount', 'currency'], function ($amount, $currency) {

                $prefix = 'S/. ';

                if ($currency === 'USD') {
                    $prefix = 'US$. ';
                }

                return $prefix . ' ' . number_format($amount, 2);
            })
                ->label('Monto'),

            DateColumn::name('payment_at')
                ->label('Fecha de pago'),

            Column::name('estimate_days')
                ->label('Días Estimados'),

            DateColumn::name('delivery_at')
                ->label('Fecha de entrega'),
        ];
    }
}

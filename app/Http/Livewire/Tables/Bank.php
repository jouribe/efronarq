<?php

namespace App\Http\Livewire\Tables;

use App\Models\Bank as BankModel;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class Bank extends LivewireDatatable
{
    /**
     * @var string $model
     */
    public $model = BankModel::class;

    /**
     * @var string $searchable
     */
    public $searchable = "name, contact_name";

    /**
     * @var bool $exportable
     */
    public $exportable = true;

    /**
     * @var string $sort
     */
    public $sort = "name|asc";

    /**
     * @return array
     * @noinspection ClassMethodNameMatchesFieldNameInspection
     */
    public function columns(): array
    {
        return [
            NumberColumn::name('id')
                ->label('ID')
                ->hide(),

            Column::name('name')
                ->label(__('Name')),

            Column::name('contact_name')
                ->label(__('Contact Name')),

            Column::name('contact_phone')
                ->label(__('Contact Phone')),

            Column::name('contact_email')
                ->label(__('Contact Email')),

            Column::name('currency')
                ->label(__('Currency')),

            DateColumn::name('created_at')
                ->label(__('Created At'))
        ];
    }
}

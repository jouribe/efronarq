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
     * @var mixed $hideable
     */
    public $hideable = 'add-modal';

    /**
     * @var mixed $event
     */
    public $event = 'createBank';

    /**
     * @var bool $hideCreate
     */
    public bool $hideCreate = false;

    /**
     * @var string $searchable
     */
    public $searchable = "name, contact_name, contact_phone, contact_email";

    /**
     * @var bool $exportable
     */
    public $exportable = false;

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
                ->label(__('Created At')),

            Column::name('id')
                ->label(__('Actions'))
                ->view('banks.actions.banks')
        ];
    }
}

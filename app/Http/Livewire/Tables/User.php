<?php

namespace App\Http\Livewire\Tables;

use App\Models\User as UserModel;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class User extends LivewireDatatable
{
    public $model = UserModel::class;

    public function builder()
    {
        return UserModel::query()->select('id', 'email');
    }

    public function columns()
    {
        return [

            Column::checkbox(),

            NumberColumn::name('id')
                ->label('ID')
                ->filterable(),

            NumberColumn::name('email')
                ->label('Email')
        ];
    }
}

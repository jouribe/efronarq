<?php

namespace App\Http\Livewire\Tables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Users extends LivewireDatatable
{
    /**
     * @var mixed $hideable
     */
    public $hideable = 'add-modal';

    /**
     * @var mixed $event
     */
    public $event = 'createUser';

    /**
     * @var bool $hideCreate
     */
    public bool $hideCreate = false;

    /**
     * @var mixed $searchable
     */
    public $searchable = 'users.name, roles.name';

    /**
     * Query Builder
     *
     * @return Builder
     */
    public function builder(): Builder
    {
        return User::query()
            ->leftJoin('model_has_roles', 'users.id', 'model_has_roles.model_id')
            ->leftJoin('roles', 'model_has_roles.role_id', 'roles.id')
            ->groupBy('users.id', 'users.name', 'users.email', 'roles.name', 'users.phone');
    }

    /**
     * @return array
     * @noinspection ClassMethodNameMatchesFieldNameInspection
     */
    public function columns(): array
    {
        return [
            Column::callback('users.id', function ($id) {
                return "<pre>{$id}</pre>";
            })
                ->label(__('ID')),

            Column::name('roles.name')
                ->label(__('Role')),

            Column::name('users.name')
                ->label('Name'),

            Column::name('users.email')
                ->label(__('Email')),

            Column::name('users.phone')
                ->label(__('Phone')),

            Column::name('users.id')
                ->label(__('Actions'))
                ->view('users.actions.user')
        ];
    }
}

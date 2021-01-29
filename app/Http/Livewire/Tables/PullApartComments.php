<?php

namespace App\Http\Livewire\Tables;

use App\Models\PullApartComment;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class PullApartComments extends LivewireDatatable
{
    /**
     * @var mixed $pullAprtId
     */
    public $pullAprtId;

    /**
     * @var mixed $searchable
     */
    public $searchable = 'users.name, pull_apart_comments.created_at';

    /**
     * Query builder
     *
     * @return mixed
     * @noinspection PhpMixedReturnTypeCanBeReducedInspection
     */
    public function builder(): mixed
    {
        return PullApartComment::query()
            ->leftJoin('users', 'pull_apart_comments.user_id', 'users.id')
            ->groupBy('comment', 'status', 'pull_apart_comments.created_at', 'users.name')
            ->where('pull_apart_comments.pull_apart_id', $this->pullAprtId)
            ->orderBy('pull_apart_comments.created_at', 'desc');
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
            Column::name('users.name')
                ->label(__('Name')),

            Column::callback('status', function ($status) {
                return match ($status) {
                    'Rechazado' => "<span class='bg-red-500 text-white px-4 py-1 rounded-md text-xs'>{$status}</span>",
                    'Aprobado' => "<span class='bg-green-500 text-white px-4 py-1 rounded-md text-xs'>{$status}</span>",
                    'Pendiente Aprobación' => "<span class='bg-yellow-600 text-white px-4 py-1 rounded-md text-xs'>{$status}</span>",
                    default => "<span class='bg-blue-500 px-4 py-1 rounded-md text-white text-xs'>{$status}</span>",
                };
            })
                ->label(__('Status'))
            ->filterable(),

            Column::name('comment')
                ->label(__('Comment')),

            DateColumn::name('pull_apart_comments.created_at')
                ->label(__('Date'))
        ];
    }
}

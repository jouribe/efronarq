<?php

namespace App\Http\Livewire\Tables;

use App\Models\PullApartComment;
use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class PullApartComments extends LivewireDatatable
{
    /**
     * @var mixed $pullAprtId
     */
    public $pullApartId;

    /**
     * @var mixed $searchable
     */
    public $searchable = 'users.name, pull_apart_comments.created_at';

    /**
     * Query builder
     *
     * @return Builder
     */
    public function builder(): Builder
    {
        return PullApartComment::query()
            ->leftJoin('users', 'pull_apart_comments.user_id', 'users.id')
            ->where('pull_apart_comments.pull_apart_id', $this->pullApartId)
            ->groupBy('pull_apart_comments.comment', 'pull_apart_comments.status', 'pull_apart_comments.created_at', 'users.name')
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

            Column::callback('pull_apart_comments.status', function ($status) {
                switch ($status) {
                    case 'Rechazado':
                        return "<span class='bg-red-500 text-white px-4 py-1 rounded-md text-xs'>$status</span>";
                    case 'Aprobado':
                        return "<span class='bg-green-500 text-white px-4 py-1 rounded-md text-xs'>$status</span>";
                    case 'Pendiente Aprobación':
                        return "<span class='bg-yellow-600 text-white px-4 py-1 rounded-md text-xs'>$status</span>";
                    default:
                        return "<span class='bg-blue-500 px-4 py-1 rounded-md text-white text-xs'>$status</span>";
                }
            })
                ->label(__('Status')),

            Column::name('pull_apart_comments.comment')
                ->label(__('Comment')),

            DateColumn::name('pull_apart_comments.created_at')
                ->label(__('Date'))
        ];
    }
}

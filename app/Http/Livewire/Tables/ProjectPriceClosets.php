<?php

namespace App\Http\Livewire\Tables;

use App\Models\ProjectPriceCloset;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ProjectPriceClosets extends LivewireDatatable
{
    /**
     * @var mixed $projectId
     */
    public $projectId;

    /**
     * Query builder.
     *
     * @noinspection PhpMissingReturnTypeInspection
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function builder()
    {
        return ProjectPriceCloset::query()->whereProjectId($this->projectId);
    }

    /**
     * Table columns
     *
     * @return array
     *
     * @noinspection ClassMethodNameMatchesFieldNameInspection
     */
    public function columns(): array
    {
        return [
            Column::callback('price', function ($price) {
                return '<pre>US$ ' . number_format($price, 2) . '</pre>';
            })
                ->label(__('Storage or closet value per area') . ' (m2)'),

            Column::name('id')
                ->label(__('Actions'))
                ->view('projects.actions.priceCloset')
        ];
    }
}

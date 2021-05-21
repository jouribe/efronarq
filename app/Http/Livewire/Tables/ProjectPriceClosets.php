<?php

/** @noinspection UnknownInspectionInspection */

namespace App\Http\Livewire\Tables;

use App\Models\ProjectPriceCloset;
use Illuminate\Database\Eloquent\Builder;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ProjectPriceClosets extends LivewireDatatable
{
    /**
     * @var mixed $projectId
     */
    public $projectId;

    /**
     * @var mixed $hideable
     */
    public $hideable = 'add-modal';

    /**
     * @var mixed $event
     */
    public $event = 'createPriceCloset';

    /**
     * @var bool $hideCreate
     */
    public bool $hideCreate = false;

    /**
     * @var bool $isAdmin
     */
    public bool $isAdmin;

    /**
     * @var mixed $listeners
     */
    protected $listeners = [
        'refreshLivewireDatatable',
        'PriceClosetCreated' => 'priceClosetCreated'
    ];

    /**
     * @var mixed $customExport
     */
    public $customExport = false;

    /**
     * Query builder.
     *
     * @return Builder
     */
    public function builder(): Builder
    {
        return ProjectPriceCloset::query()
            ->leftJoin('projects', 'project_price_closets.project_id', 'projects.id')
            ->where('project_price_closets.project_id', $this->projectId);
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
            Column::callback(['price', 'projects.currency'], function ($price, $currency) {
                $prefix = $currency === 'PEN' ? 'S/. ' : 'US$. ';

                return '<pre>' . $prefix . number_format($price, 2) . '</pre>';
            })
                ->label(__('Storage or closet value per area') . ' (m2)'),

            Column::name('id')
                ->label(__('Actions'))
                ->view('projects.actions.priceCloset')
        ];
    }

    /**
     * Hide create modal button
     *
     * @noinspection PhpUnused
     */
    public function priceClosetCreated(): void
    {
        $this->hideCreate = !$this->hideCreate;
    }
}

<?php

/** @noinspection UnknownInspectionInspection */

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
     * @var mixed $listeners
     */
    protected $listeners = [
        'refreshLivewireDatatable',
        'PriceClosetCreated' => 'priceClosetCreated'
    ];

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

<?php

namespace App\Http\Livewire\Visits;

use App\Models\Visit;
use App\Models\VisitTracking;
use App\Traits\Lists;
use DateTime;
use Livewire\Component;
use Exception;

class Tracking extends Component
{
    use Lists;

    /**
     * @var Visit $visit
     */
    public $visit;

    /**
     * @var int $visit_tracking_id
     */
    public $visit_tracking_id;

    /**
     * @var DateTime $actionAt
     */
    public $action_at;

    /**
     * @var string $action
     */
    public $action;

    /**
     * @var string[]
     */
    public $actionList = [];

    /**
     * @var string $comments
     */
    public $comments;

    /**
     * @var string $status
     */
    public $status;

    /**
     * @var string[] $statusList
     */
    public $statusList = [
        'Pendiente' => 'Pendiente',
        'Finalizado' => 'Finalizado'
    ];

    /**
     * @var boolean $isOpen
     */
    public $isOpen = false;

    /**
     * @var string[] $listeners
     */
    protected $listeners = [
        'editTracking' => 'edit',
        'deleteTracking' => 'delete'
    ];

    public function render()
    {
        $this->actionList = $this->action();

        return view('livewire.visits.tracking');
    }

    /**
     * The attributes that are mass assignable.
     */
    public function create(): void
    {
        $this->resetInputFields();
        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     */
    public function openModal(): void
    {
        $this->isOpen = true;
    }

    /**
     * The attributes that are mass assignable.
     */
    public function closeModal(): void
    {
        $this->isOpen = false;
    }

    /**
     * Clear the input fields.
     */
    public function resetInputFields(): void
    {
        $this->visit_tracking_id = null;
        $this->action_at = '';
        $this->action = '';
        $this->comments = '';
        $this->status = '';
    }

    /**
     * Store the project address.
     */
    public function store(): void
    {
        // Validation
        $this->validate([
            'action_at' => 'required',
            'action' => 'required'
        ]);

        // Save project address
        VisitTracking::updateOrCreate([
            'id' => $this->visit_tracking_id
        ],
            [
                'visit_id' => $this->visit->id,
                'action_at' => $this->action_at,
                'action' => $this->action,
                'comments' => $this->comments,
                'status' => $this->status
            ]);

        $this->closeModal();
        $this->resetInputFields();
        $this->emit('refreshLivewireDatatable');
    }

    /**
     * Edit project address.
     *
     * @param $id
     */
    public function edit($id): void
    {
        $tracking = VisitTracking::findOrFail($id);
        $this->visit_tracking_id = $tracking->id;
        $this->action_at = $tracking->action_at;
        $this->action = $tracking->action;
        $this->comments = $tracking->comments;
        $this->status = $tracking->status;

        $this->openModal();
    }

    /**
     * Delete project address.
     *
     * @param $id
     */
    public function delete($id) : void
    {
        try {
            VisitTracking::findOrFail($id)->delete();

            $this->emit('refreshLivewireDatatable');
        } catch (Exception $e) {
        }
    }
}

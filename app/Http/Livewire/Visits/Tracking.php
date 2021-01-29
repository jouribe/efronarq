<?php

namespace App\Http\Livewire\Visits;

use App\Models\Visit;
use App\Models\VisitTracking;
use App\Traits\Lists;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Exception;

class Tracking extends Component
{
    use Lists;

    /**
     * @var Visit $visit
     */
    public Visit $visit;

    /**
     * @var mixed $visit_tracking_id
     */
    public $visit_tracking_id;

    /**
     * @var string $actionAt
     */
    public string $action_at;

    /**
     * @var string $action
     */
    public string $action;

    /**
     * @var string[]
     */
    public array $actionList = [];

    /**
     * @var string $comments
     */
    public string $comments;

    /**
     * @var string $status
     */
    public string $status;

    /**
     * @var string[] $statusList
     */
    public array $statusList = [
        'Pendiente' => 'Pendiente',
        'Finalizado' => 'Finalizado'
    ];

    /**
     * @var boolean $isOpen
     */
    public bool $isOpen = false;

    /**
     * @var mixed $listeners
     */
    protected $listeners = [
        'editTracking' => 'edit',
        'deleteTracking' => 'delete',
        'createTracking' => 'create'
    ];

    /**
     * Render view.
     *
     * @return Factory|View|Application
     */
    public function render(): Factory|View|Application
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
                'action_at' => Carbon::parse($this->action_at)->format("Y-m-d"),
                'action' => $this->action,
                'comments' => $this->comments,
                'status' => $this->status
            ]);

        session()->flash('message', $this->visit_tracking_id ? __('Tracking updated successfully') : __('Tracking created successfully'));

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

            session()->flash('message', __('Tracking deleted successfully'));

            $this->emit('refreshLivewireDatatable');
        } catch (Exception $e) {
            echo $e;
        }
    }
}

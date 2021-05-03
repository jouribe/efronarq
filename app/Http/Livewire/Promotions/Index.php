<?php

namespace App\Http\Livewire\Promotions;

use App\Models\Project;
use App\Models\Promotion;
use Livewire\Component;
use Exception;

class Index extends Component
{
    /**
     * @var mixed $promotionId
     */
    public $promotionId;

    /**
     * @var mixed $name
     */
    public $name;

    /**
     * @var mixed $discount
     */
    public $discount;

    /**
     * @var mixed $start_at
     */
    public $start_at;

    /**
     * @var mixed $end_at
     */
    public $end_at;

    /**
     * @var mixed $project_id
     */
    public $project_id;

    /**
     * @var mixed $projectList
     */
    public $projectList;

    /**
     * @var boolean $isOpen
     */
    public bool $isOpen = false;

    /**
     * @var mixed $listeners
     */
    protected $listeners = [
        'editPromotion' => 'edit',
        'deletePromotion' => 'delete',
        'createPromotion' => 'create'
    ];

    public function render()
    {
        return view('livewire.promotions.index');
    }

    /**
     * Mount component
     */
    public function mount(): void
    {
        $this->projectList = Project::all()->pluck('name', 'id');
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
        $this->promotionId = null;
        $this->project_id = null;
        $this->name = '';
        $this->discount = '';
        $this->start_at = null;
        $this->end_at = null;
    }

    /**
     * Store the project address.
     */
    public function store(): void
    {
        // Validation
        $this->validate([
            'name' => 'required',
            'discount' => 'required'
        ]);

        // Save project address
        Promotion::updateOrCreate([
            'id' => $this->promotionId
        ],
            [
                'project_id' => $this->project_id,
                'name' => $this->name,
                'discount' => $this->discount,
                'start_at' => $this->start_at,
                'end_at' => $this->end_at
            ]);

        session()->flash('message', $this->promotionId ? __('Promotion updated successfully!') : __('Promotion created successfully!'));

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
        $promotion = Promotion::findOrFail($id);
        $this->promotionId = $promotion->id;
        $this->project_id = $promotion->project_id;
        $this->name = $promotion->name;
        $this->discount = $promotion->discount;
        $this->start_at = $promotion->start_at;
        $this->end_at = $promotion->end_at;

        $this->openModal();
    }

    /**
     * Delete project address.
     *
     * @param $id
     */
    public function delete($id): void
    {
        try {
            Promotion::findOrFail($id)->delete();

            session()->flash('message', __('Promotion deleted successfully'));

            $this->emit('refreshLivewireDatatable');
        } catch (Exception $e) {
            echo $e;
        }
    }
}

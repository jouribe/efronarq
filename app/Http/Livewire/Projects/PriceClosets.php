<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectPriceCloset;
use Exception;
use Livewire\Component;

class PriceClosets extends Component
{
    /**
     * @var Project $project
     */
    public $project;

    /**
     * @var int $project_price_closet_id
     */
    public $project_price_closet_id;

    /**
     * @var float $price
     */
    public $price;

    /**
     * @var boolean $isOpen
     */
    public $isOpen = false;

    /**
     * @var string[] $listeners
     */
    protected $listeners = [
        'editPriceCloset' => 'edit',
        'deletePriceCloset' => 'delete'
    ];

    public function render()
    {
        return view('livewire.projects.price-closets');
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
        $this->project_price_closet_id = null;
        $this->price = '';
    }

    /**
     * Store the project apartment type.
     */
    public function store(): void
    {
        // Validation
        $this->validate([
            'price' => 'required|numeric',
        ]);

        // Save project address
        ProjectPriceCloset::updateOrCreate([
            'id' => $this->project_price_closet_id
        ],
            [
                'project_id' => $this->project->id,
                'price' => $this->price
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
        $priceCloset = ProjectPriceCloset::findOrFail($id);
        $this->project_price_closet_id = $priceCloset->id;
        $this->price = $priceCloset->price;

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
            ProjectPriceCloset::findOrFail($id)->delete();

            $this->emit('refreshLivewireDatatable');
        } catch (Exception $e) {
        }
    }
}

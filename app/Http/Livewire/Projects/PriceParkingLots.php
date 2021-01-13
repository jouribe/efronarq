<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectPriceParkingLot;
use Exception;
use Livewire\Component;

class PriceParkingLots extends Component
{
    /**
     * @var Project $project
     */
    public $project;

    /**
     * @var int $project_price_parking_lot_id
     */
    public $project_price_parking_lot_id;

    /**
     * @var string[] $floorTypes
     */
    public $floorList = [
        'Sótano 5' => 'Sótano 5',
        'Sótano 4' => 'Sótano 4',
        'Sótano 3' => 'Sótano 3',
        'Sótano 2' => 'Sótano 2',
        'Sótano 1' => 'Sótano 1',
        'Semi sótano' => 'Semi sótano',
        'Piso 1' => 'Piso 1'
    ];

    /**
     * @var string $floor
     */
    public $floor;

    /**
     * @var string[] $typeList
     */
    public $typeList = [
        'Simple' => 'Simple',
        'Doble' => 'Doble'
    ];

    /**
     * @var string $type
     */
    public $type;

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
        'editPriceParkingLot' => 'edit',
        'deletePriceParkingLot' => 'delete'
    ];

    public function render()
    {
        return view('livewire.projects.price-parking-lots');
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
        $this->project_price_parking_lot_id = null;
        $this->floor = '';
        $this->type = '';
        $this->price = '';
    }

    /**
     * Store the project apartment type.
     */
    public function store(): void
    {
        // Validation
        $this->validate([
            'floor' => 'required',
            'type' => 'required',
            'price' => 'required'
        ]);

        // Save project address
        ProjectPriceParkingLot::updateOrCreate([
            'id' => $this->project_price_parking_lot_id
        ],
            [
                'project_id' => $this->project->id,
                'floor' => $this->floor,
                'type' => $this->type,
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
        $priceParkingLot = ProjectPriceParkingLot::findOrFail($id);
        $this->project_price_parking_lot_id = $priceParkingLot->id;
        $this->floor = $priceParkingLot->floor;
        $this->type = $priceParkingLot->type;
        $this->price = $priceParkingLot->price;

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
            ProjectPriceParkingLot::findOrFail($id)->delete();

            $this->emit('refreshLivewireDatatable');
        } catch (Exception $e) {
        }
    }
}

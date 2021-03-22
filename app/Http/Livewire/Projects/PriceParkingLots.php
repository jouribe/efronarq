<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectPriceParkingLot;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PriceParkingLots extends Component
{
    /**
     * @var Project $project
     */
    public Project $project;

    /**
     * @var mixed $project_price_parking_lot_id
     */
    public $project_price_parking_lot_id;

    /**
     * @var string[] $floorTypes
     */
    public array $floorList = [
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
    public string $floor;

    /**
     * @var string[] $typeList
     */
    public array $typeList = [
        'Simple' => 'Simple',
        'Doble' => 'Doble'
    ];

    /**
     * @var string $type
     */
    public string $type;

    /**
     * @var mixed $price
     */
    public $price;

    /**
     * @var boolean $isOpen
     */
    public bool $isOpen = false;

    /**
     * @var string[] $listeners
     */
    protected $listeners = [
        'editPriceParkingLot' => 'edit',
        'deletePriceParkingLot' => 'delete',
        'createPriceParkingLot' => 'create'
    ];

    /**
     * Render action.
     *
     * @return Factory|View|Application
     */
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

        session()->flash('message', $this->project_price_parking_lot_id ? __('Price parking lot updated successfully') : __('Price parking lot created successfully'));

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

            session()->flash('message', __('Price parking lot deleted successfully'));

            $this->emit('refreshLivewireDatatable');
        } catch (Exception $e) {
            echo $e;
        }
    }
}

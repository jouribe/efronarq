<?php

/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUnused */
/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectAddress;
use App\Models\ProjectParkingLot;
use App\Models\ProjectPrice;
use App\Models\ProjectPriceParkingLot;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class ParkingLots extends Component
{
    use WithFileUploads;

    /**
     * @var Project $project
     */
    public Project $project;

    /**
     * @var mixed $project_parking_lot_id
     */
    public $project_parking_lot_id;

    /**
     * @var string $floor
     */
    public string $floor;

    /**
     * @var string[] $floorList
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
     * @var mixed $parking_lot
     */
    public $parking_lot;

    /**
     * @var mixed $roofed_area
     */
    public $roofed_area;

    /**
     * @var mixed $free_area
     */
    public $free_area;

    /**
     * @var mixed $type
     */
    public $type;

    /**
     * @var string[] $typeList
     */
    public array $typeList = [
        'Simple' => 'Simple',
        'Doble' => 'Doble'
    ];

    /**
     * @var string $availability
     */
    public string $availability;

    /**
     * @var string[] $availabilityList
     */
    public array $availabilityList = [
        'Disponible' => 'Disponible',
        'Reservado' => 'Reservado',
        'Separado' => 'Separado',
        'Vendido' => 'Vendido'
    ];

    /**
     * @var mixed $address_id
     */
    public $address_id;

    /**
     * @var mixed $discount
     */
    public $discount;

    /**
     * @var string[] $discountList
     */
    public array $discountList = [
        1 => 'Si',
        0 => 'No'
    ];

    /**
     * @var mixed $closet
     */
    public $closet;

    /**
     * @var string[] $closetList
     */
    public array $closetList = [
        1 => 'Si',
        0 => 'No'
    ];

    /**
     * @var mixed $blueprint
     */
    public $blueprint;

    /**
     * @var mixed $current_blueprint
     */
    public $current_blueprint;

    /**
     * @var mixed $projectAddressesList
     */
    public $projectAddressesList;

    /**
     * @var boolean $isOpen
     */
    public bool $isOpen = false;

    /**
     * @var string[] $listeners
     */
    protected $listeners = [
        'editParkingLots' => 'edit',
        'deleteParkingLots' => 'delete',
        'createParkingLots' => 'create'
    ];

    /**
     * Render view
     *
     * @return Factory|View|Application
     */
    public function render()
    {
        // Project addresses
        $this->projectAddressesList = ProjectAddress::whereProjectId($this->project->id)->pluck('address', 'id');

        return view('livewire.projects.parking-lots');
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
        $this->project_parking_lot_id = null;
        $this->floor = '';
        $this->roofed_area = '';
        $this->free_area = '';
        $this->type = '';
        $this->availability = '';
        $this->address_id = null;
        $this->discount = '';
        $this->closet = '';
        $this->blueprint = null;
        $this->current_blueprint = '';
    }

    /**
     * Store the project address.
     */
    public function store(): void
    {
        // Validation
        $this->validate([
            'floor' => 'required',
            'parking_lot' => 'required',
            'roofed_area' => 'required',
            'free_area' => 'required',
            'type' => 'required',
            'availability' => 'required',
            'discount' => 'required',
            'address_id' => 'required',
            'closet' => 'required',
            'blueprint' => 'nullable|file|max:10240', // 10MB Max
        ]);

        $parkingLotFloor = ProjectPriceParkingLot::whereProjectId($this->project->id)
            ->whereFloor($this->floor);

        if (!$parkingLotFloor->exists()) {
            session()->flash('floor_error', 'No se registró un estacionamiento en este piso!');
            return;
        }

        if($this->blueprint !== null && $this->blueprint !== '') {
            $this->current_blueprint = $this->blueprint->store('parking-lot-blueprints', 'public');
        }

        // Save project address
        ProjectParkingLot::updateOrCreate([
            'id' => $this->project_parking_lot_id
        ],
            [
                'project_id' => $this->project->id,
                'floor' => $this->floor,
                'parking_lot' => $this->parking_lot,
                'roofed_area' => $this->roofed_area,
                'free_area' => $this->free_area,
                'type' => $this->type,
                'availability' => $this->availability,
                'address_id' => $this->address_id,
                'discount' => $this->discount,
                'closet' => $this->closet,
                'blueprint' => $this->current_blueprint,
                'price' => $this->getPrice()
            ]);

        session()->flash('message', $this->project_parking_lot_id ? __('Parking lot updated successfully') : __('Parking lot created successfully'));

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
        $parkingLot = ProjectParkingLot::findOrFail($id);
        $this->project_parking_lot_id = $parkingLot->id;
        $this->floor = $parkingLot->floor;
        $this->parking_lot = $parkingLot->parking_lot;
        $this->roofed_area = $parkingLot->roofed_area;
        $this->free_area = $parkingLot->free_area;
        $this->type = $parkingLot->type;
        $this->availability = $parkingLot->availability;
        $this->address_id = $parkingLot->address_id;
        $this->discount = $parkingLot->discount;
        $this->closet = $parkingLot->closet;
        $this->current_blueprint = $parkingLot->blueprint;

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
            ProjectParkingLot::findOrFail($id)->delete();

            session()->flash('message', __('Parking lot deleted successfully'));

            $this->emit('refreshLivewireDatatable');
        } catch (Exception $e) {
            echo $e;
        }
    }

    /**
     * Return parking lot price
     *
     * @return mixed
     */
    public function getPrice()
    {
        $price = ProjectPriceParkingLot::whereProjectId($this->project->id)->whereFloor($this->floor)->whereType($this->type)->first()->price;

        if ($this->discount === 1) {
            $discount = ProjectPrice::whereProjectId($this->project->id)->first()->parking_discount;

            $price -= ($price * $discount / 100);
        }

        return $price;
    }
}

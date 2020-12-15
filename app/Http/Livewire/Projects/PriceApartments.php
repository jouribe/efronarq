<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectApartmentType;
use App\Models\ProjectPriceApartment;
use Livewire\Component;

class PriceApartments extends Component
{
    /**
     * @var Project $project
     */
    public $project;

    /**
     * @var ProjectApartmentType $apartmentTypes
     */
    public $apartmentTypes;

    /**
     * @var integer $project_apartment_type_id
     */
    public $project_apartment_type_id;

    /**
     * @var integer $project_price_apartment_id
     */
    public $project_price_apartment_id;

    /**
     * @var integer $start_floor
     */
    public $start_floor;

    /**
     * @var integer $end_floor
     */
    public $end_floor;

    /**
     * @var float $price_area
     */
    public $price_area;

    /**
     * @var boolean $isOpen
     */
    public $isOpen = false;

    /**
     * @var string[] $listeners
     */
    protected $listeners = [
        'editPriceApartment' => 'edit',
        'deletePriceApartment' => 'delete'
    ];

    public function render()
    {
        // Project apartment types.
        $this->apartmentTypes = ProjectApartmentType::whereProjectId($this->project->id)->pluck('type_name', 'id');

        return view('livewire.projects.price-apartments');
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
        $this->project_price_apartment_id = null;
        $this->start_floor = '';
        $this->end_floor = '';
        $this->price_area = '';
    }

    /**
     * Store the project apartment type.
     */
    public function store(): void
    {
        // Validation
        $this->validate([
            'start_floor' => 'required|integer',
            'end_floor' => 'required|integer',
            'price_area' => 'required|numeric'
        ]);

        // Save project address
        ProjectPriceApartment::updateOrCreate([
            'id' => $this->project_price_apartment_id
        ],
            [
                'project_id' => $this->project->id,
                'project_apartment_type_id' => $this->project_apartment_type_id,
                'start_floor' => $this->start_floor,
                'end_floor' => $this->end_floor,
                'price_area' => $this->price_area
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
        $priceApartment = ProjectPriceApartment::findOrFail($id);
        $this->project_price_apartment_id = $priceApartment->id;
        $this->project_apartment_type_id = $priceApartment->project_apartment_type_id;
        $this->start_floor = $priceApartment->start_floor;
        $this->end_floor = $priceApartment->end_floor;
        $this->price_area = $priceApartment->price_area;

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
            ProjectPriceApartment::findOrFail($id)->delete();

            $this->emit('refreshLivewireDatatable');
        } catch (\Exception $e) {
        }
    }
}

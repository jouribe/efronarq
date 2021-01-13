<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectApartment;
use App\Models\ProjectApartmentType;
use Exception;
use Livewire\Component;

class Apartments extends Component
{
    /**
     * @var Project $project
     */
    public $project;

    /**
     * @var int $project_apartment_id
     */
    public $project_apartment_id;

    /**
     * @var int $project_apartment_type_id
     */
    public $project_apartment_type_id;

    /**
     * @var array[] $projectApartmentTypeList
     */
    public $projectApartmentTypeList;

    /**
     * @var string $availability
     */
    public $availability;

    /**
     * @var string[] $availabilityList
     */
    public $availabilityList = [
        'Disponible' => 'Disponible',
        'Reservado' => 'Reservado',
        'Separado' => 'Separado',
        'Vendido' => 'Vendido'
    ];

    /**
     * @var int $start_floor
     */
    public $start_floor;

    /**
     * @var int $end_floor
     */
    public $end_floor;

    /**
     * @var int $parking_lots
     */
    public $parking_lots;

    /**
     * @var int $closets
     */
    public $closets;

    /**
     * @var int $order
     */
    public $order;

    /**
     * @var boolean $isOpen
     */
    public $isOpen = false;

    /**
     * @var string[] $listeners
     */
    protected $listeners = [
        'editApartments' => 'edit',
        'deleteApartments' => 'delete'
    ];

    public function render()
    {
        // Project apartment type list
        $this->projectApartmentTypeList = ProjectApartmentType::whereProjectId($this->project->id)->pluck('type_name', 'id');

        return view('livewire.projects.apartments');
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
        $this->project_apartment_type_id = null;
        $this->project_apartment_id = null;
        $this->availability = '';
        $this->start_floor = '';
        $this->end_floor = '';
        $this->parking_lots = '';
        $this->closets = '';
        $this->order = '';
    }

    /**
     * Store the project address.
     */
    public function store(): void
    {
        // Validation
        $this->validate([
            'project_apartment_type_id' => 'required',
            'availability' => 'required|string',
            'start_floor' => 'required|integer',
            'end_floor' => 'required|integer',
            'parking_lots' => 'required|integer',
            'closets' => 'required|integer',
            'order' => 'required|integer'
        ]);

        // Save project address
        ProjectApartment::updateOrCreate([
            'id' => $this->project_apartment_id
        ],
            [
                'project_id' => $this->project->id,
                'apartment_type_id' => $this->project_apartment_type_id,
                'availability' => $this->availability,
                'start_floor' => $this->start_floor,
                'end_floor' => $this->end_floor,
                'parking_lots' => $this->parking_lots,
                'closets' => $this->closets,
                'order' => $this->order
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
        $apartment = ProjectApartment::findOrFail($id);
        $this->project_apartment_id = $apartment->id;
        $this->project_apartment_type_id = $apartment->apartment_type_id;
        $this->availability = $apartment->availability;
        $this->start_floor = $apartment->start_floor;
        $this->end_floor = $apartment->end_floor;
        $this->parking_lots = $apartment->parking_lots;
        $this->closets = $apartment->closets;
        $this->order = $apartment->order;

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
            ProjectApartment::findOrFail($id)->delete();

            $this->emit('refreshLivewireDatatable');
        } catch (Exception $e) {
        }
    }
}

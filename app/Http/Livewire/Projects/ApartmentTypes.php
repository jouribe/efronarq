<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectApartmentType;
use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;

class ApartmentTypes extends Component
{
    use WithFileUploads;

    /**
     * @var Project $project
     */
    public $project;

    /**
     * @var int $project_apartment_type_id
     */
    public $project_apartment_type_id;

    /**
     * @var string $type_name
     */
    public $type_name;

    /**
     * @var float $roofed_area
     */
    public $roofed_area;

    /**
     * @var float $free_area
     */
    public $free_area;

    /**
     * @var int $bedroom
     */
    public $bedroom;

    /**
     * @var int $bathroom
     */
    public $bathroom;

    /**
     * @var string $view
     */
    public $view;

    /**
     * @var string $blueprint
     */
    public $blueprint;

    /**
     * @var string $current_blueprint
     */
    public $current_blueprint;

    /**
     * @var boolean $service_room
     */
    public $service_room;

    /**
     * @var boolean $isOpen
     */
    public $isOpen = false;

    public $isServiceRoom = [
        0 => 'No',
        1 => 'Si'
    ];

    /**
     * @var string[] $listeners
     */
    protected $listeners = [
        'editApartmentType' => 'edit',
        'deleteApartmentType' => 'delete'
    ];

    public function render()
    {
        return view('livewire.projects.apartment-types');
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
        $this->type_name = '';
        $this->roofed_area = '';
        $this->free_area = '';
        $this->bedroom = '';
        $this->bathroom = '';
        $this->view = '';
        $this->blueprint = null;
        $this->service_room = '';
        $this->current_blueprint = '';
    }

    /**
     * Store the project apartment type.
     */
    public function store(): void
    {
        // Validation
        $this->validate([
            'type_name' => 'required|string|min:1',
            'roofed_area' => 'required|numeric',
            'free_area' => 'required|numeric',
            'bedroom' => 'required|numeric',
            'bathroom' => 'required|numeric',
            'service_room' => 'required',
            'blueprint' => 'nullable|file|max:10240', // 10MB Max
        ]);

        if($this->blueprint !== null && $this->blueprint !== '') {
            $this->current_blueprint = $this->blueprint->store('apartment-type-blueprints', 'public');
        }

        // Save project address
        ProjectApartmentType::updateOrCreate([
            'id' => $this->project_apartment_type_id
        ],
            [
                'project_id' => $this->project->id,
                'type_name' => $this->type_name,
                'roofed_area' => $this->roofed_area,
                'free_area' => $this->free_area,
                'bedroom' => $this->bedroom,
                'bathroom' => $this->bathroom,
                'view' => $this->view,
                'service_room' => $this->service_room,
                'blueprint' => $this->current_blueprint
            ]);

        session()->flash('message', $this->project_apartment_type_id ? __('Apartment type updated successfully') : __('Apartment type created successfully'));

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
        $apartmentType = ProjectApartmentType::findOrFail($id);
        $this->project_apartment_type_id = $apartmentType->id;
        $this->type_name = $apartmentType->type_name;
        $this->roofed_area = $apartmentType->roofed_area;
        $this->free_area = $apartmentType->free_area;
        $this->bedroom = $apartmentType->bedroom;
        $this->bathroom = $apartmentType->bathroom;
        $this->view = $apartmentType->view;
        $this->current_blueprint = $apartmentType->blueprint;
        $this->service_room = $apartmentType->service_room;

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
            ProjectApartmentType::findOrFail($id)->delete();

            session()->flash('message', __('Apartment type deleted successfully'));

            $this->emit('refreshLivewireDatatable');
        } catch (Exception $e) {
        }
    }
}

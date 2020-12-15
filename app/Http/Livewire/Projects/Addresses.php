<?php

namespace App\Http\Livewire\Projects;

use App\Models\District;
use App\Models\Project;
use App\Models\ProjectAddress;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Addresses extends Component
{
    /**
     * @var Project $project
     */
    public $project;

    /**
     * @var District $districts
     */
    public $districts;

    /**
     * @var array $type
     */
    public $types = [
        'Estacionamiento' => 'Estacionamiento'
    ];

    /**
     * @var int $project_address_id
     */
    public $project_address_id;

    /**
     * @var string $type
     */
    public $type;

    /**
     * @var int $district_id
     */
    public $district_id;

    /**
     * @var string $address
     */
    public $address;

    /**
     * @var boolean $isOpen
     */
    public $isOpen = false;

    /**
     * @var string[] $listeners
     */
    protected $listeners = [
        'editAddress' => 'edit',
        'deleteAddress' => 'delete'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        // Get districts
        $this->districts = District::all()->pluck('name', 'id');

        // Render project address module.
        return view('livewire.projects.addresses');
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
        $this->project_address_id = null;
        $this->district_id = '';
        $this->type = 'Estacionamiento';
        $this->address = '';
    }

    /**
     * Store the project address.
     */
    public function store(): void
    {
        // Validation
        $this->validate([
            'district_id' => 'required',
            'type' => 'required',
            'address' => 'required'
        ]);

        // Save project address
        ProjectAddress::updateOrCreate([
            'id' => $this->project_address_id
        ],
            [
                'project_id' => $this->project->id,
                'district_id' => $this->district_id,
                'type' => $this->type,
                'address' => $this->address
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
        $address = ProjectAddress::findOrFail($id);
        $this->project_address_id = $address->id;
        $this->type = $address->type;
        $this->district_id = $address->district_id;
        $this->address = $address->address;

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
            ProjectAddress::findOrFail($id)->delete();

            $this->emit('refreshLivewireDatatable');
        } catch (\Exception $e) {
        }
    }
}

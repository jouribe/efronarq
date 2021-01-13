<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectCloset;
use Livewire\Component;
use Exception;
use Livewire\WithFileUploads;

class Closets extends Component
{
    use WithFileUploads;

    /**
     * @var Project $project
     */
    public $project;

    /**
     * @var int $project_closet_id
     */
    public $project_closet_id;

    /**
     * @var string $floor
     */
    public $floor;

    /**
     * @var string[] $floorList
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
     * @var string $closet
     */
    public $closet;

    /**
     * @var boolean $roofed_area
     */
    public $roofed_area;

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
     * @var string $blueprint
     */
    public $blueprint;

    /**
     * @var string $current_blueprint
     */
    public $current_blueprint;

    /**
     * @var boolean $isOpen
     */
    public $isOpen = false;

    /**
     * @var string[] $listeners
     */
    protected $listeners = [
        'editClosets' => 'edit',
        'deleteClosets' => 'delete'
    ];

    public function render()
    {
        return view('livewire.projects.closets');
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
        $this->project_closet_id = null;
        $this->floor = '';
        $this->closet = '';
        $this->roofed_area = '';
        $this->availability = '';
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
            'closet' => 'required',
            'roofed_area' => 'required',
            'availability' => 'required',
            'blueprint' => 'nullable|file|max:10240' // 10MB max file size.
        ]);

        if ($this->blueprint !== null && $this->blueprint !== '') {
            $this->current_blueprint = $this->blueprint->store('closet-blueprints', 'public');
        }

        // Save project address
        ProjectCloset::updateOrCreate([
            'id' => $this->project_closet_id
        ],
            [
                'project_id' => $this->project->id,
                'floor' => $this->floor,
                'closet' => $this->closet,
                'roofed_area' => $this->roofed_area,
                'availability' => $this->availability,
                'blueprint' => $this->current_blueprint
            ]);

        session()->flash('message', $this->project_closet_id ? __('Closet updated successfully.') : __('Closet created successfully.'));

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
        $closet = ProjectCloset::findOrFail($id);
        $this->project_closet_id = $closet->id;
        $this->floor = $closet->floor;
        $this->closet = $closet->closet;
        $this->roofed_area = $closet->roofed_area;
        $this->availability = $closet->availability;
        $this->current_blueprint = $closet->blueprint;

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
            ProjectCloset::findOrFail($id)->delete();

            session()->flash('message', __('Closet deleted successfully'));

            $this->emit('refreshLivewireDatatable');
        } catch (Exception $e) {
        }
    }
}

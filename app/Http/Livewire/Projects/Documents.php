<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectDocument;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Exception;
use Livewire\WithFileUploads;

class Documents extends Component
{
    use WithFileUploads;

    /**
     * @var Project $project
     */
    public Project $project;

    /**
     * @var mixed $project_document_id
     */
    public $project_document_id;

    /**
     * @var string $type
     */
    public string $type;

    /**
     * @var string[] $typeList
     */
    public array $typeList = [
        'Anexos para minuta' => 'Anexos para minuta',
        'Publicidad' => 'Publicidad',
        'Varios' => 'Varios'
    ];

    /**
     * @var string $name
     */
    public string $name;

    /**
     * @var mixed $file
     */
    public $file;

    /**
     * @var mixed $current_file
     */
    public $current_file;

    /**
     * @var boolean $isOpen
     */
    public bool $isOpen = false;

    /**
     * @var string[] $listeners
     */
    protected $listeners = [
        'editDocuments' => 'edit',
        'deleteDocuments' => 'delete',
        'createDocuments' => 'create'
    ];

    /**
     * Render view.
     *
     * @return Factory|View|Application
     */
    public function render(): Factory|View|Application
    {
        return view('livewire.projects.documents');
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
        $this->project_document_id = null;
        $this->type = '';
        $this->name = '';
        $this->file = null;
        $this->current_file = '';
    }

    /**
     * Store the project address.
     */
    public function store(): void
    {
        // Validation
        $this->validate([
            'type' => 'required',
            'name' => 'required',
            'file' => 'nullable|file|max:10240'
        ]);

        if ($this->file !== null && $this->file !== '') {
            $this->current_file = $this->file->store('project-documents', 'public');
        }

        // Save project address
        ProjectDocument::updateOrCreate([
            'id' => $this->project_document_id
        ],
            [
                'project_id' => $this->project->id,
                'type' => $this->type,
                'name' => $this->name,
                'file' => $this->current_file
            ]);

        session()->flash('message', $this->project_document_id ? __('Document updated successfully') : __('Document created successfully'));

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
        $document = ProjectDocument::findOrFail($id);
        $this->project_document_id = $document->id;
        $this->type = $document->type;
        $this->name = $document->name;
        $this->current_file= $document->file;

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
            ProjectDocument::findOrFail($id)->delete();

            session()->flash('message', __('Document deleted successfully'));

            $this->emit('refreshLivewireDatatable');
        } catch (Exception $e) {
            echo $e;
        }
    }
}

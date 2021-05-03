<?php

namespace App\Http\Livewire\Origins;

use App\Models\Origin;
use Livewire\Component;
use Exception;

class Index extends Component
{
    /**
     * @var mixed $userId
     */
    public $originId;

    /**
     * @var mixed $name
     */
    public $name;

    /**
     * @var boolean $isOpen
     */
    public bool $isOpen = false;

    /**
     * @var mixed $listeners
     */
    protected $listeners = [
        'editOrigin' => 'edit',
        'deleteOrigin' => 'delete',
        'createOrigin' => 'create'
    ];

    public function render()
    {
        return view('livewire.origins.index');
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
        $this->originId = null;
        $this->name = '';
    }

    /**
     * Store the project address.
     */
    public function store(): void
    {
        // Validation
        $this->validate([
            'name' => 'required',
        ]);

        // Save project address
        $origin = Origin::updateOrCreate([
            'id' => $this->originId
        ],
            [
                'name' => $this->name,
            ]);

        session()->flash('message', $this->originId ? __('Origin updated successfully!') : __('Origin created successfully!'));

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
        $origin = Origin::findOrFail($id);
        $this->originId = $origin->id;
        $this->name = $origin->name;

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
            Origin::findOrFail($id)->delete();

            session()->flash('message', __('User deleted successfully'));

            $this->emit('refreshLivewireDatatable');
        } catch (Exception $e) {
            echo $e;
        }
    }
}

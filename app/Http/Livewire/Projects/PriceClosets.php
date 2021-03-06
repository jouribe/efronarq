<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectCloset;
use App\Models\ProjectPriceCloset;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PriceClosets extends Component
{
    /**
     * @var Project $project
     */
    public Project $project;

    /**
     * @var mixed $project_price_closet_id
     */
    public $project_price_closet_id;

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
        'editPriceCloset' => 'edit',
        'deletePriceCloset' => 'delete',
        'createPriceCloset' => 'create'
    ];

    /**
     * Render view.
     *
     * @return Factory|View|Application
     */
    public function render()
    {
        return view('livewire.projects.price-closets');
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
        $this->project_price_closet_id = null;
        $this->price = '';
    }

    /**
     * Store the project apartment type.
     */
    public function store(): void
    {
        // Validation
        $this->validate([
            'price' => 'required|numeric',
        ]);

        // Save project address
        ProjectPriceCloset::updateOrCreate([
            'id' => $this->project_price_closet_id
        ],
            [
                'project_id' => $this->project->id,
                'price' => $this->price
            ]);

        if (!is_null($this->project_price_closet_id)) {
            $closets = ProjectCloset::where('project_id', '=', $this->project->id)
                ->whereIn('availability', ['Disponible', 'Reservado'])
                ->get();

            foreach ($closets as $closet) {
                $closet->update([
                    'price' => $this->project->closetPrices->first()->price * $closet->roofed_area
                ]);
            }
        }

        session()->flash('message', $this->project_price_closet_id ? __('Price closet updated successfully') : __('Price closet created successfully'));

        $this->closeModal();
        $this->resetInputFields();
        $this->emit('refreshLivewireDatatable');
        $this->emit('PriceClosetCreated');
    }

    /**
     * Edit project address.
     *
     * @param $id
     */
    public function edit($id): void
    {
        $priceCloset = ProjectPriceCloset::findOrFail($id);
        $this->project_price_closet_id = $priceCloset->id;
        $this->price = $priceCloset->price;

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
            ProjectPriceCloset::findOrFail($id)->delete();

            session()->flash('message', __('Price closet deleted successfully'));

            $this->emit('refreshLivewireDatatable');
            $this->emit('PriceClosetCreated');
        } catch (Exception $e) {
            echo $e;
        }
    }
}

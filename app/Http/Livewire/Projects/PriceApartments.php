<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectApartment;
use App\Models\ProjectApartmentType;
use App\Models\ProjectPriceApartment;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PriceApartments extends Component
{
    use \App\Traits\Prices;

    /**
     * @var Project $project
     */
    public Project $project;

    /**
     * @var mixed $apartmentTypes
     */
    public $apartmentTypes;

    /**
     * @var mixed $project_apartment_type_id
     */
    public $project_apartment_type_id;

    /**
     * @var mixed $project_price_apartment_id
     */
    public $project_price_apartment_id;

    /**
     * @var mixed $start_floor
     */
    public $start_floor;

    /**
     * @var mixed $end_floor
     */
    public $end_floor;

    /**
     * @var mixed $price_area
     */
    public $price_area;

    /**
     * @var boolean $isOpen
     */
    public bool $isOpen = false;

    /**
     * @var string[] $listeners
     */
    protected $listeners = [
        'editPriceApartment' => 'edit',
        'deletePriceApartment' => 'delete',
        'createPriceApartment' => 'create'
    ];

    /**
     * Render view.
     *
     * @return Factory|View|Application
     */
    public function render(): Factory|View|Application
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
            'project_apartment_type_id' => 'required',
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

        if (!is_null($this->project_price_apartment_id)) {
            $apartments = ProjectApartment::whereApartmentTypeId($this->project_apartment_type_id)
                ->where('availability', '!=', 'Vendido')
                ->get();

            foreach ($apartments as $apartment) {
                // Precio de area libre
                $freeAreaPrice = self::freeAreaTotal($apartment->project->prices->first()->free_area, $apartment->apartmentType->free_area, $apartment->project->apartmentPrices->first()->price_area);
                // Precio de area techada
                $roofedAreaPrice = self::roofedAreaTotal($apartment->apartmentType->roofed_area, $apartment->project->apartmentPrices->first()->price_area);
                // Precio de la unidad total Base (Proyecto: Construcción)
                $totalPrice = self::areaPriceTotal($freeAreaPrice, $roofedAreaPrice);

                $apartment->update([
                    'price' => $totalPrice
                ]);
            }
        }

        session()->flash('message', $this->project_price_apartment_id ? __('Price apartment updated successfully') : __('Price apartment created successfully'));

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

            session()->flash('message', __('Price apartment deleted successfully'));

            $this->emit('refreshLivewireDatatable');
        } catch (Exception $e) {
            echo $e;
        }
    }
}

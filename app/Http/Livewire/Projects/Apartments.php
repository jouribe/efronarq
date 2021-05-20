<?php

/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectApartment;
use App\Models\ProjectApartmentType;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Apartments extends Component
{
    use \App\Traits\Prices;

    /**
     * @var Project $project
     */
    public Project $project;

    /**
     * @var mixed $project_apartment_id
     */
    public $project_apartment_id;

    /**
     * @var mixed $project_apartment_type_id
     */
    public $project_apartment_type_id;

    /**
     * @var mixed $projectApartmentTypeList
     */
    public $projectApartmentTypeList;

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
     * @var mixed $start_floor
     */
    public $start_floor;

    /**
     * @var mixed $end_floor
     */
    public $end_floor;

    /**
     * @var mixed $parking_lots
     */
    public $parking_lots;

    /**
     * @var mixed $closets
     */
    public $closets;

    /**
     * @var mixed $order
     */
    public $order;

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
        'editApartments' => 'edit',
        'deleteApartments' => 'delete',
        'createApartments' => 'create',
    ];

    /**
     * @var mixed $errorMessage
     */
    public $errorMessage;

    /**
     * Render view.
     *
     * @return Factory|View|Application
     */
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
        $this->price = null;
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

        ray()->clearAll();

        $apartmentPrice = ProjectApartmentType::whereId($this->project_apartment_type_id)
            ->first()
            ->priceApartments
            ->first();

        $apartmentPrices = ProjectApartmentType::whereId($this->project_apartment_type_id)->first()->priceApartments()->get();

        foreach ($apartmentPrices as $apartmentPrice) {
            ray($apartmentPrice);
        }

        ray($apartmentPrices);
        ray()->pause();

        if (is_null($this->price)) {
            $this->price = $this->getPricePerApartment(Project::whereId($this->project->id)->first());
        }

        if ($this->end_floor > $apartmentPrice->end_floor) {
            $this->errorMessage = 'Este valor no concuerda con la lista de precios por tipo de departamento.';
        } else {
            if ($this->project_apartment_id) {
                // Update project apartment
                ProjectApartment::whereId($this->project_apartment_id)->update([
                    'project_id' => $this->project->id,
                    'apartment_type_id' => $this->project_apartment_type_id,
                    'availability' => $this->availability,
                    'start_floor' => $this->start_floor,
                    'end_floor' => $this->end_floor,
                    'parking_lots' => $this->parking_lots,
                    'closets' => $this->closets,
                    'order' => $this->order,
                    'price' => $this->price
                ]);
            } else {
                for ($i = $this->start_floor; $i <= $this->end_floor; $i++) {
                    ProjectApartment::create([
                        'project_id' => $this->project->id,
                        'apartment_type_id' => $this->project_apartment_type_id,
                        'availability' => $this->availability,
                        'start_floor' => $i,
                        'end_floor' => $i,
                        'parking_lots' => $this->parking_lots,
                        'closets' => $this->closets,
                        'order' => $this->order + ($i - 1),
                        'price' => $this->price
                    ]);
                }
            }

            session()->flash('message', $this->project_apartment_id ? __('Apartment updated successfully.') : __('Apartment created successfully.'));

            $this->closeModal();
            $this->resetInputFields();
            $this->emit('refreshLivewireDatatable');
        }
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
        $this->price = $apartment->price;

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
            ProjectApartment::findOrFail($id)->delete();

            session()->flash('message', __('Apartment deleted successfully'));

            $this->emit('refreshLivewireDatatable');
        } catch (Exception $e) {
            echo $e;
        }
    }

    /**
     * Clear error message.
     */
    public function clearErrorMessage(): void
    {
        $this->errorMessage = null;
    }

    /**
     * Get price per apartment
     *
     * @param Project $project
     * @return float
     */
    public function getPricePerApartment(Project $project): float
    {
        // Precio de area libre
        $freeAreaPrice = self::freeAreaTotal($project->prices->first()->free_area, $project->apartmentTypes()->whereId($this->project_apartment_type_id)->first()->free_area,
            $project->apartmentTypes()->whereId($this->project_apartment_type_id)->first()->priceApartments->first()->price_area);
        // Precio de area techada
        $roofedAreaPrice = self::roofedAreaTotal($project->apartmentTypes()->whereId($this->project_apartment_type_id)->first()->roofed_area,
            $project->apartmentTypes()->whereId($this->project_apartment_type_id)->first()->priceApartments->first()->price_area);
        // Precio de la unidad total Base (Proyecto: Construcción)
        return self::areaPriceTotal($freeAreaPrice, $roofedAreaPrice);
    }

    /**
     * Hydrate the component.
     */
    public function hydrate(): void
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}

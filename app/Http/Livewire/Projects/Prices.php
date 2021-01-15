<?php

/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUnused */
/** @noinspection PhpMissingFieldTypeInspection */

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectPrice;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Prices extends Component
{
    /**
     * @var Project $project
     */
    public Project $project;

    /**
     * @var mixed $project_price_id
     */
    public $project_price_id;

    /**
     * @var mixed $free_area
     */
    public $free_area;

    /**
     * @var mixed $discount_presale
     */
    public $discount_presale;

    /**
     * @var mixed $delivery_increment
     */
    public $delivery_increment;

    /**
     * @var mixed $parking_discount;
     */
    public $parking_discount;

    /**
     * @var string $currency
     */
    public string $currency;

    /**
     * @var boolean $isOpen
     */
    public bool $isOpen = false;

    /**
     * @var string[] $currencyTypesList
     */
    public array $currencyTypesList = [
        'USD'=> 'Dólares',
        'PEN' => 'Soles'
    ];

    /**
     * @var string[] $listeners
     */
    protected $listeners = [
        'editPrice' => 'edit',
        'deletePrice' => 'delete',
        'createPrice' => 'create'
    ];

    /**
     * Render view.
     *
     * @return Factory|View|Application
     */
    public function render(): Factory|View|Application
    {
        return view('livewire.projects.prices');
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
        $this->project_price_id = null;
        $this->free_area = '';
        $this->discount_presale = '';
        $this->delivery_increment = '';
        $this->parking_discount = '';
        $this->currency = '';
    }

    /**
     * Store the project apartment type.
     */
    public function store(): void
    {
        // Validation
        $this->validate([
            'free_area' => 'required|integer',
            'discount_presale' => 'required|integer',
            'delivery_increment' => 'required|integer',
            'parking_discount' => 'required|integer',
            'currency' => 'required'
        ]);

        // Save project address
        ProjectPrice::updateOrCreate([
            'id' => $this->project_price_id
        ],
            [
                'project_id' => $this->project->id,
                'free_area' => $this->free_area,
                'discount_presale' => $this->discount_presale,
                'delivery_increment' => $this->delivery_increment,
                'parking_discount' => $this->parking_discount,
                'currency' => $this->currency
            ]);

        session()->flash('message', $this->project_price_id ? __('General price updated successfully') : __('General price created successfully'));

        $this->closeModal();
        $this->resetInputFields();
        $this->emit('refreshLivewireDatatable');
        $this->emit('GeneralPriceCreated');
    }

    /**
     * Edit project address.
     *
     * @param $id
     */
    public function edit($id): void
    {
        $price = ProjectPrice::findOrFail($id);
        $this->project_price_id = $price->id;
        $this->free_area = $price->free_area;
        $this->discount_presale = $price->discount_presale;
        $this->delivery_increment = $price->delivery_increment;
        $this->parking_discount = $price->parking_discount;
        $this->currency = $price->currency;

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
            ProjectPrice::findOrFail($id)->delete();

            session()->flash('message', __('General price deleted successfully'));

            $this->emit('refreshLivewireDatatable');
            $this->emit('GeneralPriceCreated');
        } catch (Exception $e) {
            echo $e;
        }
    }
}

<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectPrice;
use Livewire\Component;

class Prices extends Component
{
    /**
     * @var Project $project
     */
    public $project;

    /**
     * @var integer $project_price_id
     */
    public $project_price_id;

    /**
     * @var integer $free_area
     */
    public $free_area;

    /**
     * @var integer $discount_presale
     */
    public $discount_presale;

    /**
     * @var integer $delivery_increment
     */
    public $delivery_increment;

    /**
     * @var integer $parking_discount;
     */
    public $parking_discount;

    /**
     * @var string $currency
     */
    public $currency;

    /**
     * @var boolean $isOpen
     */
    public $isOpen = false;

    /**
     * @var string[] $currencyTypes
     */
    public $currencyTypes = [
        'USD'=> 'Dólares',
        'PEN' => 'Soles'
    ];

    /**
     * @var string[] $listeners
     */
    protected $listeners = [
        'editPrice' => 'edit',
        'deletePrice' => 'delete'
    ];

    public function render()
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

            $this->emit('refreshLivewireDatatable');
        } catch (\Exception $e) {
        }
    }
}

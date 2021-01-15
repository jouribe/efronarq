<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUnused */

namespace App\Http\Livewire\PullAparts;

use App\Models\Customer;
use App\Models\PullApart;
use App\Models\Visit;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Create extends Component
{
    /**
     * @var Visit $visit
     */
    public Visit $visit;

    /**
     * @var Customer $customer
     */
    public Customer $customer;

    /**
     * @var mixed $pullApart
     */
    public $pullApart;

    /**
     * @var string $apartmentNro
     */
    public string $apartmentNro;

    /**
     * @var string $priceApartment
     */
    public string $priceApartmentText;

    /**
     * @var float $priceApartment
     */
    public float $priceApartment;

    /**
     * @var float $priceClosets
     */
    public float $priceClosets;

    /**
     * @var float $priceParkingLots
     */
    public float $priceParkingLots;

    /**
     * @var string $priceTotalText
     */
    public string $priceTotalText;

    /**
     * @var float $priceTotal
     */
    public float $priceTotal;

    /**
     * @var array|string[] $buyerTypeList
     */
    public array $buyerTypeList = [
        'Soltero(a)' => 'Soltero(a)',
        'Sociedad Conyugal' => 'Sociedad Conyugal',
        'Copropietario' => 'Copropietario',
        'Empresa' => 'Empresa'
    ];

    /**
     * @var string $buyerType
     */
    public string $buyerType = 'Soltero(a)';

    /**
     * @var array|string[] $discountList
     */
    public array $discountList = [
        1 => 'Monto',
        2 => 'Porcentaje'
    ];

    /**
     * @var mixed $discountType
     */
    public $discountType;

    /**
     * @var mixed $amount
     */
    public $amount;

    /**
     * @var string $customerName
     */
    public string $customerFirstName;

    /**
     * @var string $customerLastName
     */
    public string $customerLastName;

    /**
     * @var string $customerDocument
     */
    public string $customerDocument;

    /**
     * @var mixed $customerAddress
     */
    public $customerAddress;

    /**
     * @var string $customerEmail
     */
    public string $customerEmail;

    /**
     * @var string $customerPhone
     */
    public string $customerPhone;

    /**
     * Render create view
     *
     * @return Application|Factory|View
     */
    public function render(): Factory|View|Application
    {
        $this->settingData();
        $this->settingCustomerData();

        return view('livewire.pull-aparts.create');
    }

    /**
     * Setting data
     */
    public function settingData(): void
    {
        $this->pullApart = PullApart::whereVisitId($this->visit->id)->first();

        if (!is_null($this->pullApart)) {
            $this->discountType = $this->pullApart->discount_type;
            $this->amount = $this->pullApart->discount;
        }

        $this->apartmentNro = $this->visit->apartment->apartmentType->type_name;

        $this->setApartmentPrice();

        if (!is_null($this->visit->parkingLots)) {
            $this->setParkingLotsPrice();
        }

        if (!is_null($this->visit->closets)) {
            $this->setClosetPrice();
        }

        $this->priceTotal = $this->priceApartment + $this->priceParkingLots + $this->priceClosets;
        $this->priceTotalText = 'US$ ' . number_format($this->priceTotal, 2);

        if ($this->amount !== '' && !is_null($this->discountType)) {
            $this->priceTotal -= match ((int)$this->discountType) {
                1 => $this->amount,
                2 => ($this->priceTotal * ($this->amount / 100)),
            };

            $this->priceTotalText = 'US$ ' . number_format($this->priceTotal, 2);
        }
    }

    /**
     * Setting customer data.
     */
    public function settingCustomerData(): void
    {
        $this->customerFirstName = $this->visit->customer->first_name;
        $this->customerLastName = $this->visit->customer->last_name;
        $this->customerDocument = $this->visit->customer->dni;
        $this->customerAddress = $this->visit->customer->address;
        $this->customerEmail = $this->visit->customer->email;
        $this->customerPhone = $this->visit->customer->phone;
    }

    /**
     * Setting price for apartment.
     */
    public function setApartmentPrice(): void
    {
        $apartmentTotalArea = $this->visit->apartment->apartmentType->roofed_area + $this->visit->apartment->apartmentType->free_area;

        $this->priceApartment = $this->visit->apartment->apartmentType->priceApartments->first()->price_area * $apartmentTotalArea;
        $this->priceApartmentText = 'US$ ' . number_format($this->priceApartment, 2);
    }

    /**
     * Setting parking lot price
     */
    public function setParkingLotsPrice(): void
    {
        $this->priceParkingLots = 0;

        foreach ($this->visit->parkingLots as $parkingLot) {
            $this->priceParkingLots += $parkingLot->parkingLot->project->parkingLotPrices->first()->price;
        }
    }

    /**
     * Setting parking lot price.
     */
    public function setClosetPrice(): void
    {
        $this->priceClosets = 0;

        foreach ($this->visit->closets as $closet) {
            $this->priceClosets += $closet->closet->project->closetPrices->first()->price * $closet->closet->roofed_area;
        }
    }

    public function storeGeneralPrice(): void
    {
        PullApart::updateOrCreate([
            'id' => $this->pullApart === null ? null : $this->pullApart->id
        ], [
            'visit_id' => $this->visit->id,
            'discount_type' => $this->discountType,
            'discount' => $this->amount,
            'final_price' => $this->priceTotal
        ]);

        session()->flash('message', $this->pullApart->id ? __('Pull apart updated successfully!') : __('Pull apart created successfully!'));
    }
}

<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUnused */

namespace App\Http\Livewire\PullAparts;

use App\Models\Customer;
use App\Models\PullApart;
use App\Models\PullApartFee;
use App\Models\Visit;
use Carbon\Carbon;
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
     * @var mixed $apartmentNro
     */
    public $apartmentNro;

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
     * @var string $paymentType
     */
    public string $paymentType = 'Directo';

    /**
     * @var array|string[] $paymentTypeList
     */
    public array $paymentTypeList = [
        'Directo' => 'Directo',
        'Hipotecario' => 'Hipotecario',
        'Mixto' => 'Mixto'
    ];

    /**
     * @var mixed $discountType
     */
    public $discountType;

    /**
     * @var mixed $discountAmount
     */
    public $discountAmount;

    /**
     * Amount of the pull apart.
     *
     * @var mixed $amount
     */
    public $amount = 0;

    /**
     * @var mixed $amountAt
     */
    public $amountAt;

    /**
     * @var mixed $milestone
     */
    public $milestone;

    /**
     * @var mixed $balance
     */
    public $balance;

    /**
     * @var mixed $feeCount
     */
    public $feeCount = 0;

    /**
     * @var mixed $fee
     */
    public $fee;

    /**
     * @var mixed $feeAt
     */
    public $feeAt;

    /**
     * @var mixed $feeMilestone
     */
    public $feeMilestone;

    /**
     * @var mixed $inputs
     */
    public $inputs = [];

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
     * @var mixed $separationAgreementAt
     */
    public $separationAgreementAt;

    /**
     * @var mixed $signatureMinuteAt
     */
    public $signatureMinuteAt;

    /**
     * @var mixed $comment
     */
    public $comment;

    /**
     * Component mount.
     */
    public function mount(): void
    {
        $this->settingData();
        //$this->setGlobalPrice();
        $this->settingCustomerData();
        $this->setApartmentPrice();
        $this->setParkingLotsPrice();
        $this->setClosetPrice();
        $this->settingDateAgreementAndSignMinute();
        $this->settingFees();
    }

    /**
     * Render create view
     *
     * @return Application|Factory|View
     */
    public function render(): Factory|View|Application
    {
        $this->updateBalance();

        return view('livewire.pull-aparts.create');
    }

    /**
     * Setting pay agreement and sign minute dates.
     */
    public function settingDateAgreementAndSignMinute(): void
    {
        if (!is_null($this->pullApart)) {
            $this->separationAgreementAt = $this->pullApart->separation_agreement_at;
            $this->signatureMinuteAt = $this->pullApart->signature_minute_at;
        }
    }

    /**
     * Setting fees.
     */
    public function settingFees(): void
    {
        if (!is_null($this->pullApart)) {
            $this->amount = $this->pullApart->amount;
            $this->amountAt = $this->pullApart->amount_at;
            $this->milestone = $this->pullApart->milestone;

            $fees = PullApartFee::wherePullApartId($this->pullApart->id)->get();

            $this->feeCount = $fees->count();

            $this->generateFeeInputs();

            foreach ($fees as $key => $value) {
                $this->fee[$key] = 'US$ ' . number_format($value->fee, 2);
                $this->feeAt[$key] = $value->fee_at;
                $this->feeMilestone[$key] = $value->milestone;
            }
        }
    }

    /**
     * Setting data
     */
    public function settingData(): void
    {
        $this->pullApart = PullApart::whereVisitId($this->visit->id)->first();

        if (!is_null($this->pullApart)) {
            $this->settingPriceFromPullApart();
        } else {
            $this->settingPriceFromForm();
        }

        $this->apartmentNro = $this->visit->apartment->name;
    }

    /**
     * Update balance amount.
     */
    public function updateBalance(): void
    {
        if ($this->amount === '') {
            $this->amount = 0;
        }

        $this->balance = 'US$ ' . number_format($this->priceTotal - $this->amount, 2);
    }

    /**
     * Setting price discount and final price if pull apart exists in db.
     */
    public function settingPriceFromPullApart(): void
    {
        $this->discountType = $this->pullApart->discount_type;
        $this->discountAmount = $this->pullApart->discount;
        $this->priceTotal = $this->pullApart->final_price;
        $this->priceTotalText = 'US$ ' . number_format($this->priceTotal, 2);
        $this->balance = 'US$ ' . number_format($this->priceTotal - $this->amount, 2);
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
     * Modify the global price by choosing amount of discount.
     */
    public function modifyPrice(): void
    {
        if ($this->discountAmount !== '' && !is_null($this->discountType)) {
            $this->priceTotal -= match ((int)$this->discountType) {
                1 => $this->discountAmount,
                2 => ($this->priceTotal * ($this->discountAmount / 100)),
            };

            $this->priceTotalText = 'US$ ' . number_format($this->priceTotal, 2);
        }
    }

    /**
     * Setting global price.
     */
    public function settingPriceFromForm(): void
    {
        $this->priceTotal = $this->priceApartment + $this->priceParkingLots + $this->priceClosets;
        $this->priceTotalText = 'US$ ' . number_format($this->priceTotal, 2);
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
        if (!is_null($this->visit->parkingLots)) {
            $this->priceParkingLots = 0;

            foreach ($this->visit->parkingLots as $parkingLot) {
                $this->priceParkingLots += $parkingLot->parkingLot->project->parkingLotPrices->first()->price;
            }
        }
    }

    /**
     * Setting parking lot price.
     */
    public function setClosetPrice(): void
    {
        if (!is_null($this->visit->closets)) {
            $this->priceClosets = 0;

            foreach ($this->visit->closets as $closet) {
                $this->priceClosets += $closet->closet->project->closetPrices->first()->price * $closet->closet->roofed_area;
            }
        }
    }

    /**
     * Store pull apart general price.
     *
     * @return void
     */
    public function storeGeneralPrice(): void
    {
        PullApart::updateOrCreate([
            'id' => $this->pullApart === null ? null : $this->pullApart->id
        ], [
            'visit_id' => $this->visit->id,
            'discount_type' => $this->discountType,
            'discount' => $this->discountAmount,
            'final_price' => $this->priceTotal
        ]);

        session()->flash('message', !is_null($this->pullApart) ? __('Pull apart updated successfully!') : __('Pull apart created successfully!'));
    }

    /**
     * Store pull apart owner.
     *
     * @return void
     */
    public function storeOwner(): void
    {
        Customer::whereId($this->visit->customer->id)->update([
            'first_name' => $this->customerFirstName,
            'last_name' => $this->customerLastName,
            'email' => $this->customerEmail,
            'dni' => $this->customerDocument,
            'phone' => $this->customerPhone,
            'customer_type' => $this->buyerType === 'Empresa' ? 'Persona Jurídica' : 'Persona Natural',
            'single' => $this->buyerType === 'Sociedad Conyugal',
            'address' => $this->customerAddress
        ]);

        session()->flash('message', __('Customer updated successfully'));
    }

    /**
     * Generate fee inputs.
     */
    public function generateFeeInputs(): void
    {
        unset($this->inputs);

        $this->inputs = [];

        if ((int)$this->feeCount > 0) {
            for ($i = 0; $i < (int)$this->feeCount; $i++) {
                $this->inputs[] = $i;
            }

            $feeAmount = ($this->priceTotal - $this->amount) / $this->feeCount;

            foreach ($this->inputs as $key => $value) {
                $this->fee[$key] = 'US$ ' . number_format($feeAmount, 2);

                if (!is_null($this->amountAt)) {
                    $this->feeAt[$key] = Carbon::parse($this->amountAt)->addMonthsNoOverflow($key + 1)->format('Y-m-d');
                }
            }
        }
    }

    /**
     * Store fees to pull apart.
     */
    public function storePullApartFee(): void
    {
        PullApart::whereId($this->pullApart->id)->update([
            'amount' => $this->amount,
            'amount_at' => $this->amountAt,
            'milestone' => $this->milestone === '' ? null : $this->milestone,
        ]);

        // Search fee for this pull apart.
        $fees = PullApartFee::wherePullApartId($this->pullApart->id)->get();

        // Remove all fees to register the new ones.
        foreach ($fees as $fee) {
            PullApartFee::whereId($fee->id)->delete();
        }

        // register all fees.
        foreach ($this->fee as $key => $value) {
            $fee = (float)preg_replace("/[^-0-9.]/", "", str_replace('US$ ', '', $value));

            PullApartFee::create([
                'pull_apart_id' => $this->pullApart->id,
                'fee' => $fee,
                'fee_at' => $this->feeAt[$key],
                'milestone' => is_null($this->feeMilestone) ? null : $this->feeMilestone[$key]
            ]);
        }
    }

    /**
     * Store pay agreement and sign minute dates.
     */
    public function storeAgreementAndSignMinute(): void
    {
        PullApart::whereId($this->pullApart->id)->update([
            'separation_agreement_at' => $this->separationAgreementAt,
            'signature_minute_at' => $this->signatureMinuteAt
        ]);
    }

    /**
     * Send pull apart to approve/reject.
     */
    public function sendToApprove(): void
    {
        if (!is_null($this->pullApart)) {
            PullApart::whereId($this->pullApart->id)->update([
                'comment' => $this->comment,
                'status' => 'Pendiente Aprobación'
            ]);

            session()->flash('sendToApprove', __('Pull apart submitted for approval successfully'));
        }
    }
}

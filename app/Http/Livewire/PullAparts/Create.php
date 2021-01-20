<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUnused */

namespace App\Http\Livewire\PullAparts;

use App\Models\Bank;
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
     * @var mixed $bankList
     */
    public $bankList;

    /**
     * @var mixed $bankId
     */
    public $bankId;

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
     * @var mixed $paymentType
     */
    public $paymentType;

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
     * @var mixed $feeBalance
     */
    public $feeBalance;

    /**
     * @var mixed $feeBalanceAt
     */
    public $feeBalanceAt;

    /**
     * @var mixed $feeBalanceMilestone
     */
    public $feeBalanceMilestone;

    /**
     * @var mixed $afpAmount
     */
    public $afpAmount;

    /**
     * @var mixed $afpAmountAt
     */
    public $afpAmountAt;

    /**
     * @var mixed $afpAmountMilestone
     */
    public $afpAmountMilestone;

    /**
     * @var mixed $creditAmount
     */
    public $creditAmount;

    /**
     * @var mixed $creditAmountAt
     */
    public $creditAmountAt;

    /**
     * @var mixed $creditAmountMilestone
     */
    public $creditAmountMilestone;

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
        $this->settingPaymentType();

    }

    /**
     * Render create view
     *
     * @return Application|Factory|View
     */
    public function render(): Factory|View|Application
    {
        $this->bankList = Bank::whereIsActive(true)->pluck('name', 'id');

        $this->updateBalance();

        if (!is_null($this->pullApart)) {
            $this->resetPaymentFees();
        }

        return view('livewire.pull-aparts.create');
    }

    /**
     * Setting payment type.
     */
    public function settingPaymentType(): void
    {
        if (!is_null($this->pullApart)) {
            $this->paymentType = $this->pullApart->payment_type;
        }
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

            if ($this->pullApart->payment_type === 'Hipotecario' || $this->pullApart->payment_type === 'Mixto') {
                $this->afpAmount = $this->pullApart->afp_amount;
                $this->afpAmountAt = $this->pullApart->afp_amount_at;
                $this->afpAmountMilestone = $this->pullApart->afp_amount_milestone;
                $this->creditAmount = $this->pullApart->mortgage_credit;
                $this->creditAmountAt = $this->pullApart->mortgage_credit_at;
                $this->creditAmountMilestone = $this->pullApart->mortgage_credit_milestone;
                $this->feeBalanceAt = $this->pullApart->fee_balance_at;
                $this->bankId = $this->pullApart->bank_id;
            }

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

        if ($this->afpAmount === '') {
            $this->afpAmount = 0;
        }

        if ($this->creditAmount === '') {
            $this->creditAmount = 0;
        }

        $this->balance = $this->feeBalance = 'US$ ' . number_format($this->priceTotal - ($this->amount + $this->afpAmount + $this->creditAmount), 2);
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
        $this->inputs = [];
        $this->fee = [];

        if ((int)$this->feeCount > 0) {
            for ($i = 0; $i < (int)$this->feeCount; $i++) {
                $this->inputs[] = $i;
            }

            $feeAmount = ($this->priceTotal - ($this->amount + $this->afpAmount + $this->creditAmount)) / $this->feeCount;

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
        $feeBalance = null;

        if ($this->feeBalance !== '') {
            $feeBalance = (float)preg_replace("/[^-0-9.]/", "", str_replace('US$ ', '', $this->feeBalance));
        }

        PullApart::whereId($this->pullApart->id)->update([
            'payment_type' => $this->paymentType,
            'bank_id' => $this->bankId,
            'amount' => $this->amount,
            'amount_at' => $this->amountAt,
            'milestone' => $this->milestone === '' ? null : $this->milestone,
            'fee_balance' => $feeBalance,
            'fee_balance_at' => $this->feeBalanceAt,
            'fee_balance_milestone' => $this->feeBalanceMilestone,
            'afp_amount' => $this->afpAmount,
            'afp_amount_at' => $this->afpAmountAt,
            'afp_amount_milestone' => $this->afpAmountMilestone,
            'mortgage_credit' => $this->creditAmount,
            'mortgage_credit_at' => $this->creditAmountAt,
            'mortgage_credit_milestone' => $this->creditAmountMilestone
        ]);

        $this->removeFeesIfExist();

        // Remove fees inputs if payment type is Hipotecario.
        if ($this->paymentType === 'Hipotecario') {
            $this->fee = [];
        }

        // register all fees only if payment type not is Hipotecario.
        foreach ($this->fee as $key => $value) {
            $fee = (float)preg_replace("/[^-0-9.]/", "", str_replace('US$ ', '', $value));

            $milestone = null;

            if (!is_null($this->feeMilestone) && isset($this->feeMilestone[$key])) {
                $milestone = $this->feeMilestone[$key];
            }

            PullApartFee::create([
                'pull_apart_id' => $this->pullApart->id,
                'fee' => $fee,
                'fee_at' => $this->feeAt[$key],
                'milestone' => $milestone
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

    /**
     * Remove pull apart fees if exist.
     *
     * @return void
     */
    public function removeFeesIfExist(): void
    {
        // Search fee for this pull apart.
        $fees = PullApartFee::wherePullApartId($this->pullApart->id)->get();

        // Remove all fees to register the new ones.
        foreach ($fees as $fee) {
            PullApartFee::whereId($fee->id)->delete();
        }
    }

    public function resetPaymentFees(): void
    {
        if ($this->paymentType !== $this->pullApart->payment_type) {
            $this->amount = '';
            $this->amountAt = null;
            $this->milestone = '';
            $this->creditAmount = '';
            $this->afpAmount = '';

            $this->updateBalance();

            PullApart::whereId($this->pullApart->id)->update([
                'payment_type' => $this->paymentType,
                'bank_id' => null,
                'amount' => 0,
                'amount_at' => null,
                'milestone' => null,
                'fee_balance' => null,
                'fee_balance_at' => null,
                'fee_balance_milestone' => null,
                'afp_amount' => null,
                'afp_amount_at' => null,
                'afp_amount_milestone' => null,
                'mortgage_credit' => null,
                'mortgage_credit_at' => null,
                'mortgage_credit_milestone' => null,
            ]);

            $this->removeFeesIfExist();
        }
    }
}

<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUnused */

namespace App\Http\Livewire\PullAparts;

use App\Models\Bank;
use App\Models\Company;
use App\Models\Customer;
use App\Models\CustomerRelated;
use App\Models\PullApart;
use App\Models\PullApartComment;
use App\Models\PullApartFee;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    /**
     * @var Visit $visit
     */
    public Visit $visit;

    /**
     * @var Customer $customer
     */
    public mixed $customer;

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
     * @var mixed $priceApartment
     */
    public $priceApartmentText;

    /**
     * @var mixed $priceApartment
     */
    public $priceApartment;

    /**
     * @var mixed $priceClosets
     */
    public $priceClosets;

    /**
     * @var mixed $priceParkingLots
     */
    public $priceParkingLots;

    /**
     * @var string $priceTotalText
     */
    public string $priceTotalText;

    /**
     * @var mixed $priceTotal
     */
    public $priceTotal;

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
     * @var mixed $customerFirstNameSecond
     */
    public $customerFirstNameSecond;

    /**
     * @var mixed $customerLastNameSecond
     */
    public $customerLastNameSecond;

    /**
     * @var mixed $customerDocumentSecond
     */
    public $customerDocumentSecond;

    /**
     * @var mixed $customerAddressSecond
     */
    public $customerAddressSecond;

    /**
     * @var mixed $customerEmailSecond
     */
    public $customerEmailSecond;

    /**
     * @var mixed $customerPhoneSecond
     */
    public $customerPhoneSecond;

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
     * @var mixed $partnerType
     */
    public $partnerType = 'Tradicional';

    /**
     * @var mixed $partnerTypeList
     */
    public $partnerTypeList = [
        'Tradicional' => 'Tradicional',
        'Casado con separación de patrimonio' => 'Casado con separación de patrimonio'
    ];

    /**
     * @var mixed $companyName
     */
    public $companyName;

    /**
     * @var mixed $companyTaxNr
     */
    public $companyTaxNr;

    /**
     * @var mixed $companyAddress
     */
    public $companyAddress;

    /**
     * @var mixed $companyEmail
     */
    public $companyEmail;

    /**
     * @var mixed $companyPhone
     */
    public $companyPhone;

    /**
     * @var mixed $customerPosition
     */
    public $customerPosition;

    /**
     * @var mixed $customerDocumentNro
     */
    public $customerDocumentNro;

    /**
     * @var mixed $partOne
     */
    public $partOne;

    /**
     * @var mixed $partTwo
     */
    public $partTwo;

    /**
     * @var mixed $documentNro
     */
    public $documentNro;

    /**
     * @var mixed $document
     */
    public $document;

    /**
     * @var mixed $lastPaymentType
     */
    public $lastPaymentType;

    /**
     * @var mixed $paymentEdit
     */
    public $paymentEdit = false;

    /**
     * @var mixed $statusType
     */
    public $statusType;

    /**
     * @var mixed $statusList
     */
    public $statusList = [
        'Soltero(a)' => 'Soltero(a)',
        'Casado(a)' => 'Casado(a)'
    ];

    /**
     * @var mixed $current_document
     */
    public $current_document;

    /**
     * @var mixed $pullApartStaticStatus
     */
    public $pullApartStaticStatus = 'Aprobado';

    /**
     * Component mount.
     */
    public function mount(): void
    {
        $this->bankList = Bank::whereIsActive(true)->pluck('name', 'id');

        $this->settingData();
        $this->settingCustomerData();
        $this->setApartmentPrice();
        $this->setParkingLotsPrice();
        $this->setClosetPrice();

        if (!is_null($this->pullApart)) {
            $this->settingPriceFromPullApart();
        } else {
            $this->settingPriceFromForm();
        }

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
        $this->modifyPrice();
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

            $pullApartFee = $this->pullApart->fees()->whereType('Monto Separación')->first();

            if (!is_null($pullApartFee)) {
                $this->amount = $pullApartFee->fee;
                $this->amountAt = $pullApartFee->fee_at;
                $this->milestone = $pullApartFee->milestone;

                if ($this->pullApart->payment_type === 'Hipotecario' || $this->pullApart->payment_type === 'Mixto') {
                    $this->afpAmount = $this->getFeeByType('AFP');
                    $this->afpAmountAt = $this->getFeeAtByType('AFP');
                    $this->afpAmountMilestone = $this->getFeeMilestoneByType('AFP');
                    $this->creditAmount = $this->getFeeByType('Crédito Hipotecario');
                    $this->creditAmountAt = $this->getFeeAtByType('Crédito Hipotecario');
                    $this->creditAmountMilestone = $this->getFeeMilestoneByType('Crédito Hipotecario');
                    $this->bankId = $this->pullApart->bank_id;
                }

                if ($this->pullApart->payment_type === 'Hipotecario') {
                    $this->feeBalanceAt = $this->getFeeAtByType('Saldo Cuota Inicial');
                }

                $fees = PullApartFee::wherePullApartId($this->pullApart->id)->where('type', '=', 'Cuota')->get();

                $this->feeCount = $fees->count();

                $this->generateFeeInputs();

                foreach ($fees as $key => $value) {
                    $this->fee[$key] = 'US$ ' . number_format($value->fee, 2);
                    $this->feeAt[$key] = $value->fee_at;
                    $this->feeMilestone[$key] = $value->milestone;
                }
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
            $this->lastPaymentType = $this->pullApart->payment_type;
        }
    }

    /**
     * Update balance amount.
     */
    public function updateBalance(): void
    {
        $amount = 0;

        if ($this->amount !== '') {
            $amount = $this->amount;
        }

        $afpAmount = 0;

        if ($this->afpAmount !== '') {
            $afpAmount = $this->afpAmount;
        }

        $creditAmount = 0;

        if ($this->creditAmount !== '') {
            $creditAmount = $this->creditAmount;
        }

        $finalPrice = 0;

        if (!is_null($this->pullApart)) {
            $finalPrice = $this->pullApart->final_price;
        }

        $this->balance = $this->feeBalance = 'US$ ' . number_format($finalPrice - ($amount + $afpAmount + $creditAmount), 2);
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
     * Setting global price.
     */
    public function settingPriceFromForm(): void
    {
        $this->priceTotal = $this->priceApartment + $this->priceParkingLots + $this->priceClosets;
        $this->priceTotalText = 'US$ ' . number_format($this->priceTotal, 2);
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

        if ($this->visit->customer->single === 0 && is_null($this->visit->customer->company_id)) {
            $this->buyerType = 'Sociedad Conyugal';

            $relatedBy = CustomerRelated::whereCustomerId($this->visit->customer->id)->first();
            $related = Customer::whereId($relatedBy->customer_related_id)->first();

            $this->customerFirstNameSecond = $related->first_name;
            $this->customerLastNameSecond = $related->last_name;
            $this->customerDocumentSecond = $related->dni;
            $this->customerAddressSecond = $related->address;
            $this->customerEmailSecond = $related->email;
            $this->customerPhoneSecond = $related->phone;
            $this->partnerType = $relatedBy->partner_type;
            $this->partOne = $relatedBy->part_one;
            $this->partTwo = $relatedBy->part_two;
            $this->documentNro = $relatedBy->document_nro;
            $this->current_document = $relatedBy->document;
        }
    }

    /**
     * Modify the global price by choosing amount of discount.
     */
    public function modifyPrice(): void
    {
        $this->priceTotal = $this->setTotalPriceOfSale((float)$this->discountAmount);

        $this->priceTotalText = 'US$ ' . number_format($this->priceTotal, 2);
    }

    /**
     * Setting price for apartment.
     */
    public function setApartmentPrice(): void
    {
        $this->priceApartment = $this->visit->apartment->price;
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
                $this->priceParkingLots += $parkingLot->parkingLot->price;
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
                $this->priceClosets += $closet->closet->price;
            }
        }
    }

    /**
     * Get the total price without discounts.
     *
     * @param mixed $discount
     * @return float
     */
    public function setTotalPriceOfSale(mixed $discount): float
    {
        if (!is_null($this->pullApart)) {
            $this->priceApartment = $this->pullApart->visit->apartment->price;
        } else {
            $this->setApartmentPrice();
        }

        if (!is_null($this->discountType)) {
            $this->priceApartment -= match ((int)$this->discountType) {
                1 => $discount,
                2 => ($this->priceApartment * ($discount / 100)),
            };
        }

        return $this->priceApartment + $this->priceParkingLots + $this->priceClosets;
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
        if (!is_null($this->pullApart)) {
            PullApart::whereId($this->pullApart->id)->update([
                'buyer_type' => $this->buyerType
            ]);
        }

        $customer = Customer::whereId($this->visit->customer->id)->first();

        $customer->update([
            'first_name' => $this->customerFirstName,
            'last_name' => $this->customerLastName,
            'email' => $this->customerEmail,
            'dni' => $this->customerDocument,
            'phone' => $this->customerPhone,
            'customer_type' => $this->buyerType === 'Empresa' ? 'Persona Jurídica' : 'Persona Natural',
            'single' => $this->buyerType !== 'Sociedad Conyugal',
            'address' => $this->customerAddress
        ]);

        if ($this->buyerType !== 'Soltero(a)') {

            if ($this->buyerType === 'Empresa') {
                $companyFindByTaxNr = Company::whereTaxNro($this->companyTaxNr)->first();

                $company = Company::updateOrCreate([
                    'id' => $companyFindByTaxNr
                ], [
                    'name' => $this->companyName,
                    'tax_nro' => $this->companyTaxNr,
                    'address' => $this->companyAddress,
                    'email' => $this->companyEmail,
                    'phone' => $this->companyPhone
                ]);

                $customerCompanyByDni = Customer::whereDni($this->customerDocumentSecond)->first();

                Customer::updateOrCreate([
                    'id' => $customerCompanyByDni->id
                ], [
                    'first_name' => $this->customerFirstNameSecond,
                    'last_name' => $this->customerLastNameSecond,
                    'dni' => $this->customerDocumentSecond,
                    'email' => $this->customerEmailSecond,
                    'phone' => $this->customerPhoneSecond,
                    'single' => $this->statusList === 'Soltero(a)',
                    'address' => $this->customerAddressSecond,
                    'position' => $this->customerPosition,
                    'company_id' => $company->id,
                    'document_nro' => $this->customerDocumentNro
                ]);
            }

            if ($this->buyerType === 'Sociedad Conyugal' || $this->buyerType = 'Copropietario') {
                $customerByDni = Customer::whereDni($this->customerDocumentSecond)->first();

                $customerSecond = Customer::updateOrCreate([
                    'id' => $customerByDni === null ? null : $customerByDni->id
                ], [
                    'first_name' => $this->customerFirstNameSecond,
                    'last_name' => $this->customerLastNameSecond,
                    'dni' => $this->customerDocumentSecond,
                    'email' => $this->customerEmailSecond,
                    'phone' => $this->customerPhoneSecond,
                    'single' => $this->buyerType !== 'Sociedad Conyugal',
                    'address' => $this->customerAddressSecond,
                ]);

                $customerRelatedByCustomerId = CustomerRelated::whereCustomerId($customer->id)->first();

                $documentPath = $this->current_document;

                if ($this->document !== null && $this->document !== '') {
                    $documentPath = $this->document->store('customer-documents', 'public');
                }

                CustomerRelated::updateOrCreate([
                    'id' => $customerRelatedByCustomerId === null ? null : $customerRelatedByCustomerId->id
                ], [
                    'customer_id' => $customer->id,
                    'customer_related_id' => $customerSecond->id,
                    'type' => $this->buyerType,
                    'partner_type' => $this->partnerType,
                    'part_one' => $this->partOne,
                    'part_two' => $this->partTwo,
                    'document_nro' => $this->documentNro,
                    'document' => $documentPath
                ]);
            }
        }

        session()->flash('customerUpdated', __('Customer updated successfully'));
    }

    /**
     * Generate fee inputs.
     */
    public function generateFeeInputs(): void
    {
        $this->inputs = [];
        $this->fee = [];


        $amount = 0;

        if (!is_null($this->amount)) {
            $amount = (float)$this->amount;
        }

        $afpAmount = 0;

        if (!is_null($this->afpAmount)) {
            $afpAmount = (float)$this->afpAmount;
        }

        $creditAmount = 0;

        if (!is_null($this->creditAmount)) {
            $creditAmount = (float)$this->creditAmount;
        }

        if ((int)$this->feeCount > 0) {
            for ($i = 0; $i < (int)$this->feeCount; $i++) {
                $this->inputs[] = $i;
            }

            $feeAmount = ($this->priceTotal - ($amount + $afpAmount + $creditAmount)) / $this->feeCount;

            foreach ($this->inputs as $key => $value) {
                $this->fee[$key] = 'US$ ' . number_format($feeAmount, 2);

                if (!is_null($this->amountAt)) {
                    $this->feeAt[$key] = Carbon::parse($this->amountAt)->addMonthsNoOverflow($key + 1)->format('Y-m-d');
                }

                if (!is_null($this->feeBalanceAt)) {
                    $this->feeAt[$key] = Carbon::parse($this->feeBalanceAt)->addMonthsNoOverflow($key + 1)->format('Y-m-d');
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

        $amount = 0;

        if (is_numeric($this->amount)) {
            $amount = $this->amount;
        }

        $afpAmount = 0;

        if (is_numeric($this->afpAmount)) {
            $afpAmount = $this->afpAmount;
        }

        $creditAmount = 0;

        if (is_numeric($this->creditAmount)) {
            $creditAmount = $this->creditAmount;
        }

        $validateAmount = $this->priceTotal - ($amount + $afpAmount + $creditAmount);

        if (!is_null($this->fee)) {
            foreach ($this->fee as $key => $value) {
                $fee = (float)preg_replace("/[^-0-9.]/", "", str_replace('US$ ', '', $value));

                $validateAmount -= $fee;
            }
        }

        if ($this->paymentType === 'Hipotecario') {
            $validateAmount = 0;
        }

        if ($validateAmount <= 0) {

            if (session()->has('amountValidation')) {
                session()->forget('amountValidation');
            }

            PullApart::whereId($this->pullApart->id)->update([
                'payment_type' => $this->paymentType,
                'bank_id' => $this->bankId,
            ]);

            $this->removeFeesIfExist();

            // Remove fees inputs if payment type is Hipotecario.
            if ($this->paymentType === 'Hipotecario') {
                $this->fee = [];
            }

            if ($this->paymentType === 'Directo') {
                PullApartFee::create([
                    'pull_apart_id' => $this->pullApart->id,
                    'fee' => $this->amount,
                    'fee_at' => $this->amountAt,
                    'milestone' => $this->milestone === '' ? null : $this->milestone,
                    'type' => 'Monto Separación'
                ]);
            } else {
                if ($this->feeBalance !== '') {
                    $feeBalance = (float)preg_replace("/[^-0-9.]/", "", str_replace('US$ ', '', $this->feeBalance));
                }

                PullApartFee::create([
                    'pull_apart_id' => $this->pullApart->id,
                    'fee' => $this->amount,
                    'fee_at' => $this->amountAt,
                    'milestone' => $this->milestone === '' ? null : $this->milestone,
                    'type' => 'Monto Separación'
                ]);

                if (is_numeric($this->afpAmount)) {
                    PullApartFee::create([
                        'pull_apart_id' => $this->pullApart->id,
                        'fee' => $this->afpAmount,
                        'fee_at' => $this->afpAmountAt,
                        'milestone' => $this->afpAmountMilestone === '' ? null : $this->afpAmountMilestone,
                        'type' => 'AFP'
                    ]);
                }

                PullApartFee::create([
                    'pull_apart_id' => $this->pullApart->id,
                    'fee' => $this->creditAmount,
                    'fee_at' => $this->creditAmountAt,
                    'milestone' => $this->creditAmountMilestone === '' ? null : $this->creditAmountMilestone,
                    'type' => 'Crédito Hipotecario'
                ]);


                if (($this->paymentType === 'Hipotecario') && $this->feeBalance > 0) {
                    PullApartFee::create([
                        'pull_apart_id' => $this->pullApart->id,
                        'fee' => $feeBalance,
                        'fee_at' => $this->feeBalanceAt,
                        'milestone' => $this->feeBalanceMilestone === '' ? null : $this->feeBalanceMilestone,
                        'type' => 'Saldo Cuota Inicial'
                    ]);
                }
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
                    'milestone' => $milestone,
                    'type' => 'Cuota'
                ]);
            }

            session()->flash('feeSuccess', __('Pull apart fee store successfully!'));
        } else {
            session()->flash('amountValidation', __('La suma de los montos de las cuotas no coinciden con el valor de venta total'));
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

        session()->flash('datesUpdated', __('Dates updated successfully!'));
    }

    /**
     * Send pull apart to approve/reject.
     */
    public function sendToApprove(): void
    {
        if (!is_null($this->pullApart)) {

            $status = $this->pullApartStaticStatus;

            /** @noinspection NullPointerExceptionInspection */
            if (!auth()->user()->hasRole('admin')) {
                $status = 'Pendiente Aprobación';
            }

            PullApartComment::create([
                'comment' => $this->comment,
                'status' => $status,
                'user_id' => auth()->user()->id,
                'pull_apart_id' => $this->pullApart->id
            ]);

            PullApart::whereId($this->pullApart->id)->update([
                'status' => $status,
            ]);

            session()->flash('sendToApprove', __('Comment saved successfully!'));

            $this->emit('refreshLivewireDatatable');
        }
    }

    /**
     * Reject pull apart .
     *
     * @return void
     */
    public function pullApartReject(): void
    {
        $this->pullApartStaticStatus = 'Rechazado';

        $this->sendToApprove();
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

    /**
     * Reset all payment fees.
     *
     * @return void
     */
    public function resetPaymentFees(): void
    {
        if ($this->lastPaymentType !== $this->paymentType) {
            $this->lastPaymentType = $this->paymentType;
            $this->paymentEdit = false;

            $this->amount = '';
            $this->amountAt = null;
            $this->milestone = '';
            $this->creditAmount = '';
            $this->creditAmountAt = null;
            $this->afpAmount = '';
            $this->afpAmountAt = null;
            $this->feeBalanceAt = null;
            $this->feeBalanceMilestone = '';
            $this->feeCount = 0;

            $this->updateBalance();
            $this->generateFeeInputs();
        }

        if (($this->paymentType === $this->pullApart->payment_type) && $this->pullApart->fees()->count() > 0) {
            /** @noinspection NestedPositiveIfStatementsInspection */
            if (!$this->paymentEdit) {
                $this->amount = $this->pullApart->fees()->whereType('Monto Separación')->first()->fee;
                $this->afpAmount = $this->getFeeByType('AFP');
                $this->creditAmount = $this->getFeeByType('Crédito Hipotecario');
                $this->updateBalance();
                $this->settingFees();

                $this->paymentEdit = true;
            }
        }
    }

    /**
     * Get fee amount by type
     *
     * @param string $type
     * @return string
     */
    public function getFeeByType(string $type): string
    {
        return $this->pullApart->fees()->whereType($type)->first() !== null ? $this->pullApart->fees()->whereType($type)->first()->fee : '';
    }

    /**
     * Get fee at by type.
     *
     * @param string $type
     * @return mixed
     */
    public function getFeeAtByType(string $type): mixed
    {
        if (is_null($this->pullApart)) {
            return null;
        }

        /** @noinspection PhpExpressionAlwaysNullInspection */
        return $this->pullApart->fees()->whereType($type)->first() !== null ? $this->pullApart->fees()->whereType($type)->first()->fee_at : null;
    }

    /**
     * Get fee milestone by type.
     *
     * @param string $type
     * @return string
     */
    public function getFeeMilestoneByType(string $type): string
    {
        if ($this->pullApart->fees()->whereType($type)->first() !== null) {
            return $this->pullApart->fees()->whereType($type)->first()->milestone ?? '';
        }

        return '';
    }
}

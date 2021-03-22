<?php

/** @noinspection PhpMissingFieldTypeInspection */
/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUnused */

namespace App\Http\Livewire\Sales;

use App\Models\Bank;
use App\Models\Company;
use App\Models\Customer;
use App\Models\CustomerRelated;
use App\Models\Document;
use App\Models\PullApart;
use App\Models\PullApartBill;
use App\Models\PullApartBillHistory;
use App\Models\PullApartChange;
use App\Models\PullApartComment;
use App\Models\PullApartDelivery;
use App\Models\PullApartDocument;
use App\Models\PullApartFee;
use App\Models\PullApartFeePayment;
use App\Models\Visit;
use App\Utils\WordProcessor;
use Arr;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use PhpOffice\PhpWord\Exception\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
     * @var mixed $signedSeparationAgreement
     */
    public $signedSeparationAgreement;

    /**
     * @var mixed $currentSignedSeparationAgreement
     */
    public $currentSignedSeparationAgreement;

    /**
     * @var mixed $swornDeclaration
     */
    public $swornDeclaration;

    /**
     * @var mixed $currentSwornDeclaration
     */
    public $currentSwornDeclaration;

    /**
     * @var mixed $documentControlListType
     */
    public $documentControlListType = [
        'Crédito Hipotecario Con Carta Fianza' => 'Crédito Hipotecario Con Carta Fianza',
        'Crédito Hipotecario Sin Carta Fianza' => 'Crédito Hipotecario Sin Carta Fianza'
    ];

    /**
     * @var mixed $documentControl
     */
    public $documentControl;

    /**
     * @var mixed $documentControlData
     */
    public $documentControlData;

    /**
     * @var mixed $proprietorshipList
     */
    public $proprietorshipList = [
        1 => 'Si',
        0 => 'No'
    ];

    /**
     * @var mixed $proprietorship
     */
    public $proprietorship;

    /**
     * @var mixed $damages
     */
    public $damages;

    /**
     * @var mixed $damagesStr
     */
    public $damagesStr;

    /**
     * @var mixed $unemployment
     */
    public $unemployment;

    /**
     * @var mixed $unemploymentStr
     */
    public $unemploymentStr;

    /**
     * @var mixed $changesSelectList
     */
    public $changesSelectList = [
        1 => 'Si',
        0 => 'No'
    ];

    /**
     * @var mixed $changes
     */
    public $changes;

    /**
     * @var mixed $sanitationSelectList
     */
    public $sanitationSelectList = [
        1 => 'Si',
        0 => 'No'
    ];

    /**
     * @var mixed $sanitation
     */
    public $sanitation;

    /**
     * @var mixed $deliveryApartmentAt
     */
    public $deliveryApartmentAt;

    /**
     * @var mixed $deliveryTermSelectList
     */
    public $deliveryTermSelectList = [
        1 => 'Si',
        0 => 'No'
    ];

    /**
     * @var mixed $deliveryTerm
     */
    public $deliveryTerm;

    /**
     * @var mixed $deliveryTermAmount
     */
    public $deliveryTermAmount;

    /**
     * @var mixed $deliveryTermAmountStr
     */
    public $deliveryTermAmountStr;

    /**
     * @var mixed $additionalTermSelectList
     */
    public $additionalTermSelectList = [
        1 => 'Si',
        0 => 'No'
    ];

    /**
     * @var mixed $additionalTerm
     */
    public $additionalTerm;

    /**
     * @var mixed $additionalTermPenalty
     */
    public $additionalTermPenalty;

    /**
     * @var mixed $additionalTermPenaltyStr
     */
    public $additionalTermPenaltyStr;

    /**
     * @var mixed $additionalTermAt
     */
    public $additionalTermAt;

    /**
     * @var mixed $estimate
     */
    public $estimate;

    /**
     * @var mixed $currentEstimate
     */
    public $currentEstimate;

    /**
     * @var mixed $blueprint
     */
    public $blueprint;

    /**
     * @var mixed $currentBlueprint
     */
    public $currentBlueprint;

    /**
     * @var mixed $changeAmount
     */
    public $changeAmount;

    /**
     * @var mixed $changePaymentAt
     */
    public $changePaymentAt;

    /**
     * @var mixed $estimateDays
     */
    public $estimateDays;

    /**
     * @var mixed $changeDeliveryAt
     */
    public $changeDeliveryAt;

    /**
     * @var mixed $pullApartBillId
     */
    public $pullApartBillId;

    /**
     * @var mixed $footer
     */
    public $footer = 'MINUTA {PROJECT_NAME}/{BUYER_NAME}/{APARTMENT_NRO}/{BUYER_TYPE}/{PAYMENT_TYPE}';

    /**
     * @var mixed $pullApartChangeId
     */
    public $pullApartChangeId;

    /**
     * @var mixed $pullApartDeliveryId
     */
    public $pullApartDeliveryId;

    /**
     * @var mixed $billDeliveryAt
     */
    public $billDeliveryAt;

    /**
     * @var mixed $deliveryApartmentDate
     */
    public $deliveryApartmentDate;

    /**
     * @var mixed $deliveryApartmentTime
     */
    public $deliveryApartmentTime;

    /**
     * @var mixed $executive
     */
    public $executive;

    /**
     * @var mixed $evidence
     */
    public $evidence;

    /**
     * @var mixed $currentEvidence
     */
    public $currentEvidence;

    /**
     * @var mixed $documentControlApprove
     */
    public $documentControlApprove;

    /**
     * @var mixed $documentControlDate
     */
    public $documentControlDate;

    /**
     * @var mixed $documentoControlObservation
     */
    public $documentoControlObservation;

    /**
     * @var mixed $documentControlId
     */
    public $documentControlId;

    /**
     * @var boolean $isOpen
     */
    public bool $isOpen = false;

    /**
     * @var boolean $isOpenAttachNewBill
     */
    public bool $isOpenAttachNewBill = false;

    /**
     * @var mixed $historyPaymentAt
     */
    public $historyPaymentAt;

    /**
     * @var mixed $historyPaymentTypeSelectList
     */
    public $historyPaymentTypeSelectList = [
        'Transferencia' => 'Transferencia',
        'Efectivo' => 'Efectivo',
        'Cheque' => 'Cheque'
    ];

    /**
     * @var mixed $historyPaymentType
     */
    public $historyPaymentType;

    /**
     * @var mixed $historyPaymentCurrency
     */
    public $historyPaymentCurrency;

    /**
     * @var mixed $historyPaymentCurrencySelectList
     */
    public $historyPaymentCurrencySelectList = [
        'USD' => 'Dólar Americano',
        'PEN' => 'Nuevo Sol'
    ];

    /**
     * @var mixed $historyPaymentTicketSelectList
     */
    public $historyPaymentTicketSelectList = [
        'Boleta' => 'Boleta',
        'Factura' => 'Factura'
    ];

    /**
     * @var mixed $historyPaymentTicket
     */
    public $historyPaymentTicket;

    /**
     * @var mixed $historyPaymentTicketNro
     */
    public $historyPaymentTicketNro;

    /**
     * @var mixed $historyPaymentDocumentNro
     */
    public $historyPaymentDocumentNro;

    /**
     * @var mixed $historyPaymentAmount
     */
    public $historyPaymentAmount;

    /**
     * @var mixed $historyPaymentVoucher
     */
    public $historyPaymentVoucher;

    /**
     * @var mixed $historyPaymentCurrentVoucher
     */
    public $historyPaymentCurrentVoucher;

    /**
     * @var mixed $historyPaymentLate
     */
    public $historyPaymentLate;

    /**
     * @var mixed $historyPaymentComment
     */
    public $historyPaymentComment;

    /**
     * @var mixed $historyPaymentExchangeRate
     */
    public $historyPaymentExchangeRate;

    /**
     * @var mixed $historyPaymentFeeSelectList
     */
    public $historyPaymentFeeSelectList;

    /**
     * @var mixed $historyPaymentFeeId
     */
    public $historyPaymentFeeId;

    /**
     * @var mixed $historyPaymentId
     */
    public $historyPaymentId;

    /**
     * @var mixed $batchNro
     */
    public $batchNro;

    /**
     * @var mixed $montante
     */
    public $montante;

    /**
     * @var mixed $montanteStr
     */
    public $montanteStr;

    /**
     * @var string[] $listeners
     */
    protected $listeners = [
        'editHistoryPayment'
    ];

    /**
     * @var mixed $historyBill
     */
    public $historyBill;

    /**
     * @var mixed $currentHistoryBill
     */
    public $currentHistoryBill;

    /**
     * @var mixed $historyBillComment
     */
    public $historyBillComment;

    /**
     * @var mixed $historyBillId
     */
    public $historyBillId;

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
        $this->setQuotationAgreement();

        if (!is_null($this->pullApart)) {
            $this->settingPriceFromPullApart();
        } else {
            $this->settingPriceFromForm();
        }

        $this->settingDateAgreementAndSignMinute();
        $this->settingFees();
        $this->settingPaymentType();
        $this->setDocumentControl();
        $this->setPullApartBill();
        $this->setPullApartDelivery();
    }

    /**
     * The attributes that are mass assignable.
     */
    public function attachNewBill(): void
    {
        $this->resetAttachNewBillInputFields();
        $this->openAttachNewBillModal();
    }

    /**
     * The attributes that are mass assignable.
     */
    public function addPayment(): void
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
    public function openAttachNewBillModal(): void
    {
        $this->isOpenAttachNewBill = true;
    }

    /**
     * The attributes that are mass assignable.
     */
    public function closeModal(): void
    {
        $this->isOpen = false;
    }

    /**
     * The attributes that are mass assignable.
     */
    public function closeAttachNewBillModal(): void
    {
        $this->isOpenAttachNewBill = false;
    }

    /**
     * Store attach new bill
     */
    public function storeAttachNewBill(): void
    {
        $billPath = $this->currentHistoryBill;

        if ($this->historyBill !== null && $this->historyBill !== '') {
            $billPath = $this->historyBill->store('bills', 'public');
        }

        PullApartBillHistory::where('pull_apart_id', $this->pullApart->id)->update(['is_active' => 0]);

        PullApartBillHistory::updateOrCreate([
            'id' => $this->historyBillId
        ], [
            'pull_apart_id' => $this->pullApart->id,
            'bill' => $billPath,
            'user_id' => auth()->user()->id,
            'is_active' => 1,
            'comment' => $this->historyBillComment
        ]);

        $this->resetAttachNewBillInputFields();
        $this->closeAttachNewBillModal();
    }

    /**
     * Edit history bill
     *
     * @param $id
     */
    public function editAttachNewBill($id): void
    {
        $bill = PullApartBillHistory::findOrFail($id);

        $this->historyBillId = $bill->id;
        $this->currentHistoryBill = $bill->bill;
        $this->historyBillComment = $bill->comment;

        $this->openAttachNewBillModal();
    }

    /**
     * Edit pull apart history payment
     *
     * @param $id
     * @return void
     */
    public function editHistoryPayment($id): void
    {
        $history = PullApartFeePayment::findOrFail($id);

        $this->historyPaymentId = $history->id;
        $this->historyPaymentFeeId = $history->pull_part_fee_id;
        $this->historyPaymentAt = $history->payment_at;
        $this->historyPaymentDocumentNro = $history->document_nro;
        $this->historyPaymentAmount = $history->amount;
        $this->historyPaymentLate = $history->late_payment;
        $this->historyPaymentType = $history->type;
        $this->historyPaymentCurrency = $history->currency;
        $this->historyPaymentTicket = $history->ticket;
        $this->historyPaymentTicketNro = $history->ticket_nro;
        $this->historyPaymentCurrentVoucher = $history->voucher;
        $this->historyPaymentComment = $history->comment;

        $this->openModal();
    }

    /**
     * Clear the input fields.
     */
    public function resetInputFields(): void
    {
        $this->historyPaymentAt = '';
        $this->historyPaymentFeeId = '';
        $this->historyPaymentId = null;
        $this->historyPaymentDocumentNro = '';
        $this->historyPaymentAmount = '';
        $this->historyPaymentLate = '';
        $this->historyPaymentComment = '';
        $this->historyPaymentType = '';
        $this->historyPaymentCurrency = '';
        $this->historyPaymentType = '';
        $this->historyPaymentTicketNro = '';
        $this->historyPaymentCurrentVoucher = '';
        $this->historyPaymentVoucher = null;
    }

    /**
     * Clear the input fields.
     */
    public function resetAttachNewBillInputFields(): void
    {
        $this->historyBillComment = '';
        $this->historyBill = null;
        $this->currentHistoryBill = '';
        $this->historyBillId = null;
    }

    /**
     * Set pull apart document control.
     */
    public function setDocumentControl(): void
    {
        ray()->clearAll();

        if ($this->pullApart->documents->count() > 0) {
            $documentType = Document::where('id', $this->pullApart->documents->first()->document_id)->first()->type;

            $this->documentControl = $documentType;

            $this->populateDocumentControl();

            foreach ($this->pullApart->documents as $document) {
                $this->documentControlId[$document->document_id] = $document->id;
                $this->documentControlDate[$document->document_id] = $document->signed_at;
                $this->documentoControlObservation[$document->document_id] = $document->observation;
                $this->documentControlApprove[$document->document_id] = $document->approve;
            }
        }
    }

    /**
     * Set pull apart delivery.
     */
    public function setPullApartDelivery(): void
    {
        if ($this->pullApart->deliveries->count() > 0) {
            $delivery = $this->pullApart->deliveries->first();
            $this->deliveryApartmentDate = $delivery->delivery_at;
            $this->deliveryApartmentTime = $delivery->delivery_at_time;
            $this->executive = $delivery->executive;
            $this->currentEvidence = $delivery->evidence;
        }
    }

    /**
     * Set pull apart bill.
     *
     * @return void
     */
    public function setPullApartBill(): void
    {
        if ($this->pullApart->bills->count() > 0) {
            $bill = $this->pullApart->bills->first();
            $this->pullApartBillId = $bill->id;
            $this->proprietorship = $bill->proprietorship;
            $this->damages = $bill->damages;
            $this->damagesStr = $bill->damages_str;
            $this->unemployment = $bill->unemployment;
            $this->unemploymentStr = $bill->unemployment_str;
            $this->changes = $bill->changes;
            $this->sanitation = $bill->sanitation;
            $this->deliveryApartmentAt = $bill->delivery_apartment_at;
            $this->deliveryTerm = $bill->delivery_term;
            $this->deliveryTermAmount = $bill->delivery_term_amount;
            $this->deliveryTermAmountStr = $bill->delivery_term_amount_str;
            $this->additionalTerm = $bill->additional_term;
            $this->additionalTermAt = $bill->additional_term_at;
            $this->additionalTermPenalty = $bill->additional_term_penalty;
            $this->additionalTermPenaltyStr = $bill->additional_term_penalty_str;
            $this->batchNro = $bill->batch_nro;
            $this->montante = $bill->montante;
            $this->montanteStr = $bill->montante_str;
            $this->footer = $bill->footer;
        }
    }

    /**
     * Set quotation agreement.
     *
     * @return void
     */
    public function setQuotationAgreement(): void
    {
        if (!is_null($this->pullApart)) {
            $this->currentSignedSeparationAgreement = $this->pullApart->signed_separation_agreement;
            $this->currentSwornDeclaration = $this->pullApart->sworn_declaration;
        }
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
        $this->populateDocumentControl();

        if (!is_null($this->pullApart)) {
            $this->resetPaymentFees();
        }

        $this->historyPaymentFeeSelectList = $this->pullApart->fees()->where('pay', 0)->pluck('type', 'id');

        return view('livewire.sales.create');
    }

    /**
     * Fill document control.
     */
    public function populateDocumentControl(): void
    {
        if (!is_null($this->documentControl)) {
            $this->documentControlData = Document::where('type', $this->documentControl)->get();
        }
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
     * @noinspection DuplicatedCode
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
     * @noinspection DuplicatedCode
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
     * @noinspection DuplicatedCode
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
     * @noinspection DuplicatedCode
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
     * @noinspection DuplicatedCode
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
     * Store new payment.
     */
    public function storePayment(): void
    {
        $voucherPath = $this->historyPaymentCurrentVoucher;

        if ($this->historyPaymentVoucher !== null && $this->historyPaymentVoucher !== '') {
            $voucherPath = $this->historyPaymentVoucher->store('payment-history-vouchers', 'public');
        }

        PullApartFeePayment::updateOrCreate([
            'id' => $this->historyPaymentId
        ], [
            'pull_part_fee_id' => $this->historyPaymentFeeId,
            'amount' => $this->historyPaymentAmount,
            'currency' => $this->historyPaymentCurrency,
            'type' => $this->historyPaymentType,
            'document_nro' => $this->historyPaymentDocumentNro,
            'ticket' => $this->historyPaymentTicket,
            'ticket_nro' => $this->historyPaymentTicketNro,
            'voucher' => $voucherPath,
            'late_payment' => $this->historyPaymentLate === '' ? null : $this->historyPaymentLate,
            'comment' => $this->historyPaymentComment,
            'payment_at' => $this->historyPaymentAt
        ]);

        $this->closeModal();
        $this->resetInputFields();
    }

    /**
     * Store pull apart document control.
     *
     * @return void
     */
    public function storeDocumentControl(): void
    {
        foreach ($this->documentControlData as $item) {
            if (Arr::exists($this->documentControlDate, $item->id)) {
                PullApartDocument::updateOrCreate([
                    'id' => Arr::exists($this->documentControlId, $item->id) === false ? null : $this->documentControlId[$item->id]
                ],
                    [
                        'pull_apart_id' => $this->pullApart->id,
                        'document_id' => $item->id,
                        'signed_at' => $this->documentControlDate[$item->id],
                        'observation' => Arr::exists($this->documentoControlObservation, $item->id) === false ? null : $this->documentoControlObservation[$item->id],
                        'approve' => Arr::exists($this->documentControlApprove, $item->id)
                    ]);
            }
        }

        session()->flash('documentsControlValidation', !is_null($this->pullApart) ? __('Cambio actualizado con éxito!') : __('Cambio creado con éxito!'));
    }

    /**
     * Store pull apart changes
     *
     * @return void;
     */
    public function storeChanges(): void
    {
        $estimatePath = $this->currentEstimate;
        $blueprintPath = $this->currentBlueprint;

        if ($this->estimate !== null && $this->estimate !== '') {
            $estimatePath = $this->estimate->store('changes', 'public');
        }

        if ($this->blueprint !== null && $this->blueprint !== '') {
            $blueprintPath = $this->blueprint->store('change-blueprints', 'public');
        }

        PullApartChange::updateOrCreate([
            'id' => $this->pullApartChangeId
        ], [
            'pull_apart_id' => $this->pullApart->id,
            'estimate' => $estimatePath,
            'blueprint' => $blueprintPath,
            'amount' => $this->changeAmount,
            'estimate_days' => $this->estimateDays,
            'payment_at' => $this->changePaymentAt,
            'delivery_at' => $this->changeDeliveryAt
        ]);

        session()->flash('changesValidation', !is_null($this->pullApart) ? __('Cambio actualizado con éxito!') : __('Cambio creado con éxito!'));

        $this->estimate = null;
        $this->blueprint = null;
        $this->changeAmount = '';
        $this->estimateDays = '';
        $this->changePaymentAt = '';
        $this->changeDeliveryAt = '';

        $this->emit('refreshLivewireDatatable');
    }

    /**
     * Store pull apart delivery
     *
     * @return void
     */
    public function storeSaleDelivery(): void
    {
        $evidencePath = $this->currentEvidence;

        if ($this->evidence !== null && $this->evidence !== '') {
            $evidencePath = $this->evidence->store('delivery-evidence', 'public');
        }

        PullApartDelivery::updateOrCreate([
            'id' => $this->pullApartDeliveryId
        ], [
            'pull_apart_id' => $this->pullApart->id,
            'delivery_at' => $this->deliveryApartmentDate,
            'delivery_at_time' => $this->deliveryApartmentTime,
            'executive' => $this->executive,
            'evidence' => $evidencePath
        ]);

        session()->flash('saleDeliveryValidation', !is_null($this->pullApart) ? __('Entrega actualizada con éxito!') : __('Entrega creada con éxito!'));
    }

    /**
     * Store pull apart bill
     *
     * @return BinaryFileResponse
     */
    public function storeSaleBill(): BinaryFileResponse
    {
        PullApartBill::updateOrCreate([
            'id' => $this->pullApartBillId
        ], [
            'pull_apart_id' => $this->pullApart->id,
            'proprietorship' => $this->proprietorship,
            'damages' => $this->damages,
            'damages_str' => $this->damagesStr,
            'unemployment' => $this->unemployment,
            'unemployment_str' => $this->unemploymentStr,
            'changes' => $this->changes,
            'sanitation' => $this->sanitation,
            'delivery_apartment_at' => $this->deliveryApartmentAt,
            'delivery_term' => $this->deliveryTerm,
            'delivery_term_amount' => $this->deliveryTermAmount,
            'delivery_term_amount_str' => $this->deliveryTermAmountStr,
            'additional_term' => $this->additionalTerm,
            'additional_term_at' => $this->additionalTermAt,
            'additional_term_penalty' => $this->additionalTermPenalty,
            'additional_term_penalty_str' => $this->additionalTermPenaltyStr,
            'montante' => $this->montante,
            'montante_str' => $this->montanteStr,
            'batch_nro' => $this->batchNro,
            'footer' => $this->footer
        ]);

        $billName = "Minuta-{$this->pullApart->id}-" . now()->format('dmYHis') . '.docx';

        $this->generateBill($billName);

        PullApartBillHistory::create([
            'pull_apart_id' => $this->pullApart->id,
            'user_id' => auth()->user()->id,
            'bill' => "bills/$billName",
            'is_active' => true
        ]);

        session()->flash('billValidation', !is_null($this->pullApart) ? __('Minuta actualizada con éxito!') : __('Minuta creada con éxito!'));
        return response()->download(storage_path('app/public/bills/') . $billName);
    }

    /**
     * Generate pull apart bill.
     * @noinspection DuplicatedCode
     * @param $billName
     */
    public function generateBill($billName): void
    {
        $file = storage_path('app/public/bill-template/MinutaModelo_v2.docx');

        // Saving the document as OOXML file...
        try {
            // Creating the new document...
            $phpWord = new WordProcessor($file);

            $pullApart = PullApart::findOrFail($this->pullApart->id);

            $buyerInfo = '';

            ray()->clearAll();
            ray($pullApart->visit->customer()->get());

            switch ($pullApart->buyer_type) {
                case 'Soltero(a)':
                    $buyerInfo = $pullApart->visit->customer()->first()->full_name;
                    $buyerInfo .= ' con Documento Nacional de Identidad N°  ' . $pullApart->visit->customer()->first()->dni;
                    break;

                case 'Sociedad Conyugal':
                    $buyerInfo = '';
                    break;

                case 'Copropietario':
                    $buyerInfo = 'copropietario';
                    break;

                case 'Empresa':
                    $buyerInfo = 'empresa';
                    break;
            }

            $phpWord->setValue('DATOS_COMPRADOR', $buyerInfo);
            $phpWord->setValue('MONEDA_MINUTA', 'en ' . $pullApart->visit->project->bank->currency === 'PEN' ? 'MN' : 'ME');
            $phpWord->setValue('BCO_PROYECTO', $pullApart->visit->project->bank->description);
            $phpWord->setValue('BCO_FINANCIADOR', $pullApart->visit->project->bank->description);
            $phpWord->setValue('N_PARTIDA', $pullApart->bills->first()->batch_nro);
            $phpWord->setValue('NRO_CTA_PROYECTO', $pullApart->visit->project->currency === 'USD' ? $pullApart->visit->project->account_nro_me : $pullApart->visit->project->account_nro_mn);
            $phpWord->setValue('PROYECTO_MONEDA', $pullApart->visit->project->currency === 'USD' ? 'US$.' : 'S/.');

            if ($pullApart->payment_type === 'Directo') {
                $phpWord->deleteBlock('F_BANCARIO');
            }

            if (!$pullApart->bills->first()->proprietorship) {
                $phpWord->deleteBlock('RESERVA_PROPIEDAD');
            }

            $phpWord->setValue('P_DANOS_PERJUICIOS', $pullApart->bills->first()->damages);
            $phpWord->setValue('P_POR_DESOCUPACION', $pullApart->bills->first()->unemployment_str);

            if (!$pullApart->bills->first()->changes) {
                $phpWord->deleteBlock('CAMBIOS');
            }

            if (!$pullApart->bills->first()->delivery_term) {
                $phpWord->deleteBlock('PLAZO_DE_ENTREGA');
            } else {
                $phpWord->setValue('PENALIDAD', $pullApart->bills->first()->delivery_term_amount);
                $phpWord->setValue('PENALIDAD_STR', $pullApart->bills->first()->delivery_term_amount_str);
            }

            if (!$pullApart->bills->first()->additional_term) {
                $phpWord->deleteBlock('ADICIONAL');
            } else {
                $phpWord->setValue('NUEVA_FECHA_DE_ENTREGA', $pullApart->bills->first()->delivery_apartment_at);
                $phpWord->setValue('PENALIDAD_ADICIONAL', $pullApart->bills->first()->delivery_term_amount);
                $phpWord->setValue('PENALIDAD_ADICIONAL_STR', $pullApart->bills->first()->delivery_term_amount_str);
            }

            if (!$pullApart->bills->first()->sanitation) {
                $phpWord->deleteBlock('SANEAMIENTO');
            } else {
                $phpWord->setValue('M2_MONTANTES', $pullApart->bills->first()->montante);
                $phpWord->setValue('M2_MONTANTES_STR', $pullApart->bills->first()->montante_str);
            }

            if ($pullApart->payment_type !== 'Directo') {
                if ($pullApart->buyer_type === 'Soltero(a)') {
                    $phpWord->deleteBlock('AFP_DOS_PROPIETARIOS');

                    $phpWord->setValue('MONTO_AFP_1', $pullApart->fees->where('type', 'AFP')->first()->fee);
                    $phpWord->setValue('MONTO_AFP_1_STR', 'FALTA'); // TODO: change with afp amount in letters
                    $phpWord->setValue('DATOS_PROPIETARIO_1', $pullApart->visit->customer->full_name);
                    $phpWord->setValue('AFP_1', 'AFP Integra'); // TODO: change with name afp

                } else {
                    if ($pullApart->buyer_type === 'Sociedad Conyugal' || $pullApart->buyer_type === 'Copropietario') {
                        $phpWord->deleteBlock('AFP_UN_PROPIETARIO');
                    }
                }
            } else {
                $phpWord->deleteBlock('AFP_DOS_PROPIETARIOS');
                $phpWord->deleteBlock('AFP_UN_PROPIETARIO');
            }

            $phpWord->setValue('FECHA_MINUTA', now()->format('j') . ' de ' . now()->format('F') . ' del ' . now()->format('Y'));

            $phpWord->saveAs(storage_path("app/public/bills/$billName"));
        } catch (Exception $e) {
            ray($e);
        }
    }

    /**
     * Store signed quotation.
     *
     * @return void
     */
    public function storeQuotation(): void
    {
        $quotationPath = $this->currentSignedSeparationAgreement;
        $swornDeclarationPath = $this->currentSwornDeclaration;

        if ($this->signedSeparationAgreement !== null && $this->signedSeparationAgreement !== '') {
            $quotationPath = $this->signedSeparationAgreement->store('quotation-agreements', 'public');
        }

        if ($this->swornDeclaration !== null && $this->swornDeclaration !== '') {
            $swornDeclarationPath = $this->swornDeclaration->store('sworn-declarations', 'public');
        }

        PullApart::updateOrCreate([
            'id' => $this->pullApart === null ? null : $this->pullApart->id
        ], [
            'signed_separation_agreement' => $quotationPath,
            'sworn_declaration' => $swornDeclarationPath,
            'is_sale' => 1
        ]);

        session()->flash('quotationValidation', !is_null($this->pullApart) ? __('Convenio de separación actualizado con éxito!') : __('Convenio de separación creado con éxito!'));
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
     * @noinspection DuplicatedCode
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
     * @noinspection DuplicatedCode
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
     * @noinspection DuplicatedCode
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
            foreach ($this->fee as $value) {
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
     * @noinspection DuplicatedCode
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
     * @noinspection DuplicatedCode
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
     * @noinspection PhpExpressionAlwaysNullInspection
     */
    public function getFeeAtByType(string $type): mixed
    {
        if (is_null($this->pullApart)) {
            return null;
        }

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

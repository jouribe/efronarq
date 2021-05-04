<?php

namespace App\Http\Livewire\Banks;

use App\Models\Bank;
use Livewire\Component;
use Exception;

class Index extends Component
{
    /**
     * @var mixed $bankId
     */
    public $bankId;

    /**
     * @var mixed $name
     */
    public $name;

    /**
     * @var mixed $description
     */
    public $description;

    /**
     * @var mixed $contact_name
     */
    public $contact_name;

    /**
     * @var mixed $contact_phone
     */
    public $contact_phone;

    /**
     * @var mixed $contact_email
     */
    public $contact_email;

    /**
     * @var mixed $currencyList
     */
    public $currencyList;

    /**
     * @var mixed $currency
     */
    public $currency;

    /**
     * @var mixed $activeList
     */
    public $activeList;

    /**
     * @var mixed $is_active
     */
    public $is_active;

    /**
     * @var boolean $isOpen
     */
    public bool $isOpen = false;

    /**
     * @var mixed $listeners
     */
    protected $listeners = [
        'editBank' => 'edit',
        'deleteBank' => 'delete',
        'createBank' => 'create'
    ];

    public function render()
    {
        return view('livewire.banks.index');
    }

    /**
     * Mount component
     */
    public function mount(): void
    {
        $this->currencyList = [
            'PEN' => 'Soles',
            'USD' => 'Dólares'
        ];

        $this->activeList = [
            true => 'Si',
            false => 'No'
        ];
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
        $this->bankId = null;
        $this->name = '';
        $this->description = '';
        $this->contact_name = '';
        $this->contact_phone = '';
        $this->contact_email = '';
        $this->currency = '';
        $this->is_active = false;
    }

    /**
     * Store the project address.
     */
    public function store(): void
    {
        // Validation
        $this->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        // Save project address
        Bank::updateOrCreate([
            'id' => $this->bankId
        ],
            [
                'name' => $this->name,
                'description' => $this->description,
                'contact_name' => $this->contact_name,
                'contact_phone' => $this->contact_phone,
                'contact_email' => $this->contact_email,
                'currency' => $this->currency,
                'is_active' => $this->is_active
            ]);

        session()->flash('message', $this->bankId ? __('Bank updated successfully!') : __('Bank created successfully!'));

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
        $bank = Bank::findOrFail($id);
        $this->bankId = $bank->id;
        $this->name = $bank->name;
        $this->description = $bank->description;
        $this->contact_name = $bank->contact_name;
        $this->contact_phone = $bank->contact_phone;
        $this->contact_email = $bank->contact_email;
        $this->currency = $bank->currency;
        $this->is_active = $bank->is_active;

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
            Bank::findOrFail($id)->delete();

            session()->flash('message', __('Promotion deleted successfully'));

            $this->emit('refreshLivewireDatatable');
        } catch (Exception $e) {
            echo $e;
        }
    }
}

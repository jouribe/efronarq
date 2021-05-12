<?php

namespace App\Http\Livewire\Exchanges;

use App\Models\Exchange;
use Livewire\Component;
use Exception;

class Index extends Component
{
    /**
     * @var mixed $exchangeId
     */
    public $exchangeId;

    /**
     * @var mixed $buy
     */
    public $buy;

    /**
     * @var mixed $sale
     */
    public $sale;

    /**
     * @var boolean $isOpen
     */
    public bool $isOpen = false;

    /**
     * @var mixed $listeners
     */
    protected $listeners = [
        'editExchange' => 'edit',
        'createExchange' => 'create'
    ];

    public function render()
    {
        return view('livewire.exchanges.index');
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
        $this->exchangeId = null;
        $this->buy = '';
        $this->sale = '';
    }

    /**
     * Store the project address.
     */
    public function store(): void
    {
        // Validation
        $this->validate([
            'buy' => 'required',
            'sale' => 'required'
        ]);

        // Save project address
        Exchange::updateOrCreate([
            'id' => $this->exchangeId
        ],
            [
                'buy' => $this->buy,
                'sale' => $this->sale
            ]);

        session()->flash('message', $this->exchangeId ? __('Exchange updated successfully!') : __('Exchange created successfully!'));

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
        $exchange = Exchange::findOrFail($id);
        $this->exchangeId = $exchange->id;
        $this->buy = $exchange->buy;
        $this->sale = $exchange->sale;

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
            Exchange::findOrFail($id)->delete();

            session()->flash('message', __('Exchange deleted successfully'));

            $this->emit('refreshLivewireDatatable');
        } catch (Exception $e) {
            echo $e;
        }
    }
}

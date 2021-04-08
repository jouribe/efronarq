<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectSeller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Exception;

class Sellers extends Component
{
    /**
     * @var Project $project
     */
    public Project $project;

    /**
    * @var mixed $projectSellerId
    */
    public $projectSellerId;

    /**
    * @var mixed $userList
    */
    public $userList;

    /**
    * @var mixed $userId
    */
    public $userId;

    /**
    * @var mixed $profitPercentage
    */
    public $profitPercentage;

    /**
     * @var boolean $isOpen
     */
    public bool $isOpen = false;

    /**
     * @var mixed $listeners
     */
    protected $listeners = [
        'editSellers' => 'edit',
        'deleteSellers' => 'delete',
        'createSellers' => 'create'
    ];

    /**
     * Mount component.
     */
    public function mount(): void
    {
        $this->userList = User::role('vendedor')->pluck('name', 'id');
    }

    /**
     * Render view
     *
     * @return Factory|View|Application
     */
    public function render()
    {
        return view('livewire.projects.sellers');
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
        $this->projectSellerId = null;
        $this->userId = '';
        $this->profitPercentage = '';
    }

    /**
     * Store the project address.
     */
    public function store(): void
    {
        // Validation
        $this->validate([
            'userId' => 'required',
            'profitPercentage' => 'required'
        ]);

        // Save project address
        ProjectSeller::updateOrCreate([
            'id' => $this->projectSellerId
        ],
            [
                'project_id' => $this->project->id,
                'user_id' => $this->userId,
                'profit_percentage' => $this->profitPercentage
            ]);

        session()->flash('message', $this->projectSellerId ? __('Seller updated successfully') : __('Seller created successfully'));

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
        $seller = ProjectSeller::findOrFail($id);
        $this->projectSellerId = $seller->id;
        $this->userId = $seller->user_id;
        $this->profitPercentage = $seller->profit_percentage;

        $this->openModal();
    }

    /**
     * Delete project address.
     *
     * @param $id
     */
    public function delete($id) : void
    {
        try {
            ProjectSeller::findOrFail($id)->delete();

            session()->flash('message', __('Seller deleted successfully'));

            $this->emit('refreshLivewireDatatable');
        } catch (Exception $e) {
            echo $e;
        }
    }
}

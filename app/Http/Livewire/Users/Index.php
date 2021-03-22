<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Exception;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    /**
    * @var mixed $userId
    */
    public $userId;

    /**
    * @var mixed $name
    */
    public $name;

    /**
    * @var mixed $password
    */
    public $password;

    /**
    * @var mixed $password_confirmation
    */
    public $password_confirmation;

    /**
    * @var mixed $email
    */
    public $email;

    /**
    * @var mixed $role
    */
    public $role;

    /**
    * @var mixed $roleList
    */
    public $roleList;

    /**
     * @var boolean $isOpen
     */
    public bool $isOpen = false;

    /**
     * @var mixed $listeners
     */
    protected $listeners = [
        'editUser' => 'edit',
        'deleteUser' => 'delete',
        'createUser' => 'create'
    ];

    /**
     * Render component
     *
     * @return Factory|View|Application
     */
    public function render()
    {
        return view('livewire.users.index');
    }

    /**
     * Mount component
     */
    public function mount():void
    {
        $this->roleList = Role::all()->pluck('name', 'id');
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
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
    }

    /**
     * Store the project address.
     */
    public function store(): void
    {
        // Validation
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'role' => 'required'
        ]);

        // Save project address
        $user = User::updateOrCreate([
            'id' => $this->userId
        ],
            [
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password)
            ]);

        if(!is_null($this->userId) && $user->hasAnyRole()) {
            foreach ($user->roles()->get() as $role) {
                $user->removeRole($role->name);
            }
        }

        $user->assignRole($this->role);

        session()->flash('message', $this->userId ? __('User updated successfully!') : __('User created successfully!'));

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
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles()->first()->id;

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
            User::findOrFail($id)->delete();

            session()->flash('message', __('User deleted successfully'));

            $this->emit('refreshLivewireDatatable');
        } catch (Exception $e) {
            echo $e;
        }
    }
}

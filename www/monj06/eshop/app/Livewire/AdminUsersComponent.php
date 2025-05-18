<?php

namespace App\Livewire;

use Livewire\Component;

class AdminUsersComponent extends Component
{
    public $users;
    public function render()
    {
        return view('livewire.admin-users-component');
    }
}

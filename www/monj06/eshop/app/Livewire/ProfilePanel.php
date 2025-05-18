<?php

namespace App\Livewire;

use Livewire\Component;

class ProfilePanel extends Component
{
    public $product;

    public function render()
    {
        return view('livewire.profile-panel');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;

class DeliveryDetailsComponent extends Component
{
    public $cart;
    public function render()
    {
        return view('livewire.delivery-details-component');
    }
}

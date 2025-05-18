<?php

namespace App\Livewire;

use Livewire\Component;

class DeliveryPaymentComponent extends Component
{
    public $cart;
    public function render()
    {
        return view('livewire.delivery-payment-component');
    }
}

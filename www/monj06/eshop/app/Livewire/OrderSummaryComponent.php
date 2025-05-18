<?php

namespace App\Livewire;

use Livewire\Component;

class OrderSummaryComponent extends Component
{
    public $cart;
    public function render()
    {
        return view('livewire.order-summary-component');
    }
}

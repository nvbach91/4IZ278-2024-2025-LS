<?php

namespace App\Livewire;

use Livewire\Component;

class CartComponent extends Component
{
    public $cart;
    public function render()
    {
        return view('livewire.cart-component');
    }
}

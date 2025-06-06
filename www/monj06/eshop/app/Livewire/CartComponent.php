<?php

namespace App\Livewire;

use Livewire\Component;

class CartComponent extends Component
{
    public $cart;

    public $subtotal;

    public $total;

    public function mount()
    {
        foreach ($this->cart as $item) {
            $this->subtotal += (int) $item['price'] * $item['quantity'];
        }

        foreach ($this->cart as $item) {
            $this->total += (int) $item['price'] * $item['quantity'] + 0;
        }
    }
    public function render()
    {
        return view('livewire.cart-component');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;

class ProductDetailInfo extends Component
{
    public $cart;
    public function render()
    {
        return view('livewire.product-detail-info');
    }
}

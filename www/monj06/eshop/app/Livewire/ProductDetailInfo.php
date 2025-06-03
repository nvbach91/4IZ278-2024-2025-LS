<?php

namespace App\Livewire;

use Livewire\Component;

class ProductDetailInfo extends Component
{
    public $product;
    public function render()
    {
        return view('livewire.product-detail-info');
    }
}

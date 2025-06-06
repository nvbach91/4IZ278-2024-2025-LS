<?php

namespace App\Livewire;

use Livewire\Component;

class AdminProductComponent extends Component
{
    public $product;
    public function render()
    {
        return view('livewire.admin-product-component');
    }
}

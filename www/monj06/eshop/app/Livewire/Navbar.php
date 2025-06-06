<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class Navbar extends Component
{
    public $categories;
    public $search = '';

    public function render()
    {
        $products = Product::where('name', 'like', '%' . $this->search . '%')->get();
        return view('livewire.navbar', [
            'products' => $products,
        ]);
    }
}

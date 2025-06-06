<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductSearch extends Component
{
    public $search;

    protected $queryString = ['search'];

    public function render()
    {
        $products = Product::where('name', 'like', '%' . $this->search . '%')->get();

        return view('livewire.product-search', [
            'products' => $products,
        ]);
    }
}

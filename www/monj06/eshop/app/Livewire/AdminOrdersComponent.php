<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class AdminOrdersComponent extends Component
{
    public $orders;
    public $items;
    public $products;
    public $activeOrderId = null;

    public function render()
    {
        return view('livewire.admin-orders-component');
    }
    public function download($orderId)
    {
        $this->items = DB::table('order_items')->where('order_id', $orderId)->get();

        $productIds = $this->items->pluck('product_id');

        $this->products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $this->activeOrderId = $this->activeOrderId === $orderId ? null : $orderId;
    }
}

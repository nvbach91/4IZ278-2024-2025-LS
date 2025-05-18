<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AdminOrdersComponent extends Component
{
    public $orders;
    public $items;
    public function render()
    {
        return view('livewire.admin-orders-component');
    }
    public function download($id)
    {
        $this->items = DB::table('order_items')->where('order_id', $id)->get();
    }
}

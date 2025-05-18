<?php

namespace App\Livewire;

use Livewire\Component;

class Navbar extends Component
{
    public $categories;
    public function render()
    {
        return view('livewire.navbar');
    }
}

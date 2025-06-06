<?php

namespace App\Livewire;

use Livewire\Component;

class Footer extends Component
{
    public $categories;

    public function render()
    {
        return view('livewire.footer');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;

class AdminCategoriesComponent extends Component
{
    public $categories;
    public function render()
    {
        return view('livewire.admin-categories-component');
    }
}

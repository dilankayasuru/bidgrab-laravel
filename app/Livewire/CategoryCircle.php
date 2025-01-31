<?php

namespace App\Livewire;

use Livewire\Component;

class CategoryCircle extends Component
{
    public $category;
    
    public function render()
    {
        return view('livewire.category-circle');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;

class OrderView extends Component
{
    public $order;
    
    public function render()
    {
        return view('livewire.order-view');
    }
}

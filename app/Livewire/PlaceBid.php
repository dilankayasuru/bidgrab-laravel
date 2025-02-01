<?php

namespace App\Livewire;

use Livewire\Component;

class PlaceBid extends Component
{
    public $auction;
    public $amount;

    protected $rules = [
        'amount' => 'required|numeric|min:150',
    ];

    public function updatedAmount($value)
    {
        $this->validate([
            'amount' => 'required|numeric|min:' . ($this->auction->current_price + 1),
        ]);
    }

    public function render()
    {
        return view('livewire.place-bid');
    }
}

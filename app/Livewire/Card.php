<?php

namespace App\Livewire;

use Livewire\Component;

class Card extends Component
{
    public $auction;

    public function render()
    {
        return view('livewire.card');
    }

    public function navigate()
    {
        return redirect()->route('auction.show', ['auction' => $this->auction]);
    }
}

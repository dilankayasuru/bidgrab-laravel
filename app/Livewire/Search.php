<?php

namespace App\Livewire;

use App\Models\Auction;
use Livewire\Component;

class Search extends Component
{
    public $keyword = "";

    public $results = [];

    public function updatedKeyword()
    {
        if (strlen($this->keyword) > 0) {
            $this->results = Auction::where('title', 'like', "%$this->keyword%")
                ->where('status', 'live')
                ->get();
        } else {
            $this->results = [];
        }
    }

    public function render()
    {
        return view('livewire.search');
    }
}

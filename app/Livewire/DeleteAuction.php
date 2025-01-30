<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DeleteAuction extends Component
{
    public $show;
    public $auction;

    public $auctionId;

    #[Validate('required|same:auctionId')]
    public $confirmAuctionId;

    public function mount()
    {
        $this->auctionId = $this->auction->id;
    }

    public function render()
    {
        return view('livewire.delete-auction');
    }

    public function delete()
    {
        $this->validate();

        foreach ($this->auction->images as $image) {
            Storage::disk('public')->delete($image);
        }

        $this->auction->delete();
        return redirect()->route('dashboard.auctions');
    }
}

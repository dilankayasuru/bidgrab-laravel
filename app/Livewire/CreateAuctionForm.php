<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class CreateAuctionForm extends Component
{
    use WithFileUploads;

    #[Validate(['images.*' => 'image|max:1024'])]
    public $images = [];
    public $title = "";
    public $description = "";
    public $category = "";
    public $condition = "";
    public $duration = "";
    public $startingDate = "";
    public $startingPrice = "";

    public function save()
    {
        $validated = $this->validate([
            'images.*' => 'image|max:1024'
        ]);

        foreach ($this->images as $image) {
            $image->store('auctions', 'public');
        }
    }
}

<?php

namespace App\Livewire;

use App\Models\Auction;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Carbon\Carbon;

class CreateAuctionForm extends Component
{
    use WithFileUploads;

    #[Validate(['images.*' => 'image|max:1024'])]
    #[Validate('required|array|min:1|max:5')]
    public $images = [];

    #[Validate('required|min:5')]
    public $title;

    #[Validate('required|min:5')]
    public $description;

    #[Validate('required')]
    public $condition;

    #[Validate('required')]
    public $duration;

    #[Validate('required|date|after_or_equal:today')]
    public $startingDate;

    #[Validate('required|numeric|min:150')]
    public $startingPrice;

    #[Validate('required')]
    public $categoryId;

    public $categories;

    public function mount()
    {
        $this->categories = Category::all()->pluck('name', '_id');
    }

    public function unsetImage($imageId)
    {
        unset($this->images[$imageId]);
        $this->images = array_values($this->images);
    }

    public function save()
    {
        $this->validate();

        $uploads = [];
        foreach ($this->images as $image) {
            $path = $image->store('auctions', 'public');
            $uploads[] = $path;
        }

        $auction = Auction::create([
            'title' => $this->title,
            'description' => $this->description,
            'images' => $uploads,
            'category_id' => $this->categoryId,
            'condition' => $this->condition,
            'duration' => $this->duration,
            'starting_date' => Carbon::parse($this->startingDate),
            'starting_price' => (float)$this->startingPrice,
            'current_price' => (float)$this->startingPrice,
            'bids' => 0,
        ]);

        auth()->user()->auctions()->save($auction);

        return redirect()->route('dashboard');
    }
}

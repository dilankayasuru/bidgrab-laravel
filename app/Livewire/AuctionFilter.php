<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Auction;
use Livewire\Component;

class AuctionFilter extends Component
{
    public $categories;
    public $minPrice;
    public $maxPrice;
    public $condition;
    public $selectedCategory;
    public $sort;

    public $result;

    public function mount()
    {
        $this->categories = Category::all()->pluck('name', '_id');
        $this->minPrice = request()->input('min');
        $this->maxPrice = request()->input('max');
        $this->condition = request()->input('condition');
        $this->selectedCategory = request()->input('category');
        $this->sort = request()->input('sort');
    }

    public function render()
    {
        return view('livewire.auction-filter');
    }

    public function apply()
    {
        return redirect()->route('marketplace', [
            'min' => $this->minPrice,
            'max' => $this->maxPrice,
            'condition' => $this->condition,
            'category' => $this->selectedCategory,
            'sort' => $this->sort
        ]);
    }
}

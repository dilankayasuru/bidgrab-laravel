<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ImagePreview extends Component
{
    public $images;

    public function mount($images)
    {
        $imageUrls = [];
        foreach ($images as $image) {
            $imageUrls[] = asset(Storage::url($image));
        }
        $this->images = $imageUrls;
    }

    public function render()
    {
        return view('livewire.image-preview');
    }
}

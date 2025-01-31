<div>
    <div wire:click="navigate()" class="cursor-pointer">
        <div class="relative">
            <p class="absolute top-0 right-0 p-2 shadow-md rounded-bl-xl rounded-tr-xl text-sm bg-white ">
                {{ $auction->bids }}
                <span>{{ $auction->bids === 1 ? 'Bid' : 'Bids' }}</span>
            </p>
            <img src="{{ Storage::url($auction->images[0]) }}" alt=""
                class="aspect-video md:aspect-square object-cover rounded-xl shadow-md">
        </div>

        <div class="py-4 px-2">
            <p class="font-medium text-lg mb-1">Rs. {{ number_format($auction->current_price, 2, '.') }}</p>
            <p>
                {{ substr($auction->title, 0, length: 35) }}{{ strlen($auction->title) > 35 ? '...' : '' }}
            </p>
        </div>
    </div>

    <button
        class="hover:shadow-lg active:shadow-md active:translate-y-0.5 w-full py-2 rounded-full bg-blue text-white font-medium transition-all duration-300 hover:bg-opacity-90">
        Place bid
    </button>
</div>

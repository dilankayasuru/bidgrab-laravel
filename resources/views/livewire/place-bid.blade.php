<div x-show="show"
    class="grid place-items-center fixed top-0 left-0 z-50 h-screen w-screen backdrop-blur bg-black bg-opacity-25">
    <form method="POST" action="{{ route('place.bid', ['auction' => $auction, 'amount' => (float) $amount]) }}"
        class="p-4 rounded-3xl bg-white shadow-md max-w-lg">
        @csrf
        <div class="flex items-center justify-between mb-4">
            <p class="text-xl font-medium">Place bid</p>
            <button @click="show = false" type="reset">
                <img src="{{ asset('icons/close_black.svg') }}" alt="">
            </button>
        </div>
        <div class="mb-4 pb-4 border-b border-zinc-500">
            <div class="mb-2 flex gap-4 items-center">
                <img src="{{ asset(Storage::url($auction->images[0])) }}" alt=""
                    class="w-16 aspect-square rounded-lg shadow-md object-contain">
                <p>
                    {{ substr($auction->title, 0, length: 35) }}{{ strlen($auction->title) > 35 ? '...' : '' }}
                </p>
            </div>
            <span>Current Bid: </span>
            <span class="font-medium text-lg mb-1">Rs. {{ number_format($auction->current_price, 2, '.') }}</span>
        </div>
        <p class="mb-2">Enter your bid</p>
        <div class="flex gap-2 items-center mb-2">
            <span class="text-zinc-500">LKR</span>
            <input required wire:model.live="amount" type="number" step="0.01"
                min="{{ $auction->current_price + 1 }}" placeholder="Enter bid amount" class="rounded-full w-full">
            <button type="submit"
                class="hover:shadow-lg active:shadow-md active:translate-y-0.5 w-32 py-2 px-8 rounded-full bg-blue text-white font-medium transition-all duration-300 hover:bg-opacity-90 block text-center">Bid</button>
        </div>
        @error('amount')
            <p class="text-sm text-red-500">{{ $message }}</p>
        @enderror
        <p class="text-sm">By placing a bid, you agree to complete the purchase if you win the auction.</p>
    </form>
</div>

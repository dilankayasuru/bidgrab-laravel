<div class="grid grid-cols-6 place-items-center py-2 border-b border-zinc-300">
    <img src="{{ Storage::url($auction->images[0]) }}" alt=""
        class="w-12 h-12 aspect-square object-cover rounded border border-zinc-300">
    <p class="justify-self-start">{{ $auction->title }}</p>
    <p>{{ $auction->status ?? 'pending' }}</p>
    <p>{{ $auction->bids ?? 12 }}</p>
    <p>{{ $auction->currentPrice ?? 1500 }}</p>
    <div class="flex items-center gap-2 justify-evenly">
        <button>
            <img src="{{ asset('icons/view.svg') }}" alt="view">
        </button>
        <button>
            <img src="{{ asset('icons/edit.svg') }}" alt="edit">
        </button>
        <button>
            <img src="{{ asset('icons/delete.svg') }}" alt="delete">
        </button>
    </div>
</div>

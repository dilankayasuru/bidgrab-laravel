<div class="grid md:grid-cols-6 md:place-items-center py-2 border-b border-zinc-300">

    <img src="{{ Storage::url($auction->images[0]) }}" alt=""
        class="w-12 h-12 aspect-square object-cover rounded border border-zinc-300">

    <p class="justify-self-start">
        {{ substr($auction->title, 0, length: 50) }}{{ strlen($auction->title) > 50 ? '...' : '' }}
    </p>

    <p class="capitalize">{{ $auction->status }}</p>

    <p>{{ $auction->bid_count }} Bids</p>

    <p>Rs. {{ number_format($auction->current_price, 2, '.') }}</p>

    <div class="flex items-center gap-2 justify-evenly">
        @php
            $status = $auction->status;
            $view = $status !== 'ended';
            $edit = $status === 'pending';
            $delete = ($status === 'ended' && $auction->highest_bid === null) || $status === 'pending';
            $relist = $status === 'ended' && $auction->highest_bid === null;
        @endphp

        @if ($view)
            <a href="{{ route('dashboard.preview', ['auction' => $auction]) }}">
                <img src="{{ asset('icons/view.svg') }}" alt="view">
            </a>
        @endif

        @if ($edit)
            <a href="{{ route('dashboard.edit', ['auctionId' => $auction->id]) }}">
                <img src="{{ asset('icons/edit.svg') }}" alt="edit">
            </a>
        @endif

        @if ($relist)
            <a href="{{ route('dashboard.edit', ['auctionId' => $auction->id]) }}" class="flex items-center gap-1">
                <img src="{{ asset('icons/renew.svg') }}" alt="relist">Relist
            </a>
        @endif

        @if ($delete)
            @livewire('delete-auction', ['auction' => $auction])
        @endif

    </div>
</div>

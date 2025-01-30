<div class="grid grid-cols-6 place-items-center py-2 border-b border-zinc-300">

    <img src="{{ Storage::url($auction->images[0]) }}" alt=""
        class="w-12 h-12 aspect-square object-cover rounded border border-zinc-300">

    <p class="justify-self-start">{{ $auction->title }}</p>

    <p class="capitalize">{{ $auction->status }}</p>

    <p>{{ $auction->bids }}</p>

    <p>{{ $auction->current_price }}</p>

    <div class="flex items-center gap-2 justify-evenly">
        @php
            $status = $auction->status;
            $view = $status !== 'ended';
            $edit = $status === 'pending';
            $delete = ($status === 'ended' && $auction->winner_id === null) || $status === 'pending';
            $relist = $status === 'ended' && $auction->winner_id === null;
            $ship = $status === 'ended' && $auction->winner_id !== null;
        @endphp

        <button x-show="{{ $view ? 'true' : 'false' }}">
            <img src="{{ asset('icons/view.svg') }}" alt="view">
        </button>

        <a href="{{ route('dashboard.edit', ['auctionId' => $auction->id]) }}" x-show="{{ $edit ? 'true' : 'false' }}">
            <img src="{{ asset('icons/edit.svg') }}" alt="edit">
        </a>

        <button x-show="{{ $relist ? 'true' : 'false' }}" class="flex items-center gap-1">
            <img src="{{ asset('icons/renew.svg') }}" alt="relist">Relist
        </button>

        <button x-show="{{ $ship ? 'true' : 'false' }}" class="flex items-center gap-1">
            <img src="{{ asset('icons/shipping.svg') }}" alt="relist">Ship
        </button>

        @livewire('delete-auction', ['show' => $delete ? 'true' : 'false', 'auction' => $auction])

    </div>
</div>

@extends('layouts.dashboard')

@section('content')
    <div class="p-4">
        <div class="mb-4">
            <h1 class="text-2xl font-medium">Auctions</h1>
            <p class="text-zinc-500">Total Auctions: {{ count($auctions) ?? 0 }}</p>
        </div>
        <div class="mb-4 flex md:gap-2 md:flex-wrap text-sm gap-1">
            @php
                $status = request()->input('status');
            @endphp
            <a href="{{ route('dashboard.auctions', ['status' => 'all']) }}"
                class="rounded-xl border border-zinc-300 px-4 py-1 duration-300 transition-all hover:shadow-md active:shadow active:translate-y-0.5 {{ $status == 'all' ? 'bg-blue text-white hover:bg-opacity-90' : 'bg-zinc-50 hover:bg-zinc-100' }}">All</a>
            <a href="{{ route('dashboard.auctions', ['status' => 'pending']) }}"
                class="rounded-xl border border-zinc-300 px-4 py-1 duration-300 transition-all hover:shadow-md active:shadow active:translate-y-0.5 {{ $status == 'pending' ? 'bg-blue text-white hover:bg-opacity-90' : 'bg-zinc-50 hover:bg-zinc-100' }}">Pending</a>
            <a href="{{ route('dashboard.auctions', ['status' => 'live']) }}"
                class="rounded-xl border border-zinc-300 px-4 py-1 duration-300 transition-all hover:shadow-md active:shadow active:translate-y-0.5 {{ $status == 'live' ? 'bg-blue text-white hover:bg-opacity-90' : 'bg-zinc-50 hover:bg-zinc-100' }}">Live</a>
            <a href="{{ route('dashboard.auctions', ['status' => 'unsold']) }}"
                class="rounded-xl border border-zinc-300 px-4 py-1 duration-300 transition-all hover:shadow-md active:shadow active:translate-y-0.5 {{ $status == 'unsold' ? 'bg-blue text-white hover:bg-opacity-90' : 'bg-zinc-50 hover:bg-zinc-100' }}">Unsold</a>
        </div>
        <div class="grid-cols-6 place-items-center py-2 bg-blue bg-opacity-15 hidden md:grid">
            <p>Image</p>
            <p>Title</p>
            <p>Status</p>
            <p>Bids</p>
            <p>Current price</p>
            <p>Actions</p>
        </div>
        @if ($auctions && count($auctions) > 0)
            @foreach ($auctions as $auction)
                <x-dashboard.auction :auction="$auction" />
            @endforeach
        @else
            <div class="grid place-items-center">
                <creattie-embed src="https://d1jj76g3lut4fe.cloudfront.net/saved_colors/109057/CUx4xD6KZF8Txrfb.json"
                    delay="1" speed="100" frame_rate="24" trigger="loop" class="w-full max-w-80">
                </creattie-embed>
                <p class="text-zinc-500">No item found in {{ $status }} auctions!</p>
            </div>
        @endif
        <div class="mt-4">
            {{ $auctions->links() }}
        </div>
    </div>
@endsection

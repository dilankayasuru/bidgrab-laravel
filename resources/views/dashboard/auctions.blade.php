@extends('layouts.dashboard')

@section('content')
    <div class="p-4">
        <div class="mb-4">
            <h1 class="text-2xl font-medium">Auctions</h1>
            <p class="text-zinc-500">Total Auctions: {{ count($auctions) ?? 0 }}</p>
        </div>
        <div class="mb-4 flex gap-2">
            <a href="{{ route('dashboard.auctions', ['status' => 'all']) }}"
                class="duration-300 transition-all hover:shadow-md active:shadow active:translate-y-0.5 rounded-xl border border-zinc-300 bg-blue text-white px-4 py-1">All</a>
            <a href="{{ route('dashboard.auctions', ['status' => 'pending']) }}"
                class="rounded-xl border border-zinc-300 bg-zinc-50 px-4 py-1 duration-300 transition-all hover:shadow-md active:shadow active:translate-y-0.5 hover:bg-zinc-100">Pending</a>
            <a href="{{ route('dashboard.auctions', ['status' => 'live']) }}"
                class="rounded-xl border border-zinc-300 bg-zinc-50 px-4 py-1 duration-300 transition-all hover:shadow-md active:shadow active:translate-y-0.5 hover:bg-zinc-100">Live</a>
            <a href="{{ route('dashboard.auctions', ['status' => 'sold']) }}"
                class="rounded-xl border border-zinc-300 bg-zinc-50 px-4 py-1 duration-300 transition-all hover:shadow-md active:shadow active:translate-y-0.5 hover:bg-zinc-100">Sold</a>
            <a href="{{ route('dashboard.auctions', ['status' => 'unsold']) }}"
                class="rounded-xl border border-zinc-300 bg-zinc-50 px-4 py-1 duration-300 transition-all hover:shadow-md active:shadow active:translate-y-0.5 hover:bg-zinc-100">Unsold</a>
        </div>
        @if ($auctions)
            <div class="grid grid-cols-6 place-items-center py-2 bg-blue bg-opacity-15">
                <p>Image</p>
                <p>Title</p>
                <p>Status</p>
                <p>Bids</p>
                <p>Current price</p>
                <p>Actions</p>
            </div>
            @foreach ($auctions as $auction)
                <x-dashboard.auction :auction="$auction" />
            @endforeach
        @endif
    </div>
@endsection
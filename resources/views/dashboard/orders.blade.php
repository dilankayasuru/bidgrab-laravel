@extends('layouts.dashboard')

@section('content')
    <div class="p-4">
        <div class="mb-4">
            <h1 class="text-2xl font-medium">Orders</h1>
            <p class="text-zinc-500">Total Orders: {{ count($orders) ?? 0 }}</p>
        </div>
        <div class="mb-4 flex gap-2 flex-wrap">
            @php
                $status = request()->input('status');
            @endphp
            <a href="{{ route('dashboard.orders', ['status' => 'all']) }}"
                class="rounded-xl border border-zinc-300 px-4 py-1 duration-300 transition-all hover:shadow-md active:shadow active:translate-y-0.5 {{ $status == 'all' ? 'bg-blue text-white hover:bg-opacity-90' : 'bg-zinc-50 hover:bg-zinc-100' }}">All</a>
            <a href="{{ route('dashboard.orders', ['status' => 'pending']) }}"
                class="rounded-xl border border-zinc-300 px-4 py-1 duration-300 transition-all hover:shadow-md active:shadow active:translate-y-0.5 {{ $status == 'pending' ? 'bg-blue text-white hover:bg-opacity-90' : 'bg-zinc-50 hover:bg-zinc-100' }}">Pending</a>
            <a href="{{ route('dashboard.orders', ['status' => 'payed']) }}"
                class="rounded-xl border border-zinc-300 px-4 py-1 duration-300 transition-all hover:shadow-md active:shadow active:translate-y-0.5 {{ $status == 'payed' ? 'bg-blue text-white hover:bg-opacity-90' : 'bg-zinc-50 hover:bg-zinc-100' }}">Payed</a>
            <a href="{{ route('dashboard.orders', ['status' => 'delivered']) }}"
                class="rounded-xl border border-zinc-300 px-4 py-1 duration-300 transition-all hover:shadow-md active:shadow active:translate-y-0.5 {{ $status == 'delivered' ? 'bg-blue text-white hover:bg-opacity-90' : 'bg-zinc-50 hover:bg-zinc-100' }}">Delivered</a>
        </div>
        <div class="grid grid-cols-6 place-items-center py-2 bg-blue bg-opacity-15">
            <p>Image</p>
            <p>Title</p>
            <p>Status</p>
            <p>Buyer</p>
            <p>Price</p>
            <p>Actions</p>
        </div>
        @if ($orders && count($orders) > 0)
            @foreach ($orders as $order)
                <x-dashboard.order :order="$order" />
            @endforeach
        @else
            <div class="grid place-items-center">
                <creattie-embed src="https://d1jj76g3lut4fe.cloudfront.net/saved_colors/109057/CUx4xD6KZF8Txrfb.json"
                    delay="1" speed="100" frame_rate="24" trigger="loop" class="w-full max-w-80">
                </creattie-embed>
                <p class="text-zinc-500">No item found in {{ $status }} orders!</p>
            </div>
        @endif
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
@endsection

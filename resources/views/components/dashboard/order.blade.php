<div class="grid md:grid-cols-6 md:place-items-center py-2 border-b border-zinc-300">
    @php
        $auction = $order->auction;
    @endphp

    <img src="{{ Storage::url($auction->images[0]) }}" alt=""
        class="w-12 h-12 aspect-square object-cover rounded border border-zinc-300">

    <p class="justify-self-start">
        {{ substr($auction->title, 0, length: 50) }}{{ strlen($auction->title) > 50 ? '...' : '' }}
    </p>

    <p class="capitalize">{{ $order->status }}</p>

    <p>{{ $order->user->name }}</p>

    <p>{{ $auction->current_price }}</p>

    <div class="grid place-items-center">

        @livewire('order-view', ['order' => $order])

    </div>
</div>
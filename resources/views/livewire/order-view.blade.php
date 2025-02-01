<div x-data="{ show: false }">
    <button @click="show = true" class="flex items-center gap-1">
        <img src="{{ asset('icons/view.svg') }}" alt="view">View
    </button>

    <div x-show="show" class="h-screen w-screen fixed top-0 left-0 z-50 backdrop-blur-sm bg-black bg-opacity-20">
        <div
            class="bg-white p-4 shadow-sm border-zinc-200 border rounded-md z-50 fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
            <div class="flex items-center justify-between mb-4 gap-2">
                <h1 class="font-medium text-lg">View order</h1>
                <button @click="show = false">
                    <img src="{{ asset('icons/close_black.svg') }}" alt="">
                </button>
            </div>
            <div class="flex gap-4 mb-4">
                <img src="{{ Storage::url($order->auction->images[0]) }}" alt=""
                    class="w-16 aspect-square object-cover rounded-lg shadow-md">
                <div>
                    <p>
                        {{ substr($order->auction->title, 0, length: 35) }}{{ strlen($order->auction->title) > 35 ? '...' : '' }}
                    </p>
                    <p class="text-sm text-zinc-500">{{ $order->auction->category->name }}</p>
                </div>

            </div>
            <div class="md:min-w-80 mb-4">
                <div class="flex justify-between items-center border-b border-zinc-500 pb-2 mb-2"><span
                        class="text-zinc-500"><span>Order ID:</span>
                    </span>{{ $order->id }}</div>
                <div class="flex justify-between items-center border-b border-zinc-500 pb-2 mb-2"><span
                        class="text-zinc-500"><span>Buyer:</span>
                    </span>{{ $order->user->name }}</div>
                <div class="flex justify-between items-center border-b border-zinc-500 pb-2 mb-2"><span
                        class="text-zinc-500"><span>Amount:</span>
                    </span>Rs. {{ number_format($order->auction->highestBid->amount, 2, '.') }}</div>
                <div class="flex justify-between items-center border-b border-zinc-500 pb-2 mb-2"><span
                        class="text-zinc-500"><span>Auction ID:</span>
                    </span>{{ $order->auction->id }}</div>
                <div class="flex justify-between items-center border-b border-zinc-500 pb-2 mb-2"><span
                        class="text-zinc-500"><span>Address:</span>
                    </span>{{ $order->address }}</div>
                <div class="flex justify-between items-center border-b border-zinc-500 pb-2 mb-2"><span
                        class="text-zinc-500"><span>Status:</span>
                    </span>{{ $order->status }}</div>
            </div>
            @if ($order->status == 'pending')
                <form method="post" action="{{ route('dashboard.order.delete', ['order' => $order]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-2 rounded-lg text-red-500 border border-red-500 mb-1">
                        Cancel order
                    </button>
                    <p class="text-sm text-zinc-500">This action is irreversible!</p>
                </form>
            @endif

            @if ($order->status == 'payed')
                <form method="post" action="{{ route('dashboard.order.deliver', ['order' => $order]) }}">
                    @csrf
                    <button type="submit"
                        class="hover:bg-opacity-90 active:translate-y-0.5 duration-300 transition-all shadow-lg active:shadow-md w-full py-2 rounded-lg text-white bg-blue">
                        Deliver order
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

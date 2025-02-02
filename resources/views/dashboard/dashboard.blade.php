@extends('layouts.dashboard')

@section('content')
    <div class="p-4 bg-blue bg-opacity-5 h-full">
        <div class="mb-4">
            <h1 class="text-2xl font-medium">Overview</h1>
            <p class="text-zinc-500 text-sm">Key Insights at a Glance</p>
        </div>
        <div class="grid grid-cols-4 place-items-center gap-8 mb-8">
            <div class="bg-white rounded-2xl shadow-md p-8 flex gap-4 w-full">
                <div class="grid place-items-center p-2 w-fit h-fit rounded-lg bg-blue bg-opacity-5">
                    <img src="{{ asset('icons/wallet.svg') }}" alt="">
                </div>
                <div>
                    <p class="text-zinc-500">Total sales</p>
                    <p class="font-medium text-xl">LKR {{ number_format($totalSales, 2) }}</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-8 flex gap-4 w-full">
                <div class="grid place-items-center p-2 w-fit h-fit rounded-lg bg-blue bg-opacity-5">
                    <img src="{{ asset('icons/shopping_bag_blue.svg') }}" alt="">
                </div>
                <div>
                    <p class="text-zinc-500">Total orders</p>
                    <p class="font-medium text-xl">{{ $totalOrders }}</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-8 flex gap-4 w-full">
                <div class="grid place-items-center p-2 w-fit h-fit rounded-lg bg-blue bg-opacity-5">
                    <img src="{{ asset('icons/category.svg') }}" alt="">
                </div>
                <div>
                    <p class="text-zinc-500">Total auctions</p>
                    <p class="font-medium text-xl">{{ $totalAuctions }}</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-md p-8 flex gap-4 w-full">
                <div class="grid place-items-center p-2 w-fit h-fit rounded-lg bg-blue bg-opacity-5">
                    <img src="{{ asset('icons/person.svg') }}" alt="">
                </div>
                <div>
                    <p class="text-zinc-500">Total users</p>
                    <p class="font-medium text-xl">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="flex justify-between gap-8 w-full">
            <div class="w-full">
                <p class="mb-4">Sales Insights</p>
                <canvas id="lineChart"></canvas>
            </div>
            <div class="w-full">
                <p class="mb-4">Top live auctions</p>
                @foreach ($topAuctions as $auction)
                    <div class="flex gap-4 w-full items-center pb-4 mb-4 border-b border-zinc-300">
                        <img src="{{ Storage::url($auction->images[0]) }}" alt=""
                            class="w-11 h-11 object-cover rounded-lg border border-zinc-300">
                        <div class="flex-grow">
                            <p>
                                {{ substr($auction->title, 0, length: 20) }}{{ strlen($auction->title) > 20 ? '...' : '' }}
                            </p>
                            <p class="text-zinc-500 text-sm">{{ $auction->category->name }}</p>
                        </div>
                        <p class="flex-grow">{{ $auction->bid_count }} Bids</p>
                        <p class="flex-grow">Rs. {{ number_format($auction->current_price, 2) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        const ctx = document.getElementById('lineChart').getContext('2d');

        const salesByMonthChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep',
                    'Oct', 'Nov', 'Dec'
                ],
                datasets: [{
                    label: 'Sales by Month',
                    data: @json($salesByMonth),
                    borderColor: 'rgba(61, 99, 221, 1)',
                    backgroundColor: 'rgba(61, 99, 221, 0.05)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.2,
                    pointRadius: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false,
                            border: false,
                        },
                    },
                    x: {
                        grid: {
                            border: false,
                        },
                    },
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                },
            }
        });
    </script>
@endsection

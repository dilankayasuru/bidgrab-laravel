<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BidGrab</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @livewireStyles
</head>

<body class="font-sans antialiased">

    @livewire('navigation-menu')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-[calc(100vh-64px)] py-8 flex gap-4">

        @livewire('image-preview', ['images' => $auction->images])

        <div class="w-full h-full px-4">
            <div class="mb-2 pb-4 border-b border-zinc-400">
                <p class="text-2xl font-medium mb-2">{{ $auction->title }}</p>
                <p class="text-zinc-500 text-lg mb-2">{{ $auction->category()->first()->name }}</p>
                <p class="text-2xl font-bold mb-2">Rs. {{ number_format($auction->current_price, 2, '.') }}</p>

                <div class="flex gap-2 flex-wrap">
                    <p class="px-2 rounded-md bg-blue bg-opacity-5 border border-blue">{{ $auction->bids }}
                        <span>{{ $auction->bids === 1 ? 'Bid' : 'Bids' }}</span>
                    </p>
                    <p x-data="countdown()" class="px-2 rounded-md bg-blue bg-opacity-5 border border-blue">
                        Ends in: <span x-text="time"></span>
                    </p>
                </div>
            </div>

            <div class="mb-4">
                <p class="py-1 px-2 bg-zinc-5 border-b border-zinc-300"><span class="text-zinc-500">Condition:</span>
                    <span class="capitalize mb-2">{{ $auction->condition }}</span></p>
                @foreach (json_decode($auction->specs) as $key => $spec)
                    <p class="py-1 px-2 bg-zinc-5 border-b border-zinc-300"><span
                            class="text-zinc-500">{{ ucfirst($key) }}:</span> {{ ucfirst($spec) }}
                    </p>
                @endforeach
            </div>

            <button
                class="hover:shadow-lg active:shadow-md active:translate-y-0.5 w-full py-2 rounded-full bg-blue text-white font-medium text-lg transition-all duration-300">Place
                bid</button>
        </div>

    </main>
    <script>
        function countdown() {
            return {
                show: true,
                time: '',
                init() {
                    setInterval(() => {
                        const now = new Date().getTime();
                        const countDownDate = new Date("{{ $auction->end_date }}").getTime();
                        const difference = countDownDate - now;

                        if (difference < 0) {
                            this.time = 'EXPIRED';
                            return;
                        }

                        const days = Math.floor(difference / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((difference % (1000 * 60)) / 1000);

                        this.time = `${days}d ${hours}h ${minutes}m ${seconds}s`;
                    }, 1000);
                },
            }
        }
    </script>
    @livewireScripts
</body>

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BidGrab | Home</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <script src="https://creattie.com/js/embed.js?id=3f6954fde297cd31b441" defer></script>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @livewireStyles
</head>

<body class="font-sans antialiased">

    @livewire('navigation-menu')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-4">

        <x-welcome-banner />

        <p class="font-medium text-2xl mb-4">Browse categories</p>
        <div class="grid gap-4 grid-cols-6 py-4 mb-8">
            @foreach ($categories as $category)
                @livewire('category-circle', ['category' => $category])
            @endforeach
        </div>

        <div class="bg-cover bg-center rounded-3xl h-80 mb-8 p-4 relative z-10 overflow-hidden"
            style="background-image: url({{ asset('images/banner.webp') }})">
            <div class="w-4/6 h-full flex items-center justify-start relative z-20 px-12">
                <div class="text-white">
                    <p class="text-3xl font-semibold mb-2">Turn Your Items into Bidding Wars!</p>
                    <p class="mb-8">Join our auction platform and start selling to eager bidders worldwide.
                        List
                        your items, set your price, and watch the bids roll in!</p>
                    <a href="#"
                        class="duration-300 transition-all hover:bg-opacity-85 active:shadow shadow-md active:translate-y-0.5 font-medium text-white bg-black rounded-full py-2 px-4">
                        Start Selling Today!
                    </a>
                </div>
            </div>
            <div class="bg-black bg-opacity-30 backdrop-blur w-4/6 absolute h-full top-0 -left-12 z-10 -skew-x-12">
            </div>
        </div>

        <p class="font-medium text-2xl">Trending auctions</p>
        <div class="grid md:grid-cols-5 gap-8 p-4">
            @foreach ($auctions as $auction)
                @livewire('card', ['auction' => $auction])
            @endforeach
        </div>
    </main>
    <x-footer />
    @livewireScripts
</body>

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BidGrab | Home</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @livewireStyles
</head>

<body class="font-sans antialiased">

    @livewire('navigation-menu')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-4">
        <div class="mb-8">
            <x-product-banner image="banner-1.webp">
                <div class="w-full p-8">
                    <p class="text-3xl text-white font-bold">Your Next Great Find Awaits</p>
                    <p class="text-xl text-white font-medium">Bid, Win, and Make It Yours – Discover Treasures Today!
                    </p>
                </div>
            </x-product-banner>
        </div>
        <div class="grid md:grid-cols-5 gap-8">
            @foreach ($auctions as $auction)
                @livewire('card', ['auction' => $auction])
            @endforeach
        </div>
    </main>
    @livewireScripts
</body>

</html>

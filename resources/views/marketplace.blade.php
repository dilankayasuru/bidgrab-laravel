<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BidGrab</title>

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

    <x-navigation />
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex py-8 md:gap-4">
        <div class="w-60 flex-shrink-0">
            @livewire('auction-filter')
        </div>
        <div>
            <p class="text-xl font-medium">
                {{ request()->routeIs('marketplace') ? 'Browse auctions' : 'Search results' }}
            </p>
            <div class="grid md:grid-cols-3 gap-8 py-4 mb-2">
                @foreach ($auctions as $auction)
                    @livewire('card', ['auction' => $auction])
                @endforeach
            </div>
            {{ $auctions->links() }}
        </div>
    </main>
    <x-footer />
    @livewireScripts
</body>

</html>

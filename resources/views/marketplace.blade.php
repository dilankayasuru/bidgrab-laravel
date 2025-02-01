<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>BidGrab</title>

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

    <x-navigation />
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex py-8 md:gap-8">
        <div class="w-60 flex-shrink-0">
            @livewire('auction-filter')
        </div>
        <div class="w-full">
            <p class="text-xl font-medium">
                {{ request()->routeIs('marketplace') ? 'Browse auctions' : 'Search results' }}
            </p>
            <div class="grid md:grid-cols-4 gap-8 py-4 mb-2">
                @foreach ($auctions as $auction)
                    @livewire('card', ['auction' => $auction])
                @endforeach
            </div>
            {{ $auctions->links() }}
            @if (count($auctions) <= 0)
                <div class="w-full grid place-items-center">
                    <creattie-embed
                        src="https://d1jj76g3lut4fe.cloudfront.net/saved_colors/109057/VhnWEza377Pzqvu7.json"
                        delay="1" speed="100" frame_rate="24" trigger="loop" class="max-w-md">
                    </creattie-embed>
                    <p class="text-zinc-500">No auction found!</p>
                </div>
            @endif
        </div>
    </main>
    <x-footer />
    @livewireScripts
</body>

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body x-data="{ open: false }" class="font-sans antialiased">
    <div
        class="p-4 bg-blue shadow-md md:hidden md:invisible flex justify-between items-center sticky top-0 left-0 w-full z-50">
        <a href="{{ route('welcome') }}" class="font-extrabold text-2xl text-white">BidGrab</a>
        <button x-show="open == false" @click="open = true">
            <img src="{{ asset('icons/menu.svg') }}" alt="menu open button" class="w-8 h-8">
        </button>
        <button x-show="open" @click="open = false">
            <img src="{{ asset('icons/close.svg') }}" alt="menu close button" class="w-8 h-8">
        </button>
    </div>
    <div class="flex bg-blue relative">
        <div class="fixed md:static z-50 top-0 left-0 bg-blue md:translate-x-0 transition-all duration-300"
            :class="{ '-translate-x-full': !open, 'translate-x-0': open }">
            <div class="min-h-dvh p-4 relative">
                <div class="pb-4 border-b border-fadeWhite">
                    <a href="{{ route('welcome') }}" class="font-extrabold text-2xl text-white">BidGrab</a>
                </div>

                <div class="py-4">
                    <x-dashboard.menutab label="Dashboard" routeName="dashboard" icon="home.svg" />
                    <x-dashboard.menutab label="Auctions" routeName="dashboard.auctions" icon="gavel.svg" />
                    <x-dashboard.menutab label="Orders" routeName="dashboard.orders" icon="shipping-white.svg" />
                    <x-dashboard.menutab label="Purchases" routeName="dashboard.purchases" icon="shopping_bag.svg" />
                    <x-dashboard.menutab label="Create new auction" routeName="dashboard.create"
                        icon="add_circle.svg" />
                </div>
                <div class="flex items-center gap-2 absolute bottom-0 pb-8">
                    <div class="w-14 h-14 object-cover overflow-hidden border-blue-500 border shadow-md rounded-full">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="user pic"
                            class="w-full h-full object-cover">
                    </div>
                    <div>
                        <p class="text-white">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-white">Customer</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="pl-0 md:pr-4 md:py-4 w-full">
            <div class="bg-white md:rounded-xl h-full md:max-h-[calc(100vh-32px)] md:overflow-y-auto">
                @yield('content')
            </div>
        </div>
    </div>
    @livewireScripts
    <script src="https://creattie.com/js/embed.js?id=3f6954fde297cd31b441" defer></script>
</body>

</html>

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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @livewireStyles
</head>

<body class="font-sans antialiased">

    <x-navigation />
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-4">

        <x-welcome-banner />
        <div class="mb-8 overflow-hidden">
            <p class="font-medium text-2xl mb-8">Browse categories</p>
            <div class="swiper-container mb-4">
                <div class="swiper-wrapper mb-4">
                    @foreach ($categories as $category)
                        <div class="swiper-slide">
                            @livewire('category-circle', ['category' => $category])
                        </div>
                    @endforeach
                </div>
                <!-- Add Pagination -->
                <div class="grid place-items-center">
                    <div class="swiper-pagination !static !translate-x-0"></div>
                </div>
            </div>
        </div>


        <div class="bg-cover bg-center rounded-3xl h-80 mb-8 p-4 relative z-10 overflow-hidden"
            style="background-image: url({{ asset('images/banner.webp') }})">
            <div class="w-full md:w-4/6 h-full flex items-center justify-start relative z-20 px-4 md:px-12">
                <div class="text-white">
                    <p class="text-xl md:text-3xl font-semibold mb-2">Turn Your Items into Bidding Wars!</p>
                    <p class="mb-8 text-sm md:text-base">Join our auction platform and start selling to eager bidders
                        worldwide.
                        List your items, set your price, and watch the bids roll in!</p>
                    <a href="{{ route('dashboard.create') }}"
                        class="duration-300 transition-all hover:bg-opacity-85 active:shadow shadow-md active:translate-y-0.5 font-medium text-white bg-black rounded-full py-2 px-4">
                        Start Selling Today!
                    </a>
                </div>
            </div>
            <div
                class="bg-black bg-opacity-30 backdrop-blur w-full md:w-4/6 absolute h-full top-0 -left-12 z-10 -skew-x-12">
            </div>
        </div>

        <p class="font-medium text-2xl">Trending auctions</p>
        <div class="grid md:grid-cols-5 gap-8 p-4 mb-8">
            @foreach ($auctions as $auction)
                @livewire('card', ['auction' => $auction])
            @endforeach
        </div>
    </main>
    <x-footer />
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var swiper = new Swiper('.swiper-container', {
                slidesPerView: 2,
                spaceBetween: 10,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    dynamicBullets: true,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 3,
                        spaceBetween: 10,
                    },
                    768: {
                        slidesPerView: 4,
                        spaceBetween: 16,
                    },
                    1024: {
                        slidesPerView: 6,
                        spaceBetween: 24,
                    },
                },
                autoplay: {
                    delay: 3000,
                    pauseOnMouseEnter: true,
                },
            });
        });
    </script>
    @livewireScripts
</body>

</html>

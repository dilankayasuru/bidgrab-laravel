<footer class="bg-blue bg-opacity-5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-16 border-b border-zinc-400 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-8 md:mb-0">
                <a href="{{ url('/') }}" class="text-3xl font-bold text-blue mb-8 flex justify-center md:justify-start">BidGrab</a>
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="text-center md:text-left">
                        <p class="text-sm text-zinc-500">Email</p>
                        <p class="font-medium">contact@bidgrab.live</p>
                    </div>
                    <div class="text-center md:text-left">
                        <p class="text-sm text-zinc-500">Phone number</p>
                        <p class="font-medium">+94 72 003 0120</p>
                    </div>
                </div>
            </div>
            <div class="text-center md:text-end">
                <p class="text-2xl font-semibold mb-8">Your Ultimate Auction<br> Marketplace!</p>
                <div class="flex flex-col md:flex-row justify-center md:justify-end items-center gap-4">
                    <a class="active:shadow shadow-md active:translate-y-0.5 font-medium px-4 py-2 bg-blue rounded-full hover:bg-opacity-90 duration-300 transition-all text-white"
                        href="{{ route('marketplace') }}">Explore marketplace</a>
                    <a href="{{ route('dashboard.create') }}"
                        class="duration-300 transition-all active:shadow shadow-md active:translate-y-0.5 px-4 py-2 border border-blue rounded-full">Start
                        selling</a>
                </div>
            </div>
        </div>
    </div>
    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-sm text-zinc-500 text-center md:text-left">© 2024 BidGrab, All rights reserved.</p>
    </div>
    <div class="h-2 w-full bg-blue"></div>
</footer>
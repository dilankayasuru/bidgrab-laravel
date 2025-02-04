<div class="rounded-3xl bg-cover bg-center flex flex-col md:flex-row items-center justify-between p-4 md:p-8">
    <div class="max-w-xl mb-4 md:mb-0">
        <p class="text-xl md:text-3xl font-semibold mb-2">Explore, Bid & Win - Your Next Great Find Awaits!</p>
        <p class="text-sm md:text-base font-medium mb-4">Browse a world of unique auctions, from rare collectibles to
            everyday essentials. Place your bid and claim amazing deals before they're gone!</p>
        <a href="{{ route('marketplace') }}"
            class="w-fit duration-300 transition-all hover:bg-opacity-85 active:shadow shadow-md active:translate-y-0.5 font-medium text-white bg-black rounded-full py-2 px-4 flex items-center gap-2">
            <span>Explore Auctions Now!</span> <img src="{{ asset('icons/rocket.svg') }}" alt="" class="w-4">
        </a>
    </div>
    @csrf
    <creattie-embed src="{{url('/proxy?url=https://d1jj76g3lut4fe.cloudfront.net/saved_colors/109057/jm6Munq66RgAyPj0.json')}}" delay="1"
        speed="100" frame_rate="24" trigger="loop" class="w-full max-w-xs md:max-w-96">
    </creattie-embed>
</div>

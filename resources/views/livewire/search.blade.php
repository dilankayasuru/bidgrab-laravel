<div class="gird place-items-center absolute top-0 left-1/2 -translate-x-1/2 pt-[11px] z-10">
    <div class="w-full px-4 bg-white rounded-full shadow-sm flex justify-between max-w-md border-zinc-200 border">
        <input type="text" placeholder="Search Products" id="search" wire:model.live="keyword" autocomplete="off"
            class="border-none appearance-none outline-none !ring-offset-0 !ring-0 !shadow-none w-full">
        <a href="{{ route('auction.search', $keyword) }}"
            class="grid place-items-center {{ $keyword === '' ? 'pointer-events-none' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                fill="#000000">
                <path
                    d="M380-320q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l224 224q11 11 11 28t-11 28q-11 11-28 11t-28-11L532-372q-30 24-69 38t-83 14Zm0-80q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
            </svg>
        </a>
    </div>
    @if (count($results) > 0)
        <div class="rounded-xl bg-white p-4 shadow-lg mt-2 grid gap-2">
            @foreach ($results as $auction)
                <a href="{{ route('auction.show', ['auction' => $auction]) }}"
                    class="cursor-pointer flex gap-4 items-center">
                    <img class="h-16 aspect-square rounded-lg shadow-md" src="{{ Storage::url($auction->images[0]) }}"
                        alt="">
                    <div>
                        <p>
                            {{ substr($auction->title, 0, length: 35) }}{{ strlen($auction->title) > 35 ? '...' : '' }}
                        </p>
                        <p class="text-zinc-500">{{ $auction->category()->first()->name }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>

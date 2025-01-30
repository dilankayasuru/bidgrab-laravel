<div x-show={{ $show }} x-data="{ show: false }">
    <button @click="show = true" class="flex items-center">
        <img src="{{ asset('icons/delete.svg') }}" alt="delete">
    </button>

    <div x-show="show" class="h-screen w-screen fixed top-0 left-0 z-50 backdrop-blur-sm bg-black bg-opacity-20">
        <form wire:submit="delete"
            class="bg-white p-4 shadow-sm border-zinc-200 border rounded-md z-50 fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
            <div class="flex items-center mb-4 gap-2">
                <img src="{{ asset('icons/warning.svg') }}" alt="">
                <h1 class="font-medium text-lg">Delete auction</h1>
            </div>
            <p class="mb-2">Are you Are you sure you want to delete this auction?</p>
            <p class="mb-2">Type &quot;{{ $auction->id }}&quot; to confirm your deletion</p>

            <div>
                <input class="w-full rounded-md" type="text" wire:model.live="confirmAuctionId" required>
            </div>

            @error('confirmAuctionId')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror

            <div class="w-full flex justify-end gap-2 mt-4">
                <button @click="show = false" type="reset"
                    class="py-2 px-4 border border-blue rounded-lg">Cancel</button>
                <button type="submit" class="py-2 px-4 bg-red-500 rounded-lg text-white">Delete</button>
            </div>
        </form>
    </div>
</div>

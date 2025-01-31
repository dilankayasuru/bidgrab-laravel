<div class="sticky top-10">
    <p class="text-xl font-medium mb-2">Filter</p>
    <div class="py-4 border-b border-zinc-400">
        <p class="mb-2">Price - LKR</p>
        <div class="flex items-center gap-2">
            <input type="number" placeholder="min" min="150" class="w-20 rounded-lg" wire:model="minPrice">
            <span>to</span>
            <input type="number" placeholder="max" min="150" class="w-20 rounded-lg" wire:model="maxPrice">
        </div>
    </div>
    <div class="py-4 border-b border-zinc-400">
        <p class="mb-2">Condition</p>
        <div class="flex items-center gap-2">
            <input type="radio" name="condition" class="rounded" id="new" wire:model="condition" value="new">
            <label for="new">Brand new</label>
        </div>
        <div class="flex items-center gap-2">
            <input type="radio" name="condition" class="rounded" id="used" wire:model="condition" value="used">
            <label for="used">Used</label>
        </div>
        <div class="flex items-center gap-2">
            <input type="radio" name="condition" class="rounded" id="reconditioned" wire:model="condition"
                value="reconditioned">
            <label for="reconditioned">Reconditioned</label>
        </div>
        <div class="flex items-center gap-2">
            <input type="radio" name="condition" class="rounded" id="preowned" wire:model="condition"
                value="preowned">
            <label for="preowned">Pre-owned</label>
        </div>
    </div>
    <div class="py-4 border-b border-zinc-400">
        <p class="mb-2">Category</p>
        <select name="category" class="rounded-lg" wire:model="selectedCategory">
            <option value="">Select a category</option>
            @foreach ($categories as $id => $category)
                <option value="{{ $id }}">{{ $category }}</option>
            @endforeach
        </select>
    </div>
    <div class="py-4 border-b border-zinc-400 mb-4">
        <p class="mb-2">Sort</p>
        <div class="flex items-center gap-2">
            <input type="radio" name="sort" id="price" wire:model="sort" value="price">
            <label for="price">Cheapest first</label>
        </div>
        <div class="flex items-center gap-2">
            <input type="radio" name="sort" id="date" wire:model="sort" value="date">
            <label for="date">Latest first</label>
        </div>
    </div>
    <button wire:click="apply()"
        class="bg-blue mb-2 text-white hover:bg-opacity-90 shadow-md active:translate-y-0.5 active:shadow duration-300 transition-all p-2 rounded-full w-full block text-center">Apply
        filter</button>
    <a href="{{ route('marketplace') }}"
        class="shadow-md active:translate-y-0.5 active:shadow duration-300 transition-all p-2 rounded-full w-full border border-blue block text-center">Reset
        filter</a>
</div>

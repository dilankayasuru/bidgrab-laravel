<form wire:submit="save" class="md:max-w-xl md:mx-auto md:my-0">
    <div class="py-4">
        <div class="mb-4">
            <p class="mb-2">Images</p>

            @if (count($images) > 0)
                <div class="flex gap-2 mb-2 flex-wrap">
                    @foreach ($images as $index => $image)
                        <div class="relative">
                            <img src="{{ is_string($image) ? Storage::url($image) : $image->temporaryUrl() }}"
                                alt="new auction image"
                                class="rounded-md w-16 h-16 object-cover aspect-square border-zinc-300 border">
                            <button wire:click="unsetImage({{ $index }})" type="button"
                                class="absolute top-0 right-0">
                                <img src="{{ asset('icons/backspace.svg') }}" alt="clear image" />
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif

            <label for="images-upload"
                class="hover:shadow-md active:shadow-sm hover:bg-opacity-90 active:translate-y-0.5 transition-all duration-300 flex justify-between items-center gap-2 w-fit p-2 bg-blue rounded-md text-white cursor-pointer">
                <img src="{{ asset('icons/upload.svg') }}" alt="file upload icon"> Upload photos
            </label>
            <span wire:loading wire:target="images" class="animate-pulse mt-1">Uploading...</span>
            <input id="images-upload" type="file" wire:model.live="images" accept="image/*" multiple required hidden>
            @error('images.*')
                <span class="text-red-500 text-sm block">{{ $message }}</span>
            @enderror
            @error('images')
                <span class="text-red-500 text-sm block">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label class="mb-2" for="auction-title">
                Title
            </label>
            <input wire:model.live="title" required id="auction-title" type="text" placeholder="Enter product title"
                name="auction-title"
                class="appearance-none rounded-lg border-zinc-500 border w-full py-3 px-5  focus:outline-none focus:shadow-outline">
            @error('title')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label class="mb-2" for="description">
                Description
            </label>
            <textarea wire:model.live="description" required rows="5" id="description" name="description"
                placeholder="Enter your product description"
                class="appearance-none rounded-lg border-zinc-500 border w-full py-3 px-5 focus:outline-none focus:shadow-outline"></textarea>
            @error('description')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label class="mb-2" for="category">
                Category
            </label>
            <select wire:model.live="categoryId" wire:model="categoryId" required name="category" id="category"
                class="mr-2 appearance-none rounded-lg w-full py-3 px-4 focus:outline-none focus:shadow-outline">
                <option value="">Select a category</option>
                @foreach ($categories as $id => $category)
                    <option value="{{ $id }}">{{ $category }}</option>
                @endforeach
            </select>
            @error('categoryId')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label class="mb-2" for="condition">
                Condition
            </label>
            <select wire:model.live="condition" required name="condition" id="condition"
                class="mr-2 appearance-none rounded-lg w-full py-3 px-4 focus:outline-none focus:shadow-outline">
                <option value="">Select condition</option>
                <option value="new">Brand new</option>
                <option value="used">Used</option>
                <option value="reconditioned">Reconditioned</option>
                <option value="pre-owned">Pre-owned</option>
            </select>
            @error('condition')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label class="mb-2" for="duration">
                Duration
            </label>
            <select wire:model.live="duration" required name="duration" id="duration"
                class="mr-2 appearance-none rounded-lg w-full py-3 px-4 focus:outline-none focus:shadow-outline">
                <option value="">Select duration</option>
                <option value="1">1 day</option>
                <option value="3">3 days</option>
                <option value="5">5 days</option>
                <option value="7">7 days</option>
                <option value="10">10 days</option>
            </select>
            @error('duration')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label class="mb-2" for="auction-start">
                Starting date
            </label>
            <input wire:model.live="startingDate" required min="{{ date('Y-m-d') }}"
                max="{{ date('Y-m-d', strtotime(date('Y-m-d') . ' + 7 days')) }}" id="auction-start" type="date"
                name="auction-start"
                class="appearance-none rounded-lg border-zinc-500 border w-full py-3 px-5  focus:outline-none focus:shadow-outline">
            @error('startingDate')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label class="mb-2" for="starting-price">
                Starting price
            </label>
            <div class="flex items-center gap-2">
                <span>LKR</span>
                <input wire:model.live="startingPrice" required id="starting-price" min="150" type="number" step="0.01"
                    name="starting-price"
                    class="appearance-none rounded-lg border-zinc-500 border w-full py-3 px-5  focus:outline-none focus:shadow-outline">
            </div>
            @error('startingPrice')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="w-full h-px bg-zinc-300 my-4"></div>

        <p class="text-zinc-500 text-lg mb-4">Item specifications - Optional</p>

        <div class="md:grid md:grid-cols-2 md:gap-4">
            @foreach ($itemSpecifications as $spec)
                <div class="md:mb-0 mb-4">
                    <label class="mb-2" for="{{ $spec }}">
                        {{ ucfirst($spec) }}
                    </label>
                    <input id="{{ $spec }}" wire:model="itemSpecs.{{ $spec }}" type="text"
                        class="appearance-none rounded-lg border-zinc-500 border w-full py-3 px-5  focus:outline-none focus:shadow-outline">
                </div>
            @endforeach
        </div>

    </div>

    <button type="submit"
        class="bg-blue text-white p-2 w-full rounded-md transition-all duration-300 hover:shadow-lg hover:bg-blue-800 active:shadow-md active:translate-y-0.5">Save</button>
</form>

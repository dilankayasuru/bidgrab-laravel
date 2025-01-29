<form wire:submit="save" class="md:max-w-xl md:mx-auto md:my-0">
    <div class="py-4">
        <div class="mb-4">
            <p class="mb-2">Images</p>

            @if (count($images) > 0)
                <div class="flex gap-2 mb-2 flex-wrap">
                    @foreach ($images as $image)
                        <img src="{{ $image->temporaryUrl() }}" alt="new auction image"
                            class="rounded-md w-16 h-16 object-cover aspect-square border-zinc-300 border">
                    @endforeach
                </div>
            @endif

            <label for="images-upload"
                class="hover:shadow-md active:shadow-sm hover:bg-opacity-90 active:translate-y-0.5 transition-all duration-300 flex justify-between items-center gap-2 w-fit p-2 bg-blue rounded-md text-white cursor-pointer">
                <img src="{{ asset('icons/upload.svg') }}" alt="file upload icon"> Upload photos
            </label>
            <input id="images-upload" type="file" wire:model="images" accept="image/*" multiple required hidden>

            @error('images.*')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label class="mb-2" for="auction-title">
                Title
            </label>
            <input required id="auction-title" type="text" placeholder="Enter product title" name="auction-title"
                class="appearance-none rounded-lg border-zinc-500 border w-full py-3 px-5  focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label class="mb-2" for="description">
                Description
            </label>
            <textarea required rows="5" id="description" name="description" placeholder="Enter your product description"
                class="appearance-none rounded-lg border-zinc-500 border w-full py-3 px-5 focus:outline-none focus:shadow-outline"></textarea>
        </div>

        <div class="mb-4">
            <label class="mb-2" for="category">
                Category
            </label>
            <select required name="category" id="category"
                class="mr-2 appearance-none rounded-lg w-full py-3 px-4 focus:outline-none focus:shadow-outline">
                <option value="new">Brand new</option>
                <option value="used">Used</option>
                <option value="reconditioned">Reconditioned</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="mb-2" for="condition">
                Condition
            </label>
            <select required name="condition" id="condition"
                class="mr-2 appearance-none rounded-lg w-full py-3 px-4 focus:outline-none focus:shadow-outline">
                <option value="new">Brand new</option>
                <option value="used">Used</option>
                <option value="reconditioned">Reconditioned</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="mb-2" for="duration">
                Duration
            </label>
            <select required name="duration" id="duration"
                class="mr-2 appearance-none rounded-lg w-full py-3 px-4 focus:outline-none focus:shadow-outline">
                <option value="1">1 day</option>
                <option value="3">3 days</option>
                <option value="5">5 days</option>
                <option value="7">7 days</option>
                <option value="10">10 days</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="mb-2" for="auction-start">
                Starting date
            </label>
            <input required min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime(date('Y-m-d') . ' + 7 days')) }}"
                id="auction-start" type="date" name="auction-start"
                class="appearance-none rounded-lg border-zinc-500 border w-full py-3 px-5  focus:outline-none focus:shadow-outline">
        </div>

        <div>
            <label class="mb-2" for="starting-price">
                Starting price
            </label>
            <div class="flex items-center gap-2">
                <span>LKR</span>
                <input required id="starting-price" min="150" type="number" name="starting-price"
                    class="appearance-none rounded-lg border-zinc-500 border w-full py-3 px-5  focus:outline-none focus:shadow-outline">
            </div>

        </div>
    </div>

    <button type="submit"
        class="bg-blue text-white p-2 w-full rounded-md transition-all duration-300 hover:shadow-lg hover:bg-blue-800 active:shadow-md active:translate-y-0.5">Save</button>
</form>

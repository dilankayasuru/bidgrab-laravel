<a href="{{ route('marketplace', ['category' => $category->id]) }}" class="grid place-items-center">
    <img src="{{ Storage::url($category->image) }}" alt=""
        class="rounded-full aspect-square w-32 shadow-md mb-2 object-cover">
    <span class="font-medium">{{ $category->name }}</span>
</a>

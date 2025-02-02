<div class="grid grid-cols-5 place-items-center py-2 border-b border-zinc-300">

    <img src="{{ $user->profile_photo_url }}" alt=""
        class="w-12 h-12 aspect-square object-cover rounded-full border border-zinc-300">

    <p>
        {{ substr($user->name, 0, length: 50) }}{{ strlen($user->name) > 50 ? '...' : '' }}
    </p>

    <p>
        {{ substr($user->email, 0, length: 50) }}{{ strlen($user->email) > 50 ? '...' : '' }}
    </p>

    <p>
        {{ $user->created_at }}
    </p>

    <p class="capitalize">
        {{ $user->role }}
    </p>
</div>

@extends('layouts.dashboard')

@section('content')
    <div class="p-4">
        <div class="md:flex w-full justify-between md:mb-0 mb-4">
            <div>
                <div class="mb-4">
                    <h1 class="text-2xl font-medium">Users</h1>
                    <p class="text-zinc-500">Total users: {{ count($users) ?? 0 }}</p>
                </div>
                <div class="mb-4 flex gap-2 flex-wrap">
                    @php
                        $type = request()->input('type');
                    @endphp
                    <a href="{{ route('dashboard.users', ['type' => 'all']) }}"
                        class="rounded-xl border border-zinc-300 px-4 py-1 duration-300 transition-all hover:shadow-md active:shadow active:translate-y-0.5 {{ $type == 'all' ? 'bg-blue text-white hover:bg-opacity-90' : 'bg-zinc-50 hover:bg-zinc-100' }}">All</a>
                    <a href="{{ route('dashboard.users', ['type' => 'user']) }}"
                        class="rounded-xl border border-zinc-300 px-4 py-1 duration-300 transition-all hover:shadow-md active:shadow active:translate-y-0.5 {{ $type == 'user' ? 'bg-blue text-white hover:bg-opacity-90' : 'bg-zinc-50 hover:bg-zinc-100' }}">User</a>
                    <a href="{{ route('dashboard.users', ['type' => 'admin']) }}"
                        class="rounded-xl border border-zinc-300 px-4 py-1 duration-300 transition-all hover:shadow-md active:shadow active:translate-y-0.5 {{ $type == 'admin' ? 'bg-blue text-white hover:bg-opacity-90' : 'bg-zinc-50 hover:bg-zinc-100' }}">Admin</a>
                </div>
            </div>
            <x-dashboard.create-user />
        </div>


        <div class="hidden grid-cols-5 place-items-center py-2 bg-blue bg-opacity-15 md:grid">
            <p>Profile picture</p>
            <p>Name</p>
            <p>Email</p>
            <p>Date joined</p>
            <p>Role</p>
        </div>
        @if ($users && count($users) > 0)
            @foreach ($users as $user)
                <x-dashboard.user :user="$user" />
            @endforeach
        @else
            <div class="grid place-items-center">
                <creattie-embed src="https://d1jj76g3lut4fe.cloudfront.net/saved_colors/109057/f3BrZjQcZ0ZgpmTQ.json"
                    delay="1" speed="100" frame_rate="24" trigger="loop" class="w-full max-w-80">
                </creattie-embed>
                <p class="text-zinc-500">No user found!</p>
            </div>
        @endif
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection

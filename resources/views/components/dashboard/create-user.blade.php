<div x-data="{ show: false }">
    <button @click="show = true"
        class="flex justify-between items-center gap-2 px-4 hover:bg-opacity-90 active:translate-y-0.5 duration-300 transition-all shadow-lg active:shadow-md py-2 rounded-lg text-white bg-blue">
        <img src="{{ asset('icons/person_add.svg') }}" alt="add new user"> <span>Create new user</span>
    </button>

    <div x-show="show" class="h-screen w-screen fixed top-0 left-0 z-50 backdrop-blur-sm bg-black bg-opacity-20">
        <div
            class="bg-white p-4 shadow-sm border-zinc-200 border rounded-md z-50 fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
            <div class="flex items-center justify-between mb-4 gap-2">
                <h1 class="font-medium text-lg">Create new user</h1>
                <button @click="show = false">
                    <img src="{{ asset('icons/close_black.svg') }}" alt="">
                </button>
            </div>
            <form method="POST" action="{{ route('dashboard.create.user') }}">
                @csrf
                <div class="md:min-w-80">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                        required autofocus autocomplete="name" />
                </div>

                <div class="mt-4">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autocomplete="username" />
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="new-password" />
                </div>

                <div class="mt-4">
                    <x-label for="user_role" value="{{ __('User Role') }}" />
                    <select name="user_role" id="user_role"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <option value="user" selected>User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="w-full grid place-items-end mt-4">
                    <x-button>
                        {{ __('Register') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>

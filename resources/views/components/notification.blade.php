<div class="fixed z-50 top-20 right-0" x-data="{ show: true, timeout: null }" x-init="timeout = setTimeout(() => { show = false }, 2000)" x-show="show"
    x-transition:enter="transition transform ease-out duration-300" 
    x-transition:enter-start="translate-y-full opacity-0"
    x-transition:enter-end="translate-y-0 opacity-100" 
    x-transition:leave="transition transform ease-in duration-300"
    x-transition:leave-start="translate-y-0 opacity-100" 
    x-transition:leave-end="-translate-y-full opacity-0">
    <div class="mr-4 rounded overflow-hidden shadow-md">
        <div class="flex items-center gap-2 px-4 py-2 {{ $type === 'error' ? 'bg-red-500' : 'bg-green-500' }} md:min-w-80">
            @if ($type === 'error')
                <img src="{{ asset('icons/error.svg') }}" alt="">
            @else
                <img src="{{ asset('icons/success.svg') }}" alt="">
            @endif
            <p class="text-white">
                {{ $message }}
            </p>
        </div>
    </div>
</div>

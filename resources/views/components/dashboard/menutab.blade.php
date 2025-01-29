<a href='{{ route($routeName)}}'
    class='{{request()->routeIs($routeName) ? 'bg-white bg-opacity-15' : ''}} mb-2 flex gap-4 items-center py-3 px-6 rounded-full w-60 hover:bg-white-15 hover:-translate-y-0.5 hover:shadow-lg hover:bg-white hover:bg-opacity-15 active:translate-y-0 active:shadow-md transition-all duration-300'>
    <img src="{{asset("icons/$icon")}}" alt="{{$icon}}-icon">
    <p class='text-white'>{{$label}}</p>
</a>

@props(['image' => '', 'text' => ''])

<div class="h-80 rounded-3xl bg-cover bg-center flex items-center"
    style="background-image: url('../images/{{ $image }}')">
    {{ $slot }}
</div>

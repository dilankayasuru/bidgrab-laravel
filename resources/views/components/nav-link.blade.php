@props(['active'])

@php
$classes = ($active ?? false)
            ? 'nav-link px-5 py-1 rounded-3xl text-white hover:border-none after:content-none bg-blue'
            : 'nav-link hover:text-blue text-gray-400';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

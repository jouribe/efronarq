@props(['href'])

@php
$classes = 'inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} href="{{ $href }}">
    {{ $slot }}
</a>

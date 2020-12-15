@props(['href' => 'javascript:'])

<a {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 focus:border-blue-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 bg-blue-800 hover:bg-blue-700 active:bg-blue-900']) }} href="{{ $href }}">
    {{ $slot }}
</a>

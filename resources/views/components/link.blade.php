@props(['color' => 'blue'])

<a {{ $attributes->merge(['class' => "inline-flex items-center h-10 px-4 py-2 focus:border-{$color}-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 bg-{$color}-800 hover:bg-{$color}-700 active:bg-{$color}-900"]) }}>
    {{ $slot }}
</a>

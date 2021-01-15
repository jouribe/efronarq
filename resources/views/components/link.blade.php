@props(['color' => 'blue'])

<a {{ $attributes->merge(['class' => "inline-flex items-center h-10 px-4 py-2 focus:border-{$color}-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 bg-{$color}-500 hover:bg-{$color}-300 active:bg-{$color}-700"]) }}>
    {{ $slot }}
</a>

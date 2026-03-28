@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block w-full px-4 py-3 rounded-xl text-sm font-semibold bg-indigo-500/15 text-indigo-300 border border-indigo-500/20'
    : 'block w-full px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:text-white hover:bg-slate-800/70 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

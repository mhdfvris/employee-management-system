@props(['disabled' => false])

<input
    @disabled($disabled)
    {{ $attributes->merge([
        'class' => 'block w-full rounded-xl border border-blue-800 bg-blue-950 px-4 py-3 text-base text-blue-100 placeholder-blue-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500/30'
    ]) }}
>

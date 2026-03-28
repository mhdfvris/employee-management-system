@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-semibold text-blue-200']) }}>
    {{ $value ?? $slot }}
</label>

@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-semibold text-gray-200']) }}>
    {{ $value ?? $slot }}
</label>

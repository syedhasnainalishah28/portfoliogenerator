@props(['value'])

<label {{ $attributes->merge(['class' => 'ha-label block']) }}>
    {{ $value ?? $slot }}
</label>

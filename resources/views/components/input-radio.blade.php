@props(['id', 'name', 'value', 'label', 'checked' => false])

<div>
    <input type="radio" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}" {{ $checked ? 'checked' : '' }} {{ $attributes->merge(['class' => '']) }}>
    <label for="{{ $id }}">{{ $label }}</label>
</div>

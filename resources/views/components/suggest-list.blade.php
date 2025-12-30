@props(['color' => 'sub', 'id'])

@php
    $color = match ($color) {
        'sub' => 'absolute z-50 w-80 max-md:w-60 border border-sub bg-white shadow-md rounded-md hidden',
        'accent' => 'absolute z-50 w-80 max-md:w-60 border border-accent bg-white shadow-md rounded-md hidden',
    };
@endphp

<ul {{ $attributes->merge(['class' => "$color"]) }} id="{{ $id }}">
</ul>

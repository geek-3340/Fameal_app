@props(['width' => 'auto'])

@php
    $width = match ($width) {
        'auto' => 'w-auto',
        'full' => 'w-full text-center',
    };
@endphp

<button
    {{ $attributes->merge(['class' => "inline-block px-4 py-2 text-subtext font-semibold text-base bg-button-primary rounded-full hover:bg-button-primaryhover transition-colors duration-200 $width"]) }}>
    {{ $slot }}
</button>

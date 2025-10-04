@props(['type' => 'primary', 'width' => 'auto'])

@php
    $type = match ($type) {
        'primary'
            => 'inline-block px-4 py-2 text-white font-semibold text-base bg-button-primary rounded-full hover:bg-button-primaryhover transition-colors duration-200',
        'register'
            => 'inline-block px-4 py-2 text-white font-semibold text-base bg-button-secondary rounded-full hover:bg-button-secondaryhover transition-colors duration-200',
        'danger'
            => 'inline-block px-4 py-2 text-white font-semibold text-base bg-button-danger rounded-full hover:bg-button-dangerhover transition-colors duration-200',
    };
    $width = match ($width) {
        'auto' => 'w-auto',
        'full' => 'w-full text-center',
    };
@endphp

<a {{ $attributes->merge(['class' => "$type $width"]) }}>
    {{ $slot }}
</a>

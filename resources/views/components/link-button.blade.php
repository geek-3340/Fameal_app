@props(['type' => 'primary', 'width' => 'auto'])

@php
    $type = match ($type) {
        'primary'
            => 'inline-block px-4 py-2 text-subtext font-semibold text-base bg-main rounded-full hover:bg-hover transition-colors duration-200',
        'register'
            => 'inline-block px-4 py-2 text-subtext font-semibold text-base bg-accent rounded-full hover:bg-accenthover transition-colors duration-200',
        'danger'
            => 'inline-block px-4 py-2 text-subtext font-semibold text-base bg-danger rounded-full hover:bg-dangerhover transition-colors duration-200',
    };
    $width = match ($width) {
        'auto' => 'w-auto',
        'full' => 'w-full text-center',
    };
@endphp

<a {{ $attributes->merge(['class' => "$type $width"]) }}>
    {{ $slot }}
</a>

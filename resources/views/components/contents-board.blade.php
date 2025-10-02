@props(['shadow' => 'none'])

@php
    $shadow = match ($shadow) {
        'none' => 'shadow-none',
        'visible' => 'shadow-custom',
    };
@endphp

<div {{ $attributes->merge(['class' => "mt-8 mx-auto p-8 border border-main rounded-xl $shadow"]) }}>
    {{ $slot }}
</div>

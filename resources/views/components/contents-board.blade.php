@props(['type' => 'primary'])

@php
    $type = match ($type) {
        'primary' => 'shadow-none max-w-80 border',
        'content' => 'shadow-custom w-11/12 border-none',
        'two-contents' => 'shadow-custom w-1/2 border-none',
        'shopping-list' => 'shadow-custom w-3/5 border-none',
    };
@endphp

<div {{ $attributes->merge(['class' => "h-max my-8 mx-auto p-8 border-main rounded-xl $type"]) }}>
    {{ $slot }}
</div>

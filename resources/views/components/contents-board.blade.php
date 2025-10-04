@props(['shadow' => 'none','width'=>'primary'])

@php
    $shadow = match ($shadow) {
        'none' => 'shadow-none',
        'visible' => 'shadow-custom',
    };
    $width=match($width){
        'primary'=>'max-w-80',
        'contents'=>'w-9/12',
        'two-contents'=>'w-1/2',
    }
@endphp

<div {{ $attributes->merge(['class' => "h-max my-8 mx-auto p-8 border border-main rounded-xl $shadow $width"]) }}>
    {{ $slot }}
</div>

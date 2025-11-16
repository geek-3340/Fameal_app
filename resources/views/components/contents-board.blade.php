@props(['type' => 'primary'])

@php
    $type = match ($type) {
        'primary' => 'shadow-none max-w-80 border',
        'modal'=>'shadow-none w-[500px] border max-md:w-4/5',
        'content' => 'shadow-custom w-11/12 border-none',
        'two-contents' => 'shadow-custom w-1/2 border-none max-md:w-11/12',
        'shopping-list' => 'shadow-custom w-3/5 border-none max-md:w-11/12',
    };
@endphp

<div {{ $attributes->merge(['class' => "h-max my-8 mx-auto p-8 border-main rounded-xl $type"]) }}>
    {{ $slot }}
</div>

@props(['disabled' => false, 'use' => 'primary'])

@php
    $use = match ($use) {
        'primary' => 'focus:border-main focus:ring-main',
        'secondary' => 'focus:border-accent focus:ring-accent',
    };
@endphp


<input @disabled($disabled) {{ $attributes->merge(['class' => "border-gray-300 $use rounded-md shadow-sm"]) }}>

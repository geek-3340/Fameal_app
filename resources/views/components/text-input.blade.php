@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-main focus:ring-main rounded-md shadow-sm']) }}>

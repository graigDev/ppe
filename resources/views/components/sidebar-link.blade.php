@props(['active'])

@php
$classes = ($active ?? false)
            ? 'bg-gray-100'
            : '';
@endphp

<a {{ $attributes->merge(['class' => $classes . ' hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 cursor-pointer']) }}>
    {{ $slot }}
</a>

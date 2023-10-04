@props(['disabled' => false])

<textarea
    x-data="{
        resize() {
            $el.style.height = '40px'
            $el.style.height = $el.scrollHeight != 0 ? ($el.scrollHeight + 5) + 'px' : '40px'
        }
    }"
    x-init="setInterval(() => { resize() }, 100)"
    @input="resize"

    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md text-sm resize-none ']) !!}
>{{ $slot }}</textarea>

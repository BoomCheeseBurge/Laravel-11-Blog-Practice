@props(['icon' => null])

<label 
    x-bind:for="$id('input')" 
    {{ $attributes->class(
        'flex items-center space-x-1 text-sm/6 block font-semibold'
    ) }}
>
    @if ($icon)
        <x-dynamic-component :component="'icon.'.$icon"></x-dynamic-component>
    @endif
    <span>{{ $slot }}</span>
</label>
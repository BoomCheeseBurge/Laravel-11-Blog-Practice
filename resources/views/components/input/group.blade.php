@props(['label', 'error' => null])

<div
    x-data
    x-id="['input']"
    {{ $attributes }}
>
    {{ $slot }}
</div>

@if($error)
<x-messages.error :message="$error"></x-messages.error>
@endif

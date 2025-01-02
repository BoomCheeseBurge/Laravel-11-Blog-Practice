@aware(['error'])
@props(['error'])

<input type="text" 
x-bind:id="$id('input')"
{{ $attributes->class([
    'w-full block px-3.5 py-2 rounded-md shadow-sm placeholder:text-gray-400 ring-1 ring-gray-300 dark:ring-gray-600 sm:text-sm/6',
    'border-none focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-600' => !$error,
    'border-2 border-red-500 ring-offset-0 ring-0 focus:ring-0 outline-0' => $error
]) }}

{{ $attributes }}
>

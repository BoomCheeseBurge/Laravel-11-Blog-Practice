@props(['name'])

<div 
    x-data="{ value: false }"
    x-modelable="value"
    {{ $attributes }}
    class="h-6 flex items-center">
    <label class="inline-flex items-center cursor-pointer">
        <input name="{{ $name }}" x-model="value" type="checkbox" value="" class="peer sr-only">
        <span class="sr-only">Agree to policies</span>
        <div class="peer w-9 h-5 relative bg-gray-200 rounded-full after:content-[ dark:bg-gray-700 dark:peer-focus:ring-blue-800 peer-checked:after:border-white peer-checked:after:translate-x-full peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rtl:peer-checked:after:-translate-x-full''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
    </label>
</div>
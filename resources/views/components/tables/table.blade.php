{{-- Table Data START --}}
<table class="min-w-full">
    <x-tables.header {{ $attributes->filter(fn (string $value, string $key) => $key == 'id' || $key == 'actions') }} :headers="$headers"></x-tables.header>
    <tbody class="bg-white dark:bg-slate-700">
        {{-- Table Body START --}}
        {{ $slot }}
        {{-- Table Body END --}}
    </tbody>
</table>
{{-- Table Data END --}}

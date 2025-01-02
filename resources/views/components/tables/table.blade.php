{{-- Table Data START --}}
<table class="table-sortable min-w-full table border-collapse">
    <x-tables.header {{ $attributes->filter(fn (string $value, string $key) => $key == 'id' || $key == 'actions') }} :headers="$headers"></x-tables.header>
    <tbody class="bg-white dark:bg-slate-700 max-md:bg-slate-100 max-md:dark:bg-slate-800">
        {{-- Table Body START --}}
        {{ $slot }}
        {{-- Table Body END --}}
    </tbody>
</table>
{{-- Table Data END --}}

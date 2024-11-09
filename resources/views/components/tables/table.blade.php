{{-- Table Data START --}}
<table class="min-w-full">
    <thead class="bg-gray-2 dark:bg-slate-700">
        <tr>
            @if ($attributes->has('id'))
            <th class="text-primary-600 px-6 py-5 text-sm tracking-wider leading-4 text-left border-b-2 border-gray-300 dark:text-white dark:border-slate-600 md:text-base">No</th>
            @endif
            @foreach ($headers as $header)
            <th class="text-primary-600 px-6 py-5 text-sm tracking-wider leading-4 text-left border-b-2 border-gray-300 dark:text-white dark:border-slate-600 md:text-base">{{ $header }}</th>
            @endforeach
            @if ($attributes->has('actions'))
            <th class="px-6 py-5 border-b-2 border-gray-300 dark:text-white dark:border-slate-600"></th>
            @endif
        </tr>
    </thead>
    <tbody class="bg-white dark:bg-slate-700">
        {{-- Table Body START --}}
        {{ $slot }}
        {{-- Table Body END --}}
    </tbody>
</table>
{{-- Table Data END --}}

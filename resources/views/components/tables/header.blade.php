<thead class="bg-gray-2 dark:bg-slate-700">
    <tr>
        {{-- Header ID/No. START --}}
        @if ($attributes->has('id'))
        <th class="text-primary-600 px-6 py-5 text-sm tracking-wider leading-4 text-left border-b-2 border-gray-300 dark:text-white dark:border-slate-600 md:text-base">No</th>
        @endif
        {{-- Header ID/No. END --}}

        {{-- Header Data START --}}
        @foreach ($headers as $key => $header)
            <th class="text-primary-600 px-6 py-5 text-sm tracking-wider leading-4 text-left border-b-2 border-gray-300 dark:text-white dark:border-slate-600 md:text-base">{{ $header }}</th>
        @endforeach
        {{-- Header Data END --}}

        {{-- Header Actions START --}}
        @if ($attributes->has('actions'))
        <th class="px-6 py-5 border-b-2 border-gray-300 dark:text-white dark:border-slate-600"></th>
        @endif
        {{-- Header Actions END --}}
    </tr>
</thead>

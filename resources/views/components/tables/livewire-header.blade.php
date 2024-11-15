<thead class="bg-gray-2 dark:bg-slate-700">
    <tr>
        {{-- Bulk Action Checkbox START --}}
        <th x-show="toggleColumn('Bulk')" class="text-primary-600 px-6 py-5 text-sm tracking-wider leading-4 text-left border-b-2 border-gray-300 group dark:text-white dark:border-slate-600 md:text-base">
            <div class="flex items-center pt-2">
                <input type="checkbox" wire:key="{{ $currentPage }}" x-model="selectCurrentPage">
            </div>
        </th>
        {{-- Bulk Action Checkbox END --}}

        {{-- Header ID/No. START --}}
        @if ($attributes->has('id'))
        <th x-show="toggleColumn('Number')" class="text-primary-600 px-6 py-5 text-sm tracking-wider leading-4 text-left border-b-2 border-gray-300 group dark:text-white dark:border-slate-600 md:text-base">
            <div class="flex items-center pt-2">
                <div>
                    No
                </div>
                <div class="w-1 inline-flex justify-center ml-5">
                    <button wire:click="sortBy('id')"
                            type="button" class="hidden text-slate-600 group-hover:block hover:text-slate-400
                            @if ($sortHeader === 'id' && $sortDirection === 'asc')
                            rotate-180
                            @endif">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
                        </svg>
                    </button>
                </div>
            </div>
        </th>
        @endif
        {{-- Header ID/No. END --}}

        {{-- Header Data START --}}
        @foreach (array_filter($headers, function (string $value) {
                    return ($value != 'Bulk') && ($value != 'Number') && ($value != 'Action');
                }) as $header)
            <th x-show="toggleColumn('{{ $header }}')" class="text-primary-600 px-6 py-5 text-sm tracking-wider leading-4 text-left border-b-2 border-gray-300 dark:text-white dark:border-slate-600 md:text-base">
                <div class="flex justify-between items-center pt-2">
                    <div>
                        {{ $header }}
                    </div>
                    <button type="button" wire:click="sortBy('{{ strtolower($header) }}')">
                        <svg class="{{ ($sortHeader === strtolower($header) && $sortDirection === 'asc') ? 'text-slate-500 dark:text-white' : 'text-slate-300 dark:text-slate-400' }} h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v13m0-13 4 4m-4-4-4 4"/>
                        </svg>
                        <svg class="{{ ($sortHeader === strtolower($header) && $sortDirection === 'desc') ? 'text-slate-500 dark:text-white' : 'text-slate-300 dark:text-slate-400' }} h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 14-4-4m4 4 4-4"/>
                        </svg>
                    </button>
                </div>
            </th>
        @endforeach
        {{-- Header Data END --}}

        {{-- Header Actions START --}}
        @if ($attributes->has('actions'))
        <th x-show="toggleColumn('Action')" class="px-6 py-5 border-b-2 border-gray-300 dark:text-white dark:border-slate-600"></th>
        @endif
        {{-- Header Actions END --}}
    </tr>
</thead>

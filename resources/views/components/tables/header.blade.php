<thead class="bg-slate-700 dark:bg-indigo-100">
    <tr>
        {{-- Header ID/No. START --}}
        @if ($attributes->has('id'))
        <th x-show="toggleColumn('No')" class="p-5 text-sm tracking-wider leading-4 text-center text-white border-b-2 border-slate-600 group dark:text-primary-600 dark:border-gray-300 md:text-base">
            <div class="flex items-center">
                No
                {{-- Sort Button START --}}
                <div class="sort-trigger hidden ml-6 space-y-1.5 text-slate-500 dark:text-gray-400 group-hover:cursor-pointer">
                    <svg class="w-3.5 h-3.5 dark:group-[.th-sort-asc]:text-primary-700 group-[.th-sort-asc]:text-teal-400" fill="currentColor" viewBox="6.011 1.973 11.978 8.031" xmlns="http://www.w3.org/2000/svg">
                        <path d="M 11.232 2.36 C 11.605 1.912 12.272 1.882 12.684 2.27 L 12.768 2.36 L 17.768 8.36 C 18.286 8.982 17.888 9.911 17.113 9.994 L 17 10 L 7 10 C 6.191 10 5.732 9.099 6.164 8.451 L 6.232 8.36 L 11.232 2.36 Z"></path>
                    </svg>
                        <svg class="w-3.5 h-3.5 dark:group-[.th-sort-desc]:text-primary-700 group-[.th-sort-desc]:text-teal-400" fill="currentColor" viewBox="5.966 13.996 12.068 8.077" xmlns="http://www.w3.org/2000/svg">
                            <path d="M 17 14 C 17.809 14 18.268 14.901 17.836 15.549 L 17.768 15.64 L 12.768 21.64 C 12.395 22.088 11.728 22.118 11.316 21.73 L 11.232 21.64 L 6.232 15.64 C 5.714 15.018 6.112 14.089 6.887 14.006 L 7 14 L 17 14 Z"></path>
                        </svg>
                </div>
                {{-- Sort Button END --}}
            </div>
        </th>
        @endif
        {{-- Header ID/No. END --}}

        {{-- Header Data START --}}
        @foreach (array_filter($headers, function (string $value) {
                    return ($value != 'No') && ($value != 'Action');
                }) as $header)
            <th x-show="toggleColumn('{{ $header }}')" class="border-x-[2px] border-x-primary-600/40 px-4 text-sm tracking-wider leading-4 text-left text-white border-b-2 border-b-slate-600 group dark:border-x-gray-400/40 dark:text-primary-600 dark:border-b-gray-300 md:text-base">
                <div class="flex justify-between items-center gap-10">
                    {{ $header }}
                    {{-- Sort Button START --}}
                    <div class="sort-trigger flex flex-col space-y-1.5 text-slate-500 dark:text-gray-400 group-hover:cursor-pointer">
                        <svg class="w-4 h-4 dark:group-[.th-sort-asc]:text-primary-700 group-[.th-sort-asc]:text-teal-400" fill="currentColor" viewBox="6.011 1.973 11.978 8.031" xmlns="http://www.w3.org/2000/svg">
                            <path d="M 11.232 2.36 C 11.605 1.912 12.272 1.882 12.684 2.27 L 12.768 2.36 L 17.768 8.36 C 18.286 8.982 17.888 9.911 17.113 9.994 L 17 10 L 7 10 C 6.191 10 5.732 9.099 6.164 8.451 L 6.232 8.36 L 11.232 2.36 Z"></path>
                        </svg>
                            <svg class="w-4 h-4 dark:group-[.th-sort-desc]:text-primary-700 group-[.th-sort-desc]:text-teal-400" fill="currentColor" viewBox="5.966 13.996 12.068 8.077" xmlns="http://www.w3.org/2000/svg">
                                <path d="M 17 14 C 17.809 14 18.268 14.901 17.836 15.549 L 17.768 15.64 L 12.768 21.64 C 12.395 22.088 11.728 22.118 11.316 21.73 L 11.232 21.64 L 6.232 15.64 C 5.714 15.018 6.112 14.089 6.887 14.006 L 7 14 L 17 14 Z"></path>
                            </svg>
                    </div>
                    {{-- Sort Button END --}}
                </div>
            </th>
        @endforeach
        {{-- Header Data END --}}

        {{-- Header Actions START --}}
        @if ($attributes->has('actions'))
        <th x-show="toggleColumn('Action')" class="border-b-2 border-b-slate-600 dark:border-b-gray-300">
            <div class="hidden">
                {{-- Sort Button START --}}
                <div class="sort-trigger ml-6 space-y-1.5 text-slate-500 dark:text-gray-400 group-hover:cursor-pointer">
                    <svg class="w-3.5 h-3.5 dark:group-[.th-sort-asc]:text-primary-700 group-[.th-sort-asc]:text-teal-400" fill="currentColor" viewBox="6.011 1.973 11.978 8.031" xmlns="http://www.w3.org/2000/svg">
                        <path d="M 11.232 2.36 C 11.605 1.912 12.272 1.882 12.684 2.27 L 12.768 2.36 L 17.768 8.36 C 18.286 8.982 17.888 9.911 17.113 9.994 L 17 10 L 7 10 C 6.191 10 5.732 9.099 6.164 8.451 L 6.232 8.36 L 11.232 2.36 Z"></path>
                    </svg>
                        <svg class="w-3.5 h-3.5 dark:group-[.th-sort-desc]:text-primary-700 group-[.th-sort-desc]:text-teal-400" fill="currentColor" viewBox="5.966 13.996 12.068 8.077" xmlns="http://www.w3.org/2000/svg">
                            <path d="M 17 14 C 17.809 14 18.268 14.901 17.836 15.549 L 17.768 15.64 L 12.768 21.64 C 12.395 22.088 11.728 22.118 11.316 21.73 L 11.232 21.64 L 6.232 15.64 C 5.714 15.018 6.112 14.089 6.887 14.006 L 7 14 L 17 14 Z"></path>
                        </svg>
                </div>
                {{-- Sort Button END --}}
            </div>
        </th>
        @endif
        {{-- Header Actions END --}}
    </tr>
</thead>

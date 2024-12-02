@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex justify-between items-center">
        <div class="flex flex-1 justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-slate-500 bg-white rounded-md border border-slate-300 cursor-default dark:text-slate-600 dark:bg-slate-800 dark:border-slate-600">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-slate-700 bg-white rounded-md border border-slate-300 ring-slate-300 transition duration-150 ease-in-out active:text-slate-700 active:bg-slate-100 dark:text-slate-300 dark:bg-slate-800 dark:border-slate-600 dark:active:text-slate-300 dark:active:bg-slate-700 dark:focus:border-blue-700 focus:border-blue-300 focus:outline-none focus:ring hover:text-slate-500">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium leading-5 text-slate-700 bg-white rounded-md border border-slate-300 ring-slate-300 transition duration-150 ease-in-out active:text-slate-700 active:bg-slate-100 dark:text-slate-300 dark:bg-slate-800 dark:border-slate-600 dark:active:text-slate-300 dark:active:bg-slate-700 dark:focus:border-blue-700 focus:border-blue-300 focus:outline-none focus:ring hover:text-slate-500">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium leading-5 text-slate-500 bg-white rounded-md border border-slate-300 cursor-default dark:text-slate-600 dark:bg-slate-800 dark:border-slate-600">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex sm:flex-1 sm:justify-between sm:items-center">
            <div>
                <p class="text-sm leading-5 text-slate-700 dark:text-slate-400">
                    {!! __('Viewing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex rounded-md shadow-sm rtl:flex-row-reverse">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium leading-5 text-slate-500 bg-white rounded-l-md border border-slate-300 cursor-default dark:bg-slate-800 dark:border-slate-600" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium leading-5 text-slate-500 bg-white rounded-l-md border border-slate-300 ring-slate-300 transition duration-150 ease-in-out active:text-slate-500 active:bg-slate-100 dark:bg-slate-800 dark:border-slate-600 dark:active:bg-slate-700 dark:focus:border-blue-800 focus:z-10 focus:border-blue-300 focus:outline-none focus:ring hover:text-slate-400" aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                <!--  Use three dots when current page is greater than 4  -->
                                @if ($paginator->currentPage() > 4 && $page === 2)
                                    <li class="-ml-px relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-slate-700 bg-white border border-slate-300 ring-slate-300 transition duration-150 ease-in-out active:text-slate-700 active:bg-slate-100 dark:text-slate-400 dark:bg-slate-800 dark:border-slate-600 dark:active:bg-slate-700 dark:focus:border-blue-800 dark:hover:text-slate-100 dark:hover:border-white focus:z-10 focus:border-blue-300 focus:outline-none focus:ring hover:border-primary-600 hover:text-primary-600 hover:font-semibold hover:scale-110"><span class="page-link">...</span></li>
                                @endif

                                <!--  Show active page else show the first and last two pages from current page  -->
                                @if ($page == $paginator->currentPage())
                                    <li class="-ml-px bg-primary-600 border-slate-00 relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-white border ring-slate-300 dark:text-boxdark-2 dark:bg-slate-100 dark:border-slate-600 focus:outline-none"><span class="page-link">{{ $page }}</span></li>
                                @elseif ($page === $paginator->currentPage() + 1 || $page === $paginator->currentPage() + 2 || $page === $paginator->currentPage() - 1 || $page === $paginator->currentPage() - 2 || $page === $paginator->lastPage() || $page === 1)
                                    <a class="page-link" href="{{ $url }}"><li class="-ml-px relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-slate-700 bg-white border border-slate-300 ring-slate-300 transition duration-150 ease-in-out active:text-slate-700 active:bg-slate-100 dark:text-slate-400 dark:bg-slate-800 dark:border-slate-600 dark:active:bg-slate-700 dark:focus:border-blue-800 dark:hover:text-slate-100 dark:hover:border-white focus:z-10 focus:border-blue-300 focus:outline-none focus:ring hover:border-primary-600 hover:text-primary-600 hover:font-semibold hover:scale-110">{{ $page }}</li></a>
                                @endif

                                <!--  Use three dots when current page is away from end  -->
                                @if ($paginator->currentPage() < $paginator->lastPage() - 3 && $page === $paginator->lastPage() - 1)
                                    <li class="-ml-px relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-slate-700 bg-white border border-slate-300 ring-slate-300 transition duration-150 ease-in-out dark:text-slate-400 dark:bg-slate-800 dark:border-slate-600 focus:outline-none"><span class="page-link">...</span></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="-ml-px relative inline-flex items-center px-2 py-2 text-sm font-medium leading-5 text-slate-500 bg-white rounded-r-md border border-slate-300 ring-slate-300 transition duration-150 ease-in-out active:text-slate-500 active:bg-slate-100 dark:bg-slate-800 dark:border-slate-600 dark:active:bg-slate-700 dark:focus:border-blue-800 focus:z-10 focus:border-blue-300 focus:outline-none focus:ring hover:text-slate-400" aria-label="{{ __('pagination.next') }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="-ml-px relative inline-flex items-center px-2 py-2 text-sm font-medium leading-5 text-slate-500 bg-white rounded-r-md border border-slate-300 cursor-default dark:bg-slate-800 dark:border-slate-600" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif

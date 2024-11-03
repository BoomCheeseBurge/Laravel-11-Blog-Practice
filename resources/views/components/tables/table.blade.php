<!-- component -->
<div class="-my-2 overflow-x-auto py-2 pr-10 lg:-mx-8 lg:px-8 sm:-mx-6 sm:px-6">
    <div class="w-full overflow-hidden inline-block px-12 py-6 align-middle bg-white rounded-tl-lg rounded-tr-lg shadow-md dark:bg-slate-600">
        <div class="flex justify-between">
            <div class="w-7/12 h-12 inline-flex px-2 bg-transparent rounded border lg:px-6">
                <div class="w-full h-full relative flex flex-wrap items-stretch mb-6">
                    <div class="flex">
                        <span class="whitespace-no-wrap flex items-center py-2 text-sm leading-normal text-gray-700 bg-transparent rounded rounded-r-none border border-r-0 border-none dark:text-white lg:px-3">
                            <svg width="18" height="18" class="w-4 lg:w-auto" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.11086 15.2217C12.0381 15.2217 15.2217 12.0381 15.2217 8.11086C15.2217 4.18364 12.0381 1 8.11086 1C4.18364 1 1 4.18364 1 8.11086C1 12.0381 4.18364 15.2217 8.11086 15.2217Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M16.9993 16.9993L13.1328 13.1328" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
                    <input type="text" class="flex-grow flex-shrink w-px relative flex-auto px-3 text-xs font-thin tracking-wide leading-normal text-gray-500 rounded rounded-l-none border border-l-0 border-none dark:placeholder-white dark:bg-slate-600 focus:outline-none lg:text-base" placeholder="Search">
                </div>
            </div>
        </div>
    </div>
    <div class="min-w-full overflow-y-auto px-8 pt-5 pb-10 align-middle bg-white rounded-br-lg rounded-bl-lg dark:bg-slate-800">
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
                @forelse ($posts as $post)
                <tr>
                    @if ($attributes->has('id'))
                    <td class="px-6 py-4 border-b border-gray-500">
                        <div class="flex items-center">
                            <div class="text-sm leading-5 text-gray-800 dark:text-white">{{ $loop->iteration }}</div>
                        </div>
                    </td>
                    @endif

                    @foreach ($columns as $name)
                    <td class="px-6 py-4 border-b border-gray-500">
                        @if ($name === 'category')
                        <span class="px-2.5 py-1 me-2 text-xs font-medium text-blue-800 whitespace-nowrap bg-{{ $post->category->color }}-100 rounded-full">{{ $post->category->name }}</span>
                        @elseif ($name === 'created_at')
                        <span class="text-sm leading-5 text-blue-900 dark:text-white">{{ $post->created_at->format('F j, Y') }}</span>
                        @else
                        <div class="text-sm leading-5 text-blue-900 dark:text-white">{{ $post[$name] }}</div>
                        @endif
                    </td>
                    @endforeach

                    @if ($attributes->has('actions'))
                    <td class="p-4 text-sm text-center whitespace-nowrap border-b border-gray-500">
                        <a data-tooltip-target="view-tooltip-{{ $loop->iteration }}" href="{{ route($route . '.show', ['post' => $post->slug]) }}" class="group">
                            <svg class="text-primary-500 z-[-1] w-6 h-6 absolute invisible opacity-0 transition-opacity duration-300 ease-in-out dark:text-white group-hover:static group-hover:visible group-hover:opacity-100 md:w-8 md:h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd"/>
                            </svg>
                            <svg class="text-primary-700 w-6 h-6 static visible block opacity-100 transition-opacity duration-300 ease-in-out dark:text-white group-hover:invinsible group-hover:z-[-1] group-hover:absolute group-hover:opacity-0 md:w-8 md:h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path stroke="#e1e2e3" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </a>
                        <div id="view-tooltip-{{ $loop->iteration }}" data-tooltip-style="light" role="tooltip" class="bg-primary-500 tooltip absolute invisible z-10 inline-block px-3 py-2 text-sm font-semibold text-white rounded-lg shadow-sm opacity-0 transition-opacity duration-300 dark:bg-gray-700">
                            View
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ count($headers) + 1 * (bool)$attributes->has('id') + 1 * (bool)$attributes->has('actions') }}" class="whitespace-no-wrap px-6 py-4 text-center border-b border-gray-500 lg:text-xl">
                        <div>No Records Found</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{-- Table Pagination START --}}
        <div class="mt-5">
            {{ $posts->links() }}
        </div>
        {{-- Table Pagination END --}}
    </div>
</div>

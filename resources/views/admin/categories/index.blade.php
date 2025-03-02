<x-layouts.dashboard-layout :page="$page" :title="$title">
    <!-- Breadcrumb Start -->
    <div
    class="flex flex-col gap-3 mb-6 sm:flex-row sm:justify-between sm:items-center"
    >
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            {{ $subTitle }}
        </h2>

        <nav>
            <ol class="flex items-center gap-2">
            <li>
                <div class="font-medium">{{ $title }} /</div>
            </li>
            <li class="text-primary-500 font-medium">Tables</li>
            </ol>
        </nav>
    </div>
    <!-- Breadcrumb End -->

    {{-- ------------------------------------ Successful Message ------------------------------------ --}}
    @if (session()->has('success'))
    <x-messages.dismissal-success :message="session('success')" class="mb-4"></x-messages.dismissal-success>
    @endif

    {{-- ------------------------------------ Fail Message ------------------------------------ --}}
    @if (session()->has('fail'))
    <x-messages.dismissal-error :message="session('fail')" class="mb-4"></x-messages.dismissal-error>
    @endif

    <!-- ====== Table Section Start -->
    <div x-data="{
            fileExist: '',
            columns: true,
            dropdownOpen: false,
            openDisplay: false,
            columns: @js($headers),
            displayedColumns: @js($headers),
            toggleColumn(column) {
                let result = this.displayedColumns.find(e => e.toLowerCase() === column.toLowerCase());

                return result != undefined;
            },
        }"
        class="flex flex-col gap-10">
        <div class="-my-2 overflow-x-auto py-2 pr-10 lg:-mx-8 lg:px-8 sm:-mx-6 sm:px-6">
        {{-- Table Toolbar START --}}
            <div class="bg-white/40 w-full flex flex-col justify-between px-6 py-6 space-y-8 align-middle rounded-tl-lg rounded-tr-lg shadow-md dark:bg-slate-600 md:flex-row md:px-12 md:space-y-0">
                <div class="w-full flex flex-col items-center gap-5 md:flex-row">
                    {{-- Table Search START --}}
                    <div class="w-full h-12 inline-flex px-2 bg-transparent rounded border lg:px-6 md:w-7/12">
                        <div class="w-full h-full relative flex flex-wrap items-stretch mb-6">
                            <div class="flex">
                                <span class="whitespace-no-wrap flex items-center py-2 text-sm leading-normal text-gray-700 bg-transparent rounded rounded-r-none border border-r-0 border-none dark:text-teal-400 lg:px-3">
                                    <svg width="18" height="18" class="w-4 lg:w-auto" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.11086 15.2217C12.0381 15.2217 15.2217 12.0381 15.2217 8.11086C15.2217 4.18364 12.0381 1 8.11086 1C4.18364 1 1 4.18364 1 8.11086C1 12.0381 4.18364 15.2217 8.11086 15.2217Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M16.9993 16.9993L13.1328 13.1328" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <form action="" method="get" class="flex-grow flex-shrink w-px relative flex-auto px-3">
                                <x-input.search placeholder="Search by name/color"></x-input.search>
                            </form>
                        </div>
                    </div>
                    {{-- Table Search END --}}

                    {{-- Table Show Per Page START --}}
                    <x-dropdown.perpage :perPage="$perPage"></x-dropdown.perpage>
                    {{-- Table Show Per Page END --}}
                </div>

                <div class="flex flex-col justify-center items-center md:flex-row md:space-x-10">
                    {{-- Show/Hide Table Columns START --}}
                    <div class="relative max-md:hidden">
                        <div>
                            <button data-tooltip-target="display-tooltip" data-tooltip-placement="top" x-on:click="dropdownOpen = !dropdownOpen" type="button" class="bg-primary-600 ring-primary-400 w-full inline-flex justify-center items-center gap-x-1.5 px-3 py-2 text-sm font-semibold text-white rounded-lg ring-1 ring-inset shadow-sm dark:text-gray-500 dark:bg-white dark:ring-gray-300 dark:hover:text-blue-500 dark:hover:bg-gray-50 focus:shadow-outline focus:outline-none hover:bg-primary-500 md:px-4" id="display-button" aria-expanded="true" aria-haspopup="true">
                                <svg class="w-6 h-6 hidden md:block" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M15 4H9v16h6V4Zm2 16h3a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-3v16ZM4 4h3v16H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z" clip-rule="evenodd"/>
                                </svg>
                                <span class="md:hidden">Display Columns</span>
                                <svg x-bind:class="dropdownOpen && 'rotate-180'" class="w-5 h-5 transition ease-in" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div id="display-tooltip" role="tooltip" class="tooltip absolute invisible z-10 hidden px-3 py-2 font-sans text-sm tracking-wider text-center text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 dark:text-slate-900 dark:bg-slate-100 md:inline-block">
                                Display Column
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>

                        <!--
                        Dropdown menu, show/hide based on menu state.

                        Entering: "transition ease-out duration-100"
                            From: "transform opacity-0 scale-95"
                            To: "transform opacity-100 scale-100"
                        Leaving: "transition ease-in duration-75"
                            From: "transform opacity-100 scale-100"
                            To: "transform opacity-0 scale-95"
                        -->
                        <div x-cloak x-show="dropdownOpen" x-on:click.outside="dropdownOpen = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="bg-boxdark-2 ring-black/5 w-40 absolute right-0 z-10 mt-1 font-medium rounded-md ring-1 shadow-lg origin-top-right dark:font-semibold dark:bg-white focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        <div class="py-1" role="none">
                            <!-- Active: "bg-gray-100 text-gray-900 outline-none", Not Active: "text-gray-700" -->
                            <template x-for="column in columns">
                                <label class="text-truncate flex justify-start items-center px-4 py-2 text-sm dark:hover:bg-gray-100 hover:bg-slate-700 hover:cursor-pointer" role="menuitem" tabindex="-1">
                                    <div class="mr-3 text-teal-500">
                                        <input type="checkbox" class="form-checkbox focus:shadow-outline focus:outline-none" x-model="displayedColumns" :value="column">
                                    </div>
                                    <div class="text-white select-none dark:text-gray-700" x-text="column"></div>
                                </label>
                            </template>
                        </div>
                        </div>
                    </div>
                    {{-- Show/Hide Table Columns END --}}

                    {{-- Table Create Button START --}}
                    <button id="createButton" type="button" data-modal-target="createModal" data-modal-toggle="createModal" data-tooltip-target="create-tooltip" class="px-2.5 py-1.5 text-sm font-medium text-white bg-blue-700 rounded-lg cursor-pointer dark:bg-blue-600 dark:focus:ring-blue-800 dark:hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 hover:bg-blue-800" onclick="createCat()">
                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                        </svg>
                        <div id="create-tooltip" role="tooltip" class="tooltip absolute invisible z-10 inline-block px-3 py-2 text-sm font-medium text-white bg-gray-700 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 dark:bg-primary-700">
                            Create Category
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </button>
                    {{-- Table Create Button END --}}
                </div>
            </div>
            {{-- Table Toolbar END --}}

            <div class="min-w-full px-8 pt-5 pb-10 align-middle bg-slate-100 rounded-br-lg rounded-bl-lg dark:bg-slate-800">

                {{-- Table Data START --}}
                <!-- This div is for the horizontal scrollbar on the table -->
                <div class="overflow-y-hidden overflow-x-scroll max-md:[&_td:not(:nth-child(2))]:hidden">
                    <x-tables.table id actions :headers="$headers">
                        @forelse ($categories as $category)
                        <tr class="max-md:[&>td:nth-child(2)]:after:content-downwardArrowIcon max-md:[&>td:nth-child(2)]:after:float-right max-md:[&>td:nth-child(2)]:after:border-2 max-md:[&>td:nth-child(2)]:after:border-primary-500 max-md:[&>td:nth-child(2)]:after:rounded-full max-md:[&>td:nth-child(2)]:after:bg-blue-600 max-md:[&>td:nth-child(2)]:after:w-7 max-md:[&>td:nth-child(2)]:after:h-7 max-md:[&>td:nth-child(2)]:after:cursor-pointer max-md:[&>td:nth-child(2)]:after:text-center max-md:[&>td:nth-child(2)]:after:text-white max-md:[&>td:nth-child(2)]:after:pt-0.5 md:[&>td:nth-child(2)]:pointer-events-none max-md:flex max-md:flex-col max-md:[&>td:nth-child(2)]:after:transition-transform max-md:[&>td:nth-child(2)]:border-t-[1px] max-md:[&>td:nth-child(2)]:border-primary-300 max-md:[&>td:nth-child(2)]:dark:border-slate-500 [&>td:not(last-child)]:p-4 md:[&>td]:border-b-2 md:[&>td]:border-gray-300 md:[&>td]:dark:border-gray-500 max-md:[&>td:nth-child(-n+2)]:dark:bg-slate-600 max-md:[&>td:nth-child(-n+2)]:bg-slate-200 max-md:[&>td:nth-child(-n+2)]:rounded-md max-md:mb-8">
                            {{-- Number Column START --}}
                            <td x-show="toggleColumn('No')" class="max-md:hidden">
                                <div class="flex justify-center">
                                    <div class="mx-auto text-sm leading-5 text-gray-800 dark:text-white">{{ $categories->firstItem() + $loop->index }}</div>
                                </div>
                            </td>
                            {{-- Number Column END --}}

                            {{-- Data Columns START --}}
                            @foreach (array_filter($columns, function (string $value) {
                                        return ($value != 'No') && ($value != 'Action');
                                    }) as $column)
                                @if ($column === 'name')
                                <td headers="Name" x-show="toggleColumn('{{ $column }}')" class="max-md:before:content-[attr(headers)':_'] max-md:before:font-semibold tracking-wider max-md:before:text-primary-600 max-md:before:dark:text-primary-400" onclick="showDescription(this)">
                                    <span class="text-sm leading-5 text-blue-900 dark:text-white">{{ $category[$column] }}</span>
                                </td>
                                @elseif ($column === 'created_at')
                                <td x-show="toggleColumn('Date Created')" class="max-md:before:content-[attr(headers)':_']">
                                    <span headers="Date Created" class="text-sm leading-5 text-blue-900 dark:text-white max-md:before:content-[attr(headers)':_'] max-md:before:font-semibold max-md:before:text-primary-400">{{ $category->created_at->format('F j, Y') }}</span>
                                </td>
                                @elseif ($column === 'color')
                                <td x-show="toggleColumn('Color')">
                                    <span headers="Color" class="flex flex-col items-center">
                                        <div class="w-7 h-7 bg-{{ $category->color }}-400 rounded-full hover:scale-150 transition"></div>
                                        <p class="text-sm text-black transition dark:text-white hover:scale-150">{{ $category->color }}</p>
                                    </span>
                                </td>
                                @else
                                <td x-show="toggleColumn('{{ $column }}')">
                                    <span headers="{{ ucfirst($column) }}" class="text-sm leading-5 text-blue-900 dark:text-white max-md:before:content-[attr(headers)':_'] max-md:before:font-semibold max-md:before:text-primary-400">{{ $category[$column] }}</span>
                                </td>
                                @endif
                            @endforeach
                            {{-- Data Columns END --}}

                            {{-- Action Column START --}}
                            <td x-show="toggleColumn('Action')">
                                <span class="flex justify-between items-center px-8 space-x-5 max-md:w-full">
                                    {{-- ================================================= SHOW BUTTON ================================================= --}}
                                    <a data-tooltip-target="view-tooltip-{{ $loop->iteration }}" href="{{ route('categories.show', ['category' => $category->slug]) }}" class="group">
                                        <svg class="text-primary-500 w-8 h-8 transition-opacity duration-300 ease-in-out dark:text-white group-hover:static group-hover:visible group-hover:opacity-100 md:z-[-1] md:w-8 md:h-8 md:absolute md:invisible md:opacity-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd"/>
                                        </svg>
                                        <svg class="text-primary-700 w-6 h-6 static hidden transition-opacity duration-300 ease-in-out dark:text-white group-hover:invinsible group-hover:z-[-1] group-hover:absolute group-hover:opacity-0 md:w-8 md:h-8 md:visible md:block md:opacity-100" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path stroke="#e1e2e3" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        </svg>
                                        <div id="view-tooltip-{{ $loop->iteration }}" data-tooltip-style="light" role="tooltip" class="bg-primary-500 tooltip absolute invisible z-10 inline-block px-3 py-2 text-sm font-semibold text-white rounded-lg shadow-sm opacity-0 transition-opacity duration-300 dark:bg-primary-700">
                                            View
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    </a>

                                    {{-- ================================================= EDIT BUTTON ================================================= --}}
                                    <button type="button" x-on:click="fileExist = '{{  $category->image ? Storage::disk('categories')->url($category->image) : '' }}'" data-tooltip-target="edit-tooltip-{{ $loop->iteration }}" data-modal-target="editModal" data-modal-toggle="editModal" class="relative flex flex-col items-center pb-1.5 pl-3 text-amber-600 group dark:text-amber-400" onclick="insertEdit('{{ $category->slug }}', '{{ $category->name }}', '{{ $category->color }}')">
                                        <svg class="h-4.5 w-4.5 group-hover:animate-sway" width="24" height="24" viewBox="5.796 0.9 9.204 9.384" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M 12.146 1.146 C 12.342 0.951 12.658 0.951 12.854 1.146 L 14.854 3.146 C 15.049 3.342 15.049 3.658 14.854 3.854 L 10.911 7.796 C 10.835 7.872 10.747 7.935 10.651 7.984 L 6.724 9.947 C 6.531 10.044 6.299 10.006 6.146 9.854 C 5.994 9.701 5.957 9.469 6.053 9.276 L 8.016 5.349 C 8.065 5.253 8.128 5.165 8.204 5.089 L 12.146 1.146 Z M 12.5 2.207 L 8.911 5.796 L 7.873 7.873 L 8.127 8.127 L 10.204 7.089 L 13.793 3.5 L 12.5 2.207 Z" fill="currentColor"></path>
                                        </svg>
                                        <svg class="w-6 h-6 absolute right-0.5" width="24" height="24" viewBox="1.999 1.999 12.011 12.001" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M 10 2 L 9 3 L 4.9 3 C 4.472 3 4.181 3 3.956 3.019 C 3.736 3.037 3.624 3.069 3.546 3.109 C 3.358 3.205 3.205 3.358 3.109 3.546 C 3.069 3.624 3.037 3.736 3.019 3.956 C 3 4.181 3 4.472 3 4.9 L 3 11.1 C 3 11.528 3 11.819 3.019 12.045 C 3.037 12.264 3.069 12.376 3.109 12.454 C 3.205 12.642 3.358 12.795 3.546 12.891 C 3.624 12.931 3.736 12.963 3.956 12.981 C 4.181 13 4.472 13 4.9 13 L 11.1 13 C 11.528 13 11.819 13 12.045 12.981 C 12.264 12.963 12.376 12.931 12.454 12.891 C 12.642 12.795 12.795 12.642 12.891 12.454 C 12.931 12.376 12.963 12.264 12.981 12.045 C 13 11.819 13 11.528 13 11.1 L 13 7 L 14 6 L 14 11.1 L 14 11.121 C 14 11.523 14 11.855 13.978 12.126 C 13.955 12.407 13.906 12.665 13.782 12.908 C 13.59 13.284 13.284 13.59 12.908 13.782 C 12.665 13.906 12.407 13.955 12.126 13.978 C 11.855 14 11.523 14 11.121 14 L 11.1 14 L 4.9 14 L 4.879 14 C 4.477 14 4.145 14 3.874 13.978 C 3.593 13.955 3.335 13.906 3.092 13.782 C 2.716 13.59 2.41 13.284 2.218 12.908 C 2.094 12.665 2.045 12.407 2.022 12.126 C 2 11.855 2 11.523 2 11.121 L 2 11.1 L 2 4.9 L 2 4.879 C 2 4.477 2 4.145 2.022 3.874 C 2.045 3.593 2.094 3.335 2.218 3.092 C 2.41 2.716 2.716 2.41 3.092 2.218 C 3.335 2.094 3.593 2.045 3.874 2.022 C 4.145 2 4.477 2 4.879 2 L 4.9 2 L 10 2 Z" fill="currentColor"></path>
                                        </svg>
                                        <div id="edit-tooltip-{{ $loop->iteration }}" data-tooltip-style="light" role="tooltip" class="tooltip absolute invisible z-10 inline-block px-3 py-2 text-sm font-semibold text-white bg-amber-400 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 dark:bg-amber-500">
                                            Edit
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    </button>

                                    {{-- ================================================= DELETE BUTTON ================================================= --}}
                                    <button data-modal-target="destroyModal" data-modal-toggle="destroyModal" data-tooltip-target="delete-tooltip-{{ $loop->iteration }}" type="button" class="pb-4.5 relative flex flex-col items-center text-rose-500 group dark:text-rose-300 focus:outline-none focus:ring-0" onclick="insertIdentifier('{{ $category->slug }}', 'categories', 'destroy')">
                                        <svg class="w-5 h-5 transition-transform group-hover:rotate-45 group-hover:translate-x-1" width="24" height="24" viewBox="0.016 0 26.039 10.05" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                            <title>trash</title><desc>Created with Sketch Beta.</desc><g id="trash-lid" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Icon-Set" transform="translate(-259.000000, -203.000000)" fill="currentColor"><path d="M 282 211 L 262 211 C 261.448 211 261 210.553 261 210 C 261 209.448 261.448 209 262 209 L 282 209 C 282.552 209 283 209.448 283 210 C 283 210.553 282.552 211 282 211 Z M 281 213 L 263 213 L 281 213 Z M 269 206 C 269 205.447 269.448 205 270 205 L 274 205 C 274.552 205 275 205.447 275 206 L 275 207 L 269 207 L 269 206 Z M 283 207 L 277 207 L 277 205 C 277 203.896 276.104 203 275 203 L 269 203 C 267.896 203 267 203.896 267 205 L 267 207 L 261 207 C 259.896 207 259 207.896 259 209 L 259 211 C 259 212.104 259.896 213 261 213 L 283 213 C 284.104 213 285 212.104 285 211 L 285 209 C 285 207.896 284.104 207 283 207 Z" id="trash-1"></path></g></g>
                                        </svg>
                                        <svg class="w-4 h-4 absolute top-4" width="24" height="24" viewBox="1.963 10.009 22.018 21.991" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                            <title>trash</title><desc>Created with Sketch Beta.</desc><g id="trash-bin" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Icon-Set" transform="translate(-259.000000, -203.000000)" fill="currentColor"><path d="M 281 231 C 281 232.104 280.104 233 279 233 L 265 233 C 263.896 233 263 232.104 263 231 L 263 213 L 281 213 L 281 231 Z M 283 213 C 284.104 213 259.896 213 261 213 L 261 231 C 261 233.209 262.791 235 265 235 L 279 235 C 281.209 235 283 233.209 283 231 L 283 213 Z M 272 231 C 272.552 231 273 230.553 273 230 L 273 218 C 273 217.448 272.552 217 272 217 C 271.448 217 271 217.448 271 218 L 271 230 C 271 230.553 271.448 231 272 231 Z M 267 231 C 267.552 231 268 230.553 268 230 L 268 218 C 268 217.448 267.552 217 267 217 C 266.448 217 266 217.448 266 218 L 266 230 C 266 230.553 266.448 231 267 231 Z M 277 231 C 277.552 231 278 230.553 278 230 L 278 218 C 278 217.448 277.552 217 277 217 C 276.448 217 276 217.448 276 218 L 276 230 C 276 230.553 276.448 231 277 231 Z" id="trash-2"></path></g></g>
                                        </svg>
                                        <div id="delete-tooltip-{{ $loop->iteration }}" data-tooltip-style="light" role="tooltip" class="tooltip absolute invisible z-10 inline-block px-3 py-2 text-sm font-semibold text-white bg-rose-500 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 dark:bg-rose-700">
                                            Delete
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    </button>
                                </span>
                            </td>
                            {{-- Action Column END --}}
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ count($headers) + 2 }}" class="whitespace-no-wrap px-6 py-4 text-center border-b border-gray-500 lg:text-xl">
                                <div>No Records Found</div>
                            </td>
                        </tr>
                        @endforelse
                    </x-tables.table>
                </div>
                {{-- Table Data END --}}

                {{-- ============================================================================================================================================================== --}}

                <!-- The modals are placed here since it is dependent on an AlpineJS data -->

                {{-- Create Modal START --}}
                <div id="createModal" tabindex="-1" aria-hidden="true" class="h-modal w-full overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 hidden justify-center items-center md:h-full md:inset-0">
                    <div class="w-full h-full p-4 md:max-w-[50rem] md:h-auto">
                        <!-- Modal content -->
                        <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-graydark sm:p-5">
                            <button type="button" class="ml-auto absolute top-2.5 right-2.5 inline-flex items-center p-1.5 text-sm text-neutral-400 bg-transparent rounded-lg dark:hover:text-red-500 dark:hover:bg-neutral-600 hover:text-graydark hover:bg-slate-2" data-modal-toggle="createModal">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <p class="mb-4 font-bold text-neutral-500 dark:text-slate-100">Create Category</p>
                            <hr>
                            <div class="flex flex-col items-center mt-3 space-x-4">
                                <form action="{{ route('categories.store') }}" method="post" id="create-form" enctype="multipart/form-data" class="w-full">
                                    @csrf
                                    <div class="flex flex-col justify-center items-center gap-5 mb-10 md:flex-row">
                                        <div class="w-full flex flex-col items-center">
                                            <div class="w-full relative">
                                                <label for="name" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Category Name</label>
                                                <input type="text" id="name" name="name" class="w-[100%] max-w-[20rem] py-2.5 text-sm text-slate-900 bg-slate-50 rounded-lg dark:placeholder-slate-400 dark:text-white dark:bg-slate-700
                                                @error('name')
                                                is-invalid
                                                @else
                                                is-valid
                                                @enderror" placeholder="Enter name here" value="{{ old('name') }}" autocomplete="off" autofocus required>
                                                <svg class="w-6 h-6 text-red-600
                                                    @error('name')
                                                    absolute top-9.5 right-0 mr-3
                                                    @else
                                                    hidden
                                                    @enderror" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>
                                            </div>
                                            @error('name')
                                            <x-messages.error :message="$message"></x-messages.error>
                                            @enderror
                                            <div class="w-full relative flex flex-col items-center mt-5">
                                                {{-- <label for="hs-color-input" class="block mb-2 text-sm font-medium">Color picker</label>
                                                <input type="color" class="w-14 h-10 block p-1 bg-white rounded-lg border border-slate-200 cursor-pointer disabled:opacity-50 disabled:pointer-events-none" id="hs-color-input" value="#2563eb" title="Choose your color"> --}}
                                                <label for="color" class="mb-2 text-sm font-medium text-slate-900 dark:text-white">Category Color</label>
                                                <div class="w-full flex justify-center">
                                                    <select id="color" name="color" class="max-w-[15rem] w-[100%] py-2.5 text-sm text-center text-slate-900 bg-slate-50 rounded-lg border border-slate-300 dark:placeholder-slate-400 dark:text-white dark:bg-slate-700 dark:border-slate-600 dark:focus:border-blue-500 dark:focus:ring-blue-500 focus:border-blue-500 focus:ring-blue-500">
                                                        <option value="default" selected disabled>Choose available color</option>
                                                        @foreach ($colors as $color)
                                                            @if (!in_array(Str::lower($color), $catColors))
                                                            <option value="{{ Str::lower($color) }}">{{ $color }} </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <span id="colorDisplay2" class="px-4.5 py-1.5 ml-4 rounded-md border-2 border-zinc-300"></span>
                                                    @error('color')
                                                    <x-messages.error :message="$message"></x-messages.error>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            {{-- Category Image Input START --}}
                                            <h3 class="mb-2 font-mono text-lg font-bold text-gray-900 dark:text-slate-100">Category Image</h3>
                                            @error('image')
                                            <x-messages.error :message="$message"></x-messages.error>
                                            @enderror
                                            <div x-data="imageData()" class="w-full max-w-2xl items-center p-4 text-center text-gray-900 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:text-gray-400 dark:bg-gray-800 dark:border-gray-400">
                                                <div x-show="previewUrl == ''">
                                                    <label for="image" class="cursor-pointer">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto w-8 h-8 mb-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                                        </svg>
                                                        <h5 class="mb-2 text-base font-bold tracking-tight text-slate-800 dark:text-gray-300">Upload Picture</h5>
                                                        <p class="text-xs font-normal md:px-6">Choose photo size should be less than <b class="text-slate-800 dark:text-gray-300">2mb</b></p>
                                                        <p class="text-xs font-normal md:px-6">and should be in <b class="text-slate-800 dark:text-gray-300">JPG, PNG, or GIF</b> format.</p>
                                                        <span id="filename" class="z-50 text-gray-500 bg-gray-200"></span>
                                                    </label>
                                                    <input id="image" name="image" type="file" accept="image/*" class="hidden" @change="updatePreview()" />
                                                </div>
                                                <div class="w-full space-y-5" x-show="previewUrl !== ''">
                                                    <img :src="previewUrl" alt="" class="h-[12rem] w-[20rem] mx-auto">
                                                    <div class="">
                                                        <button type="button" @click="clearPreview()" class="px-5 py-2.5 me-2 mb-2 text-sm font-medium text-center text-white bg-teal-600 rounded-full dark:font-semibold dark:text-teal-800 dark:bg-teal-400 dark:focus:ring-teal-500 dark:hover:bg-teal-600 focus:outline-none focus:ring-4 focus:ring-teal-500 hover:bg-teal-800">Choose Another</button>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Category Image Input END --}}
                                        </div>
                                    </div>
                                    <button type="submit" class="bg-primary-600 px-3 py-2 mr-10 text-sm font-medium text-center text-white rounded-lg dark:focus:ring-neutral-600 dark:hover:bg-primary-400 focus:ring-primary-300 focus:outline-none focus:ring-4 hover:bg-primary-500 md:px-5 md:py-3 md:text-base">
                                        Create
                                    </button>
                                    <button data-modal-toggle="createModal" type="button" class="px-3 py-2 text-sm font-medium text-slate-100 bg-red-700 rounded-lg dark:text-slate-2 dark:bg-red-600 dark:focus:ring-red-900 dark:hover:text-white dark:hover:bg-red-500 focus:z-10 focus:outline-none focus:ring-4 focus:ring-red-300 hover:text-white hover:bg-red-600 md:px-5 md:py-3 md:text-base">
                                        Cancel
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Create Modal END --}}

                {{-- Edit Modal START --}}
                <div id="editModal" tabindex="-1" aria-hidden="true" class="h-modal w-full overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 hidden justify-center items-center md:h-full md:inset-0">
                    <div class="w-full h-full p-4 md:max-w-[50rem] md:h-auto">
                        <!-- Modal content -->
                        <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-graydark sm:p-5">
                            <button type="button" class="ml-auto absolute top-2.5 right-2.5 inline-flex items-center p-1.5 text-sm text-neutral-400 bg-transparent rounded-lg dark:hover:text-red-500 dark:hover:bg-neutral-600 hover:text-graydark hover:bg-slate-2" data-modal-toggle="editModal">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <p class="mb-4 font-bold text-neutral-500 dark:text-slate-100">Edit Category</p>
                            <hr>
                            <div class="relative flex justify-center items-center mt-3 space-x-4">
                                <form action="#" method="POST" id="edit-form" enctype="multipart/form-data" class="w-full">
                                    @method('PUT')
                                    @csrf
                                    <div class="flex flex-col justify-center items-center gap-5 mb-10 md:flex-row">
                                        <div class="w-full flex flex-col items-center">
                                            <div>
                                                <label for="catName" class="block mb-2 text-sm font-medium text-slate-900 dark:text-white">Category Name</label>
                                                <input type="text" id="catName" name="catName" class="max-w-lg p-2.5 text-sm text-slate-900 bg-slate-50 rounded-lg dark:placeholder-slate-400 dark:text-white dark:bg-slate-700 dark:border-slate-600
                                                @error('catName')
                                                is-invalid
                                                @else
                                                is-valid
                                                @enderror" placeholder="Enter name here" value="{{ old('catName') }}" autocomplete="off" required>
                                                <svg class="w-6 h-6 text-red-600 dark:text-rose-500
                                                    @error('catName')
                                                    absolute bottom-0 top-9.5 right-21 mr-3
                                                    @else
                                                    hidden
                                                    @enderror" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                                </svg>
                                            </div>
                                            @error('catName')
                                            <x-messages.error :message="$message"></x-messages.error>
                                            @enderror
                                            <div class="relative flex flex-col items-center mt-5 mb-8">
                                                {{-- <label for="hs-color-input" class="block mb-2 text-sm font-medium">Color picker</label>
                                                <input type="color" class="w-14 h-10 block p-1 bg-white rounded-lg border border-slate-200 cursor-pointer disabled:opacity-50 disabled:pointer-events-none" id="hs-color-input" value="#2563eb" title="Choose your color"> --}}
                                                <label for="catColor" class="mb-2 text-sm font-medium text-slate-900 dark:text-white">Category Color</label>
                                                <div>
                                                    <select id="catColor" name="catColor" class="max-w-lg p-2.5 text-sm text-center text-slate-900 bg-slate-50 rounded-lg border border-slate-300 dark:placeholder-slate-400 dark:text-white dark:bg-slate-700 dark:border-slate-600 dark:focus:border-blue-500 dark:focus:ring-blue-500 focus:border-blue-500 focus:ring-blue-500">
                                                        @foreach ($colors as $color)
                                                            @if (!in_array(Str::lower($color), $catColors))
                                                            <option value="{{ Str::lower($color) }}">{{ $color }} </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <span id="colorDisplay" class="px-4 py-1.5 ml-4 rounded-md border-2 border-zinc-300"></span>
                                                    @error('catColor')
                                                    <x-messages.error :message="$message"></x-messages.error>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-full">
                                            {{-- Category Image Input START --}}
                                            <h3 class="mb-2 font-mono text-lg font-bold text-gray-900 dark:text-slate-100">Category Image</h3>
                                            @error('image')
                                            <x-messages.error :message="$message"></x-messages.error>
                                            @enderror
                                            <div x-data="catImageData()" class="w-full max-w-2xl items-center p-4 text-center text-gray-900 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:text-gray-400 dark:bg-gray-800 dark:border-gray-400">
                                                <div x-show="fileExist == ''">
                                                    <label for="catImage" class="cursor-pointer">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto w-8 h-8 mb-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                                        </svg>
                                                        <h5 class="mb-2 text-base font-bold tracking-tight text-slate-800 dark:text-gray-300">Upload Picture</h5>
                                                        <p class="text-xs font-normal md:px-6">Choose photo size should be less than <b class="text-slate-800 dark:text-gray-300">2mb</b></p>
                                                        <p class="text-xs font-normal md:px-6">and should be in <b class="text-slate-800 dark:text-gray-300">JPG, PNG, or GIF</b> format.</p>
                                                        <span id="filename" class="z-50 text-gray-500 bg-gray-200"></span>
                                                    </label>
                                                    <input id="catImage" name="image" type="file" accept="image/*" class="hidden" @change="updatePreview()" />
                                                </div>
                                                <div class="w-full space-y-5" x-show="fileExist !== ''">
                                                    <img :src="fileExist" alt="" class="h-[12rem] w-[20rem] mx-auto">
                                                    <div class="">
                                                        <button type="button" @click="clearPreview()" class="px-5 py-2.5 me-2 mb-2 text-sm font-medium text-center text-white bg-teal-600 rounded-full dark:font-semibold dark:text-teal-800 dark:bg-teal-400 dark:focus:ring-teal-500 dark:hover:bg-teal-600 focus:outline-none focus:ring-4 focus:ring-teal-500 hover:bg-teal-800">Choose Another</button>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Category Image Input END --}}
                                        </div>
                                    </div>
                                    <button type="submit" class="bg-warning px-3 py-2 mr-10 text-sm font-medium text-center text-white rounded-lg dark:focus:ring-neutral-600 dark:hover:bg-amber-400 focus:ring-primary-300 focus:outline-none focus:ring-4 hover:bg-amber-500 md:px-5 md:py-3 md:text-base">
                                        Update
                                    </button>
                                    <button data-modal-toggle="editModal" type="button" class="px-3 py-2 text-sm font-medium text-slate-100 bg-red-700 rounded-lg dark:text-slate-2 dark:bg-red-600 dark:focus:ring-red-900 dark:hover:text-white dark:hover:bg-red-500 focus:z-10 focus:outline-none focus:ring-4 focus:ring-red-300 hover:text-white hover:bg-red-600 md:px-5 md:py-3 md:text-base">
                                        Cancel
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Edit Modal END --}}

                {{-- Delete Modal START --}}
                <div id="destroyModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="h-[calc(100%-1rem)] w-full max-h-full overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 hidden justify-center items-center md:inset-0">
                    <div class="w-full max-w-sm max-h-full relative p-4">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div class="flex justify-between items-center p-2 rounded-t border-b dark:border-gray-600 md:p-3">
                                <button type="button" class="ms-auto w-8 h-8 inline-flex justify-center items-center text-sm text-gray-400 bg-transparent rounded-lg dark:hover:text-white dark:hover:bg-gray-600 hover:text-gray-900 hover:bg-gray-200" data-modal-hide="destroyModal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="p-4 space-y-4 md:p-5">
                                <p class="text-base font-semibold leading-relaxed text-center text-gray-500 dark:text-gray-200">
                                    Perform this deletion?
                                </p>
                            </div>
                            <!-- Modal footer -->
                            <div class="flex justify-center items-center p-4 rounded-b border-t border-gray-200 dark:border-gray-600 md:p-5">
                                <form id="deletionModalForm" action="{{ route('categories.destroy', ['category' => ' ']) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button data-modal-hide="destroyModal" type="submit" class="px-5 py-2.5 text-sm font-semibold text-center text-white bg-blue-700 rounded-lg border border-blue-200 dark:bg-blue-800 dark:border-blue-600 dark:focus:ring-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-100 hover:bg-blue-800">
                                        Confirm
                                    </button>
                                </form>
                                <button data-modal-hide="destroyModal" type="button" class="px-5 py-2.5 ms-3 text-sm font-semibold text-slate-200 bg-rose-700 rounded-lg border border-rose-200 dark:text-slate-300 dark:bg-rose-800 dark:border-rose-600 dark:focus:ring-rose-700 dark:hover:text-white dark:hover:bg-rose-600 focus:z-10 focus:outline-none focus:ring-4 focus:ring-rose-100 hover:text-slate-100 hover:bg-rose-800">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ============================================================================================================================================================== --}}

                {{-- Table Pagination START --}}
                <div class="mt-5">
                    {{ $categories->links() }}
                </div>
                {{-- Table Pagination END --}}
            </div>
        </div>
    </div>
    <!-- ====== Table Section End -->

    @push('scripts')
    <script src="{{ asset('JS/default-table.js') }}"></script>
    <script src="{{ asset('JS/admin-category.js') }}"></script>
    @endpush
</x-layouts.dashboard-layout>

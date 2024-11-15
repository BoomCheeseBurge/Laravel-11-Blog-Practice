<div class="mx-auto max-w-screen-2xl p-4 2xl:p-10 md:p-6">
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
    <x-messages.dismissal-error errorID="1" :message="session('fail')" class="mb-4"></x-messages.dismissal-error>
    @endif

    {{-- Table Section START --}}
    <div x-init="
            $watch('selectCurrentPage', value => selectCurrentPageUpdated(value));
            $watch
        "
        x-data="{
            checked:  $wire.entangle('checked').live,
            selectAll:  $wire.entangle('selectAll').live,
            selectCurrentPage:  $wire.entangle('selectCurrentPage').live,
            dropdownOpen: false,
            bulkOpen: false,
            openDisplay: false,
            columns: $wire.columns,
            displayedColumns: @js($columns),
            async selectCurrentPageUpdated(value) {
                if(value)
                {
                    this.checked = await @this.getCurrentPageRecords();

                } else {
                    this.checked = [];
                    this.selectAll = false;
                }
            },
            async selectAllUpdated() {
                this.selectAll = true;
                this.checked = await @this.getAllRecords();
            },
            checkSelected() {
                if (this.checked.length + 1 == $wire.perPage) {
                    this.selectCurrentPage = true;
                }
            },
            toggleColumn(column) {
                let result = this.displayedColumns.find(e => e.toLowerCase() === column.toLowerCase());

                return result != undefined;
            },
        }"
        class="flex flex-col gap-10">
        <div class="overflow-x-auto py-2">

            {{-- Table Menubar START --}}
            <div id="tableMenu" class="w-full flex flex-col justify-between items-center px-4 py-6 space-y-12 bg-white rounded-tl-lg rounded-tr-lg shadow-md dark:bg-slate-600 md:flex-row md:px-12 md:space-x-10 md:space-y-0">

                {{-- -------------------------------------------- Left Section Menubar START --}}
                <div class="w-full flex flex-col items-center space-y-10 md:flex-row md:space-x-5 md:space-y-0">
                        {{-- Bulk Action START --}}
                        <div class="w-full relative md:w-fit">
                            {{-- Bulk Delete Info START --}}
                            <div x-cloak x-show="selectAll && selectCurrentPage" class="mb-2 text-xs lg:text-sm">
                                All <span x-text="checked.length"></span> records are currently selected
                            </div>
                            <div x-cloak x-show="!selectAll && selectCurrentPage" class="mb-2 text-xs lg:text-sm">
                                Selected <span x-text="checked.length"></span> records. Select all records instead?
                                <button x-on:click="selectAllUpdated" type="button" class="underline hover:no-underline">Select All</button>
                            </div>
                            <div x-cloak x-show="(checked.length > 1) && (selectAll == false) && (selectCurrentPage == false)" class="mb-2 text-sm font-bold dark:text-whiter dark:font-medium lg:text-base">
                                Selected records: <span x-text="checked.length"></span>
                            </div>
                            {{-- Bulk Delete Info END --}}

                            {{-- Bulk Button START --}}
                            <div>
                                <button data-tooltip-target="bulk-tooltip" data-tooltip-placement="top" x-on:click="bulkOpen = !bulkOpen" type="button" x-bind:class=" checked.length > 1 ? 'opacity-100 dark:hover:text-blue-500 ' : 'opacity-50'" class="bg-primary-600 ring-primary-400 w-full inline-flex justify-center items-center gap-x-1.5 px-3 py-2 text-sm font-semibold text-white rounded-lg ring-1 ring-inset shadow-sm dark:text-gray-500 dark:bg-white dark:ring-gray-300 dark:hover:bg-gray-50 focus:shadow-outline focus:outline-none md:w-fit" id="bulk-button" aria-expanded="true" aria-haspopup="true" :disabled="(checked.length > 1) ? false : true">
                                    <svg class="w-6 h-6 hidden md:block" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M5.005 10.19a1 1 0 0 1 1 1v.233l5.998 3.464L18 11.423v-.232a1 1 0 1 1 2 0V12a1 1 0 0 1-.5.866l-6.997 4.042a1 1 0 0 1-1 0l-6.998-4.042a1 1 0 0 1-.5-.866v-.81a1 1 0 0 1 1-1ZM5 15.15a1 1 0 0 1 1 1v.232l5.997 3.464 5.998-3.464v-.232a1 1 0 1 1 2 0v.81a1 1 0 0 1-.5.865l-6.998 4.042a1 1 0 0 1-1 0L4.5 17.824a1 1 0 0 1-.5-.866v-.81a1 1 0 0 1 1-1Z" clip-rule="evenodd"/>
                                        <path d="M12.503 2.134a1 1 0 0 0-1 0L4.501 6.17A1 1 0 0 0 4.5 7.902l7.002 4.047a1 1 0 0 0 1 0l6.998-4.04a1 1 0 0 0 0-1.732l-6.997-4.042Z"/>
                                    </svg>
                                    <span class="md:hidden">Bulk Action</span>
                                    <svg x-bind:class="bulkOpen && 'rotate-180'" class="w-5 h-5 transition ease-in" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                    </svg>
                                    </svg>
                                </button>
                                <div id="bulk-tooltip" role="tooltip" class="tooltip absolute invisible z-10 hidden px-3 py-2 font-sans text-sm tracking-wider text-center text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 dark:text-slate-900 dark:bg-slate-100 md:inline-block">
                                        Bulk Action
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </div>
                            {{-- Bulk Button END --}}

                            {{-- Bulk Dropdown START --}}
                            <div x-cloak x-show="bulkOpen" x-on:hide-bulk.window="bulkOpen = false" x-on:click.outside="bulkOpen = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="bg-boxdark-2 ring-black/5 absolute right-0 left-0 z-10 flex flex-col items-center mt-2 rounded-md ring-1 shadow-lg dark:bg-white focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                <div class="w-full flex flex-col items-center px-3 py-2 space-y-4 md:space-y-2" role="none">
                                    <!-- Active: "bg-gray-100 text-gray-900 outline-none", Not Active: "text-gray-700" -->

                                    {{-- Bulk Deletion START --}}
                                    <button x-cloak type="button" x-on:click="$dispatch('show-modal', { name: 'deleteSelectedModal' })"
                                            class="w-full px-5 py-2.5 text-base font-medium text-white bg-red-600 rounded-lg dark:bg-red-600 dark:focus:ring-red-900 dark:hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 hover:bg-red-700 lg:text-sm lg:font-semibold">
                                            Bulk Delete
                                    </button>
                                    <x-modals.modal name="deleteSelectedModal" height="max-h-40" width="max-w-xs">
                                        @slot('body')
                                        Are you sure?
                                        @endslot
                                        @slot('footer')
                                        <button wire:click="deleteSelected" x-on:click="show = false" type="button" class="px-5 py-2.5 me-2 text-sm font-medium text-white bg-red-700 rounded-lg dark:bg-red-600 dark:focus:ring-red-900 dark:hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 hover:bg-red-800">Confirm</button>
                                        <button x-on:click="show = false" type="button" class="px-5 py-2.5 text-sm font-medium text-white bg-slate-800 rounded-lg border border-slate-600 dark:text-slate-900 dark:bg-white dark:border-slate-300 dark:focus:outline-none dark:focus:ring-slate-100 dark:hover:bg-slate-100 dark:hover:border-slate-600 focus:ring-4 focus:ring-slate-700 hover:bg-slate-700">Cancel</button>
                                        @endslot
                                    </x-modals.modal>
                                    {{-- Bulk Deletion END --}}

                                    {{-- Bulk Edit START --}}
                                    <button x-cloak type="button" x-on:click="$dispatch('show-modal', { name: 'editSelectedModal' })"
                                            class="w-full px-5 py-2.5 text-base font-medium text-white bg-amber-600 rounded-lg dark:bg-amber-600 dark:focus:ring-amber-900 dark:hover:bg-amber-700 focus:outline-none focus:ring-4 focus:ring-amber-300 hover:bg-amber-700 lg:text-sm lg:font-semibold">
                                            Bulk Edit
                                    </button>
                                    <x-modals.modal name="editSelectedModal" height="h-fit" width="max-w-sm">
                                        @slot('body')
                                        <label for="countries" class="block mb-3 text-sm font-medium text-gray-900 dark:text-white">Choose new category</label>
                                        <select id="countries" wire:model.live="selectedCategory" class="w-full block p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 dark:placeholder-gray-400 dark:text-white dark:bg-gray-700 dark:border-gray-600 dark:focus:border-blue-500 dark:focus:ring-blue-500 focus:border-blue-500 focus:ring-blue-500">
                                            <option selected value="null" disabled>Choose a category</option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @endslot
                                        @slot('footer')
                                        <div class="space-x-3">
                                            <button wire:click="editSelected" x-on:click="show = false" type="button" class="px-5 py-2.5 me-2 text-sm font-medium text-white bg-sky-800 rounded-lg dark:bg-sky-600 dark:focus:ring-sky-900 dark:hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-300 hover:bg-sky-700">Update</button>
                                            <button x-on:click="show = false" type="button" class="px-5 py-2.5 text-sm font-medium text-white bg-red-800 rounded-lg border border-rose-600 dark:text-slate-900 dark:bg-red-500 dark:border-red-400 dark:focus:outline-none dark:focus:ring-red-500 dark:hover:bg-red-400 dark:hover:border-rose-600 focus:ring-4 focus:ring-red-700 hover:bg-red-700">Cancel</button>
                                        </div>
                                        @endslot
                                    </x-modals.modal>
                                    {{-- Bulk Edit END --}}
                                </div>
                            </div>
                            {{-- Bulk Dropdown END --}}
                        </div>
                        {{-- Bulk Action END --}}


                        {{-- Table Search START --}}
                        <div class="w-full h-12 px-2 bg-transparent rounded border lg:px-6 md:w-10/12">
                            <div class="w-full h-full relative flex flex-wrap items-stretch">
                                <div class="flex">
                                    <span class="whitespace-no-wrap flex items-center py-2 text-sm leading-normal text-gray-700 bg-transparent rounded rounded-r-none border border-r-0 border-none dark:text-emerald-300 lg:px-3">
                                        <svg width="18" height="18" class="w-4 lg:w-auto" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.11086 15.2217C12.0381 15.2217 15.2217 12.0381 15.2217 8.11086C15.2217 4.18364 12.0381 1 8.11086 1C4.18364 1 1 4.18364 1 8.11086C1 12.0381 4.18364 15.2217 8.11086 15.2217Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M16.9993 16.9993L13.1328 13.1328" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </div>
                                <input wire:model.live="search" type="text" class="flex-grow flex-shrink w-px relative flex-auto px-3 text-xs font-thin tracking-wide leading-normal text-gray-500 rounded rounded-l-none border border-l-0 border-none dark:placeholder-emerald-300 dark:text-slate-100 dark:bg-slate-600 dark:focus:ring-teal-400 focus:outline-none lg:text-base" placeholder="Search">
                            </div>
                        </div>
                        {{-- Table Search END --}}

                        {{-- Table Show Per Page START --}}
                        <div class="w-full flex flex-col justify-center space-y-3 text-slate-900 dark:text-white md:max-w-29 md:max-h-10 md:flex-row md:space-x-2 md:space-y-0">
                            <span class="text-sm">Per Page:</span>
                            <select wire:model.live="perPage" class="w-full border-t-0 border-r-0 border-b-2 border-l-0 border-b-slate-700 dark:bg-slate-700 focus:ring-0">
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                            </select>
                        </div>
                        {{-- Table Show Per Page END --}}
                </div>
                {{-- -------------------------------------------- Left Section Menubar END --}}

                {{-- -------------------------------------------- Right Section Menubar START --}}
                <div class="flex items-center md:space-y-0">
                    {{-- Show/Hide Table Columns START --}}
                    <div class="relative">
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
                                <label x-on:click="dropdownOpen = !dropdownOpen; printOut();"
                                    class="text-truncate flex justify-start items-center px-4 py-2 text-sm dark:hover:bg-gray-100 hover:bg-slate-700 hover:cursor-pointer" role="menuitem" tabindex="-1">
                                    <div class="mr-3 text-teal-600">
                                        <input type="checkbox" class="form-checkbox focus:shadow-outline focus:outline-none" x-model="displayedColumns" :value="column">
                                    </div>
                                    <div class="text-white select-none dark:text-gray-700" x-text="column"></div>
                                </label>
                            </template>
                          </div>
                        </div>
                    </div>
                    {{-- Show/Hide Table Columns END --}}
                </div>
                {{-- -------------------------------------------- Right Section Menubar END --}}

            </div>
            {{-- Table Menubar END --}}

            {{-- Table Records START --}}
            <div class="min-w-full overflow-y-auto z-10 px-5 pt-5 pb-10 align-middle bg-white rounded-br-lg rounded-bl-lg dark:bg-slate-800">

                {{-- Table Data START --}}
                <table class="min-w-full">
                    {{-- Table Header START --}}
                    <x-tables.livewire-header id actions :headers="$columns" :sortDirection="$sortDirection" :sortHeader="$sortHeader" :currentPage="$records->currentPage()"></x-tables.livewire-header>
                    {{-- Table Header END --}}

                    {{-- Table Body START --}}
                    <tbody class="bg-white dark:bg-slate-700">
                        @forelse ($records as $record)
                        <tr>
                            {{-- Checkbox Column START --}}
                            <td x-show="toggleColumn('Bulk')" class="px-6 py-4 border-b border-gray-500">
                                <input type="checkbox" wire:key="{{ $record->id }}" x-model="checked" x-on:click="checkSelected" value="{{ $record->id }}">
                            </td>
                            {{-- Checkbox Column END --}}

                            {{-- Number Column START --}}
                            <td x-show="toggleColumn('Number')" class="px-6 py-4 border-b border-gray-500">
                                <div class="flex items-center">
                                    <div class="text-sm leading-5 text-gray-800 dark:text-white">{{ $records->firstItem() + $loop->index }}</div>
                                </div>
                            </td>
                            {{-- Number Column END --}}

                            {{-- Data Columns START --}}
                            @foreach (array_filter($columns, function (string $value) {
                                        return ($value != 'Bulk') && ($value != 'Number') && ($value != 'Action');
                                    }) as $column)
                            <td x-show="toggleColumn('{{ $column }}')" class="m-auto px-6 py-4 text-center border-b border-gray-500">
                                @if ($column === 'Category')
                                <span class="px-2.5 py-1 text-xs font-medium text-blue-800 whitespace-nowrap bg-{{ $record->category_color }}-100 rounded-full">{{ $record->category_name }}</span>
                                @elseif ($column === 'Date Created')
                                <span class="text-sm leading-5 text-blue-900 whitespace-nowrap dark:text-white">{{ $record->created_at->format('F j, Y') }}</span>
                                @else
                                <div class="text-sm leading-5 text-blue-900 dark:text-white">{{ $record[strtolower($column)] }}</div>
                                @endif
                            </td>
                            @endforeach
                            {{-- Data Columns END --}}

                            {{-- Action Column START --}}
                            <td x-show="toggleColumn('Action')" class="text-sm border-b border-gray-500">
                                <div class="flex items-center px-8 space-x-6">
                                    {{-- ================================================= SHOW BUTTON ================================================= --}}
                                    <a data-tooltip-target="view-tooltip-{{ $loop->iteration }}" href="{{ route('posts.show', ['post' => $record->slug]) }}" class="group">
                                        <svg class="text-primary-500 z-[-1] w-6 h-6 absolute invisible opacity-0 transition-opacity duration-300 ease-in-out dark:text-white group-hover:static group-hover:visible group-hover:opacity-100 md:w-8 md:h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd"/>
                                        </svg>
                                        <svg class="text-primary-700 w-6 h-6 static visible block opacity-100 transition-opacity duration-300 ease-in-out dark:text-white group-hover:invinsible group-hover:z-[-1] group-hover:absolute group-hover:opacity-0 md:w-8 md:h-8" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path stroke="#e1e2e3" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                        </svg>
                                        <div id="view-tooltip-{{ $loop->iteration }}" data-tooltip-style="light" role="tooltip" class="bg-primary-500 tooltip absolute invisible z-10 inline-block px-3 py-2 text-sm font-semibold text-white rounded-lg shadow-sm opacity-0 transition-opacity duration-300 dark:bg-primary-700">
                                            View
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    </a>

                                    {{-- ================================================= EDIT BUTTON ================================================= --}}
                                    <a data-tooltip-target="edit-tooltip-{{ $loop->iteration }}" href="{{ route('posts.edit', ['post' => $record->slug]) }}" class="relative flex flex-col items-center pb-1.5 pl-3 text-amber-600 group dark:text-amber-400">
                                        <svg class="h-4.5 w-4.5 group-hover:animate-sway" width="24" height="24" viewBox="5.796 0.9 9.204 9.384" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M 12.146 1.146 C 12.342 0.951 12.658 0.951 12.854 1.146 L 14.854 3.146 C 15.049 3.342 15.049 3.658 14.854 3.854 L 10.911 7.796 C 10.835 7.872 10.747 7.935 10.651 7.984 L 6.724 9.947 C 6.531 10.044 6.299 10.006 6.146 9.854 C 5.994 9.701 5.957 9.469 6.053 9.276 L 8.016 5.349 C 8.065 5.253 8.128 5.165 8.204 5.089 L 12.146 1.146 Z M 12.5 2.207 L 8.911 5.796 L 7.873 7.873 L 8.127 8.127 L 10.204 7.089 L 13.793 3.5 L 12.5 2.207 Z" fill="currentColor"></path></svg>
                                        <svg class="w-6 h-6 absolute right-0.5" width="24" height="24" viewBox="1.999 1.999 12.011 12.001" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M 10 2 L 9 3 L 4.9 3 C 4.472 3 4.181 3 3.956 3.019 C 3.736 3.037 3.624 3.069 3.546 3.109 C 3.358 3.205 3.205 3.358 3.109 3.546 C 3.069 3.624 3.037 3.736 3.019 3.956 C 3 4.181 3 4.472 3 4.9 L 3 11.1 C 3 11.528 3 11.819 3.019 12.045 C 3.037 12.264 3.069 12.376 3.109 12.454 C 3.205 12.642 3.358 12.795 3.546 12.891 C 3.624 12.931 3.736 12.963 3.956 12.981 C 4.181 13 4.472 13 4.9 13 L 11.1 13 C 11.528 13 11.819 13 12.045 12.981 C 12.264 12.963 12.376 12.931 12.454 12.891 C 12.642 12.795 12.795 12.642 12.891 12.454 C 12.931 12.376 12.963 12.264 12.981 12.045 C 13 11.819 13 11.528 13 11.1 L 13 7 L 14 6 L 14 11.1 L 14 11.121 C 14 11.523 14 11.855 13.978 12.126 C 13.955 12.407 13.906 12.665 13.782 12.908 C 13.59 13.284 13.284 13.59 12.908 13.782 C 12.665 13.906 12.407 13.955 12.126 13.978 C 11.855 14 11.523 14 11.121 14 L 11.1 14 L 4.9 14 L 4.879 14 C 4.477 14 4.145 14 3.874 13.978 C 3.593 13.955 3.335 13.906 3.092 13.782 C 2.716 13.59 2.41 13.284 2.218 12.908 C 2.094 12.665 2.045 12.407 2.022 12.126 C 2 11.855 2 11.523 2 11.121 L 2 11.1 L 2 4.9 L 2 4.879 C 2 4.477 2 4.145 2.022 3.874 C 2.045 3.593 2.094 3.335 2.218 3.092 C 2.41 2.716 2.716 2.41 3.092 2.218 C 3.335 2.094 3.593 2.045 3.874 2.022 C 4.145 2 4.477 2 4.879 2 L 4.9 2 L 10 2 Z" fill="currentColor"></path>
                                        </svg>
                                        <div id="edit-tooltip-{{ $loop->iteration }}" data-tooltip-style="light" role="tooltip" class="tooltip absolute invisible z-10 inline-block px-3 py-2 text-sm font-semibold text-white bg-amber-400 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 dark:bg-amber-500">
                                            View
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    </a>

                                    {{-- ================================================= DELETE BUTTON ================================================= --}}
                                    <button wire:click="sendSlugToModal('{{ $record->slug }}')" x-on:click="$dispatch('open-modal', { name : 'singleDeleteModal' })" type="button" class="pb-4.5 relative flex flex-col items-center text-rose-500 group dark:text-rose-300 focus:outline-none focus:ring-0">
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
                                </div>
                            </td>
                            {{-- Action Column END --}}
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ count($columns) + 2 }}" class="whitespace-no-wrap px-6 py-4 text-center border-b border-gray-500 lg:text-xl">
                                <div>No Records Found</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    {{-- Table Body END --}}
                </table>
                {{-- Table Data END --}}

                {{-- Table Pagination START --}}
                <div class="mt-5">
                    {{ $records->links(data: ['scrollTo' => '#tableMenu']) }}
                </div>
                {{-- Table Pagination END --}}
            </div>
            {{-- Table Records END --}}
        </div>
    </div>
    {{-- Table Section END --}}

    {{-- ============================================================================================================================================================== --}}

    {{-- Delete Modal START --}}
    <x-modals.livewire-modal name="singleDeleteModal"  width="max-w-xs" height="h-fit">
        <x-slot:body>
            <div class="text-center">Delete this post?</div>
        </x-slot:body>
        <x-slot:footer>
            <div class="flex justify-center items-center space-x-5">
                <button wire:click="deleteSinglePost" x-on:click="$dispatch('close-modal')" type="button" class="px-5 py-2.5 me-2 text-sm font-medium text-white bg-red-700 rounded-lg dark:bg-red-600 dark:focus:ring-red-900 dark:hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 hover:bg-red-600">Confirm</button>
                <button x-on:click="$dispatch('close-modal')" type="button" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg border border-slate-600 dark:bg-blue-700 dark:border-slate-300 dark:focus:outline-none dark:focus:ring-slate-100 dark:hover:bg-blue-800 dark:hover:border-blue-400 focus:ring-4 focus:ring-slate-700 hover:bg-blue-500">Cancel</button>
            </div>
        </x-slot:footer>
    </x-modals.livewire-modal>
    {{-- Delete Modal END --}}

    @push('scripts')
    @endpush
</div>

<div>
    <!-- Breadcrumb Start -->
    <div class="flex flex-col gap-3 mb-6 sm:flex-row sm:justify-between sm:items-center">
        <div class="flex items-center gap-10">
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Posts
            </h2>
            <button type="button" wire:click="$toggle('archive')" class="text-sm underline hover:no-underline">
                @if ($this->archive)
                    View Active Posts
                @else
                    View Archived Posts
                @endif
            </button>
        </div>

        <nav class="flex">
            <ol class="flex items-center gap-2">
                <li>
                <a class="font-medium lg:text-xl md:text-lg" href="/dashboard/posts">Dashboard /</a>
                </li>
                <li class="text-primary-custom font-medium lg:text-xl md:text-lg">Tables</li>
            </ol>
        </nav>
    </div>
    <!-- Breadcrumb End -->

    {{-- Alert for Creating a Post --}}
    @if (session()->has('success'))
    <x-message.success-message class="w-full overflow-hidden relative mb-5">{{ session('success') }}</x-message.success-message>
    @endif

    {{--                                                                                        >>>>>> TABLE SECTION START <<<< --}}
    <div x-init="
                    $watch('selectAll', value => selectAllUpdated(value));
                    $watch('selectCurrentPage', value => selectCurrentPageUpdated(value));
                "
        x-data="{
                    checked: [],
                    selectAll: false,
                    selectCurrentPage: false,
                    async selectCurrentPageUpdated(value) {
                        if(value)
                        {
                            this.checked = await $wire.getCurrentPageRecords();
                            this.selectAll = false;
                            // console.log(this.checked);
                        } else {
                            this.checked = [];
                        }
                    },
                    async selectAllUpdated() {
                        this.selectAll = true;
                        this.checked = await $wire.getAllRecords();
                    },
                    deleteSelectedRecords() {
                        $wire.deleteSelected(this.checked);
                        this.selectCurrentPage = false;
                        this.checked = [];
                    },
                }"
        class="border-stroke shadow-default flex-col px-5 pt-6 pb-2.5 space-y-3 bg-white rounded-sm border dark:border-strokedark dark:bg-boxdark sm:px-7.5">
        {{-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> Table Actions START --}}
        <div class="flex justify-between items-center">
            {{-- ------------------------- Table LEFT SECTION START ------------------------- --}}
            <div>
                {{-- ------------------------- Table Selected Deletion START ------------------------- --}}
                <div x-cloak x-show="selectAll && selectCurrentPage" class="mb-2 text-xs lg:text-sm">
                    All <span x-text="checked.length"></span> records are currently selected
                </div>
                <div x-cloak x-show="!selectAll && selectCurrentPage" class="mb-2 text-xs lg:text-sm">
                    Selected <span x-text="checked.length"></span> records. Select all records instead? <button x-on:click="selectAllUpdated" type="button" class="underline hover:no-underline">Select All</button>
                </div>
                <button x-cloak type="button" x-bind:class=" checked.length > 0 ? 'opacity-100' : 'opacity-50'"  x-on:click="$dispatch('show-modal', { name: 'deleteSelectedModal' })"
                        class="px-5 py-2.5 me-2 mb-2 text-sm font-medium text-white bg-red-600 rounded-lg dark:bg-red-600 dark:focus:ring-red-900 dark:hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 hover:bg-red-700 md:text-base" :disabled="(checked.length > 0) ? false : true">
                        Bulk Delete
                </button>
                <x-modal name="deleteSelectedModal" height="max-h-40" width="max-w-xs">
                    @slot('body')
                    Are you sure?
                    @endslot
                    @slot('footer')
                    <button x-on:click="show = false; deleteSelectedRecords();" type="button" class="px-5 py-2.5 me-2 text-sm font-medium text-white bg-red-700 rounded-lg dark:bg-red-600 dark:focus:ring-red-900 dark:hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 hover:bg-red-800">Confirm</button>
                    <button x-on:click="show = false" type="button" class="px-5 py-2.5 text-sm font-medium text-white bg-slate-800 rounded-lg border border-slate-600 dark:text-slate-900 dark:bg-white dark:border-slate-300 dark:focus:outline-none dark:focus:ring-slate-100 dark:hover:bg-slate-100 dark:hover:border-slate-600 focus:ring-4 focus:ring-slate-700 hover:bg-slate-700">Cancel</button>
                    @endslot
                </x-modal>
                <span x-cloak x-show="checked.length > 0"> Selected records: <span x-text="checked.length"></span></span>
                {{-- ------------------------- Table Selected Deletion END ------------------------- --}}
            </div>
            {{-- ------------------------- Table LEFT SECTION END ------------------------- --}}
            {{-- ------------------------- Table RIGHT SECTION START ------------------------- --}}
            <div class="max-w-lg flex space-x-5">
                {{-- ------------------------- Table Show Per Page START ------------------------- --}}
                <div class="max-h-10 flex text-slate-900 dark:text-white">
                    <span class="w-12">Per Page:</span>
                    <select wire:model.live="perPage" class="border-t-0 border-r-0 border-b-2 border-l-0 border-b-slate-700 dark:bg-slate-700 focus:ring-0">
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                </div>
                {{-- ------------------------- Table Show Per Page END ------------------------- --}}
                {{-- ------------------------- Table Search START ------------------------- --}}
                <div>
                    <label for="search-title" class="-mr-1 flex-shrink-0 inline-flex items-center px-4 py-2.5 text-sm font-medium text-center text-slate-900 bg-slate-100 rounded-s-lg border border-slate-300 dark:text-white dark:bg-slate-700 dark:border-slate-600 dark:focus:ring-slate-700 dark:hover:bg-slate-600">Search by Title:</label>
                    <span>
                        <input wire:model.live="search" type="search" id="search-title" class="p-2.5 text-sm text-slate-900 bg-slate-50 rounded-e-lg border border-s-2 border-slate-300 border-s-slate-50 dark:placeholder-slate-400 dark:text-white dark:bg-slate-700 dark:border-slate-600 dark:border-s-slate-700 dark:focus:border-blue-500 focus:border-blue-500 focus:ring-blue-500" placeholder="Enter a keyword..." required autofocus/>
                    </span>
                </div>
                {{-- ------------------------- Table Search END ------------------------- --}}
            </div>
            {{-- ------------------------- Table RIGHT SECTION END ------------------------- --}}
        </div>
        {{-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> Table Actions END --}}
        <div class="max-w-full overflow-x-auto">
            <table id="post-table" class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <x-table.header wire:key="{{ $this->getPosts->currentPage() }}" checkbox x-model="selectCurrentPage"></x-table.header>
                        <x-table.header wire:click="sortBy('id')" sortable :direction="$sortHeader === 'id' ? $sortDirection : null" >No.</x-table.header>
                        @foreach ($headers as $header)
                        <th
                        class="min-w-[150px] py-3 font-medium text-center text-black dark:text-white"
                        >
                            <span class="inline-flex pt-2">
                                {{ $header }}
                            </span>
                            <button type="button" wire:click="sortBy('{{ strtolower($header) }}')" class="float-right">
                                <svg class="{{ ($this->sortHeader === strtolower($header) && $this->sortDirection === 'asc') ? 'text-slate-500 dark:text-white' : 'text-slate-300 dark:text-slate-400' }} h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v13m0-13 4 4m-4-4-4 4"/>
                                </svg>
                                <svg class="{{ ($this->sortHeader === strtolower($header) && $this->sortDirection === 'desc') ? 'text-slate-500 dark:text-white' : 'text-slate-300 dark:text-slate-400' }} h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 14-4-4m4 4 4-4"/>
                                </svg>
                            </button>
                        </th>
                        @endforeach
                        <th class="min-w-[150px] py-3 font-medium text-center text-black dark:text-white">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody wire:loading.class.delay.long="opacity-50">
                    @forelse ($this->getPosts as $post)
                    <tr>
                        <x-table.td wire:key="{{ $post->id }}" checkbox x-model="checked" :value="$post->id"></x-table>
                        <x-table.td>
                            <p class="font-medium text-black dark:text-white">{{ ($this->getPosts->currentPage() - 1)  * $this->getPosts->perPage() + $loop->iteration }}</p>
                        </x-table.td>
                        <x-table.td>
                            <p class="text-black dark:text-white">{{ $post->title }}</p>
                        </x-table.td>
                        <x-table.td>
                            <p class="text-black dark:text-white">{{ $post->category_name }}</p>
                        </x-table.td>
                        <x-table.td>
                            <p class="text-black dark:text-white">{{ $post->author->fullname }}</p>
                        </x-table.td>
                        <x-table.td>
                            <p
                            class="bg-opacity-10 bg-warning text-warning inline-flex px-3 py-1 text-sm font-medium rounded-full"
                            >Pending
                            </p>
                        </x-table.td>
                        <td class="flex justify-center py-5">
                            <div class="flex items-center space-x-3.5">
                                @if ($post->trashed())
                                <button id="restoreButton" data-modal-target="restoreModal" data-modal-toggle="restoreModal" class="dark:hover:text-white hover:text-primary-custom hover:transition hover:duration-300 hover:scale-125" onclick="insertSlug('{{ $post->slug }}', 'posts', 'restore')">
                                    <svg
                                    class="w-6 fill-current"
                                    viewBox="0 0 18 18"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                        d="M13.7535 2.47502H11.5879V1.9969C11.5879 1.15315 10.9129 0.478149 10.0691 0.478149H7.90352C7.05977 0.478149 6.38477 1.15315 6.38477 1.9969V2.47502H4.21914C3.40352 2.47502 2.72852 3.15002 2.72852 3.96565V4.8094C2.72852 5.42815 3.09414 5.9344 3.62852 6.1594L4.07852 15.4688C4.13477 16.6219 5.09102 17.5219 6.24414 17.5219H11.7004C12.8535 17.5219 13.8098 16.6219 13.866 15.4688L14.3441 6.13127C14.8785 5.90627 15.2441 5.3719 15.2441 4.78127V3.93752C15.2441 3.15002 14.5691 2.47502 13.7535 2.47502ZM7.67852 1.9969C7.67852 1.85627 7.79102 1.74377 7.93164 1.74377H10.0973C10.2379 1.74377 10.3504 1.85627 10.3504 1.9969V2.47502H7.70664V1.9969H7.67852ZM4.02227 3.96565C4.02227 3.85315 4.10664 3.74065 4.24727 3.74065H13.7535C13.866 3.74065 13.9785 3.82502 13.9785 3.96565V4.8094C13.9785 4.9219 13.8941 5.0344 13.7535 5.0344H4.24727C4.13477 5.0344 4.02227 4.95002 4.02227 4.8094V3.96565ZM11.7285 16.2563H6.27227C5.79414 16.2563 5.40039 15.8906 5.37227 15.3844L4.95039 6.2719H13.0785L12.6566 15.3844C12.6004 15.8625 12.2066 16.2563 11.7285 16.2563Z"
                                        fill=""
                                        />
                                        <path
                                        d="M9.00039 9.11255C8.66289 9.11255 8.35352 9.3938 8.35352 9.75942V13.3313C8.35352 13.6688 8.63477 13.9782 9.00039 13.9782C9.33789 13.9782 9.64727 13.6969 9.64727 13.3313V9.75942C9.64727 9.3938 9.33789 9.11255 9.00039 9.11255Z"
                                        fill=""
                                        />
                                        <path
                                        d="M11.2502 9.67504C10.8846 9.64692 10.6033 9.90004 10.5752 10.2657L10.4064 12.7407C10.3783 13.0782 10.6314 13.3875 10.9971 13.4157C11.0252 13.4157 11.0252 13.4157 11.0533 13.4157C11.3908 13.4157 11.6721 13.1625 11.6721 12.825L11.8408 10.35C11.8408 9.98442 11.5877 9.70317 11.2502 9.67504Z"
                                        fill=""
                                        />
                                        <path
                                        d="M6.72245 9.67504C6.38495 9.70317 6.1037 10.0125 6.13182 10.35L6.3287 12.825C6.35683 13.1625 6.63808 13.4157 6.94745 13.4157C6.97558 13.4157 6.97558 13.4157 7.0037 13.4157C7.3412 13.3875 7.62245 13.0782 7.59433 12.7407L7.39745 10.2657C7.39745 9.90004 7.08808 9.64692 6.72245 9.67504Z"
                                        fill=""
                                        />
                                    </svg>
                                </button>
                                <button id="permaDeleteButton" data-modal-target="permaDeleteModal" data-modal-toggle="permaDeleteModal" class="dark:hover:text-white hover:text-primary-custom hover:transition hover:duration-300 hover:scale-125" onclick="insertSlug('{{ $post->slug }}', 'posts', 'permaDelete')">
                                    <svg
                                    class="w-6 fill-current"
                                    viewBox="0 0 18 18"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                        d="M13.7535 2.47502H11.5879V1.9969C11.5879 1.15315 10.9129 0.478149 10.0691 0.478149H7.90352C7.05977 0.478149 6.38477 1.15315 6.38477 1.9969V2.47502H4.21914C3.40352 2.47502 2.72852 3.15002 2.72852 3.96565V4.8094C2.72852 5.42815 3.09414 5.9344 3.62852 6.1594L4.07852 15.4688C4.13477 16.6219 5.09102 17.5219 6.24414 17.5219H11.7004C12.8535 17.5219 13.8098 16.6219 13.866 15.4688L14.3441 6.13127C14.8785 5.90627 15.2441 5.3719 15.2441 4.78127V3.93752C15.2441 3.15002 14.5691 2.47502 13.7535 2.47502ZM7.67852 1.9969C7.67852 1.85627 7.79102 1.74377 7.93164 1.74377H10.0973C10.2379 1.74377 10.3504 1.85627 10.3504 1.9969V2.47502H7.70664V1.9969H7.67852ZM4.02227 3.96565C4.02227 3.85315 4.10664 3.74065 4.24727 3.74065H13.7535C13.866 3.74065 13.9785 3.82502 13.9785 3.96565V4.8094C13.9785 4.9219 13.8941 5.0344 13.7535 5.0344H4.24727C4.13477 5.0344 4.02227 4.95002 4.02227 4.8094V3.96565ZM11.7285 16.2563H6.27227C5.79414 16.2563 5.40039 15.8906 5.37227 15.3844L4.95039 6.2719H13.0785L12.6566 15.3844C12.6004 15.8625 12.2066 16.2563 11.7285 16.2563Z"
                                        fill=""
                                        />
                                        <path
                                        d="M9.00039 9.11255C8.66289 9.11255 8.35352 9.3938 8.35352 9.75942V13.3313C8.35352 13.6688 8.63477 13.9782 9.00039 13.9782C9.33789 13.9782 9.64727 13.6969 9.64727 13.3313V9.75942C9.64727 9.3938 9.33789 9.11255 9.00039 9.11255Z"
                                        fill=""
                                        />
                                        <path
                                        d="M11.2502 9.67504C10.8846 9.64692 10.6033 9.90004 10.5752 10.2657L10.4064 12.7407C10.3783 13.0782 10.6314 13.3875 10.9971 13.4157C11.0252 13.4157 11.0252 13.4157 11.0533 13.4157C11.3908 13.4157 11.6721 13.1625 11.6721 12.825L11.8408 10.35C11.8408 9.98442 11.5877 9.70317 11.2502 9.67504Z"
                                        fill=""
                                        />
                                        <path
                                        d="M6.72245 9.67504C6.38495 9.70317 6.1037 10.0125 6.13182 10.35L6.3287 12.825C6.35683 13.1625 6.63808 13.4157 6.94745 13.4157C6.97558 13.4157 6.97558 13.4157 7.0037 13.4157C7.3412 13.3875 7.62245 13.0782 7.59433 12.7407L7.39745 10.2657C7.39745 9.90004 7.08808 9.64692 6.72245 9.67504Z"
                                        fill=""
                                        />
                                    </svg>
                                </button>
                                {{-- Restore Tooltip START --}}
                                <div id="restore-tooltip-{{ $loop->iteration }}" role="tooltip" class="tooltip absolute invisible z-10 inline-block px-3 py-2 text-sm font-medium text-white bg-slate-800 rounded-lg border border-slate-600 shadow-sm opacity-0 transition-opacity duration-300 dark:text-graydark dark:bg-whiter dark:border-slate-200">
                                    Restore
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                                {{-- Restore Tooltip END --}}

                                {{-- Permanent Delete Tooltip START --}}
                                <div id="permaDel-tooltip-{{ $loop->iteration }}" role="tooltip" class="tooltip absolute invisible z-10 inline-block px-3 py-2 text-sm font-medium text-white bg-slate-800 rounded-lg border border-slate-600 shadow-sm opacity-0 transition-opacity duration-300 dark:text-graydark dark:bg-whiter dark:border-slate-200">
                                    Permanantly Delete
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                                {{-- Permanent Delete Tooltip END --}}
                                @else
                                <a href="/dashboard/posts/{{ $post->slug }}" data-tooltip-target="view-tooltip-{{ $loop->iteration }}" data-tooltip-placement="top" class="dark:hover:text-white hover:text-primary-custom hover:transition hover:duration-300 hover:scale-125">
                                    <svg
                                        class="w-6 fill-current"
                                        viewBox="0 0 18 18"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                        d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.20624 8.99981 3.20624C14.5686 3.20624 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM1.85605 8.99999C2.4748 10.0406 4.89356 13.5562 8.99981 13.5562C13.1061 13.5562 15.5248 10.0406 16.1436 8.99999C15.5248 7.95936 13.1061 4.44374 8.99981 4.44374C4.89356 4.44374 2.4748 7.95936 1.85605 8.99999Z"
                                        fill=""
                                        />
                                        <path
                                        d="M9 11.3906C7.67812 11.3906 6.60938 10.3219 6.60938 9C6.60938 7.67813 7.67812 6.60938 9 6.60938C10.3219 6.60938 11.3906 7.67813 11.3906 9C11.3906 10.3219 10.3219 11.3906 9 11.3906ZM9 7.875C8.38125 7.875 7.875 8.38125 7.875 9C7.875 9.61875 8.38125 10.125 9 10.125C9.61875 10.125 10.125 9.61875 10.125 9C10.125 8.38125 9.61875 7.875 9 7.875Z"
                                        fill=""
                                        />
                                    </svg>
                                </a>
                                <a href="/dashboard/posts/{{ $post->slug }}/edit" data-tooltip-target="edit-tooltip-{{ $loop->iteration }}" data-tooltip-placement="top" class="dark:hover:text-white hover:text-primary-custom hover:transition hover:duration-300 hover:scale-125">
                                    <svg class="w-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                    </svg>
                                </a>
                                <button id="deleteButton" data-modal-target="deleteModal" data-tooltip-target="delete-tooltip-{{ $loop->iteration }}" data-tooltip-placement="top" data-modal-toggle="deleteModal" class="dark:hover:text-white hover:text-primary-custom hover:transition hover:duration-300 hover:scale-125" onclick="insertSlug('{{ $post->slug }}', 'posts', 'delete')">
                                    <svg
                                    class="w-6 fill-current"
                                    viewBox="0 0 18 18"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                        d="M13.7535 2.47502H11.5879V1.9969C11.5879 1.15315 10.9129 0.478149 10.0691 0.478149H7.90352C7.05977 0.478149 6.38477 1.15315 6.38477 1.9969V2.47502H4.21914C3.40352 2.47502 2.72852 3.15002 2.72852 3.96565V4.8094C2.72852 5.42815 3.09414 5.9344 3.62852 6.1594L4.07852 15.4688C4.13477 16.6219 5.09102 17.5219 6.24414 17.5219H11.7004C12.8535 17.5219 13.8098 16.6219 13.866 15.4688L14.3441 6.13127C14.8785 5.90627 15.2441 5.3719 15.2441 4.78127V3.93752C15.2441 3.15002 14.5691 2.47502 13.7535 2.47502ZM7.67852 1.9969C7.67852 1.85627 7.79102 1.74377 7.93164 1.74377H10.0973C10.2379 1.74377 10.3504 1.85627 10.3504 1.9969V2.47502H7.70664V1.9969H7.67852ZM4.02227 3.96565C4.02227 3.85315 4.10664 3.74065 4.24727 3.74065H13.7535C13.866 3.74065 13.9785 3.82502 13.9785 3.96565V4.8094C13.9785 4.9219 13.8941 5.0344 13.7535 5.0344H4.24727C4.13477 5.0344 4.02227 4.95002 4.02227 4.8094V3.96565ZM11.7285 16.2563H6.27227C5.79414 16.2563 5.40039 15.8906 5.37227 15.3844L4.95039 6.2719H13.0785L12.6566 15.3844C12.6004 15.8625 12.2066 16.2563 11.7285 16.2563Z"
                                        fill=""
                                        />
                                        <path
                                        d="M9.00039 9.11255C8.66289 9.11255 8.35352 9.3938 8.35352 9.75942V13.3313C8.35352 13.6688 8.63477 13.9782 9.00039 13.9782C9.33789 13.9782 9.64727 13.6969 9.64727 13.3313V9.75942C9.64727 9.3938 9.33789 9.11255 9.00039 9.11255Z"
                                        fill=""
                                        />
                                        <path
                                        d="M11.2502 9.67504C10.8846 9.64692 10.6033 9.90004 10.5752 10.2657L10.4064 12.7407C10.3783 13.0782 10.6314 13.3875 10.9971 13.4157C11.0252 13.4157 11.0252 13.4157 11.0533 13.4157C11.3908 13.4157 11.6721 13.1625 11.6721 12.825L11.8408 10.35C11.8408 9.98442 11.5877 9.70317 11.2502 9.67504Z"
                                        fill=""
                                        />
                                        <path
                                        d="M6.72245 9.67504C6.38495 9.70317 6.1037 10.0125 6.13182 10.35L6.3287 12.825C6.35683 13.1625 6.63808 13.4157 6.94745 13.4157C6.97558 13.4157 6.97558 13.4157 7.0037 13.4157C7.3412 13.3875 7.62245 13.0782 7.59433 12.7407L7.39745 10.2657C7.39745 9.90004 7.08808 9.64692 6.72245 9.67504Z"
                                        fill=""
                                        />
                                    </svg>
                                </button>
                                {{-- Show Tooltip START --}}
                                <div id="view-tooltip-{{ $loop->iteration }}" role="tooltip" class="tooltip absolute invisible z-10 inline-block px-3 py-2 text-sm font-medium text-white bg-slate-800 rounded-lg border border-slate-600 shadow-sm opacity-0 transition-opacity duration-300 dark:text-graydark dark:bg-whiter dark:border-slate-200">
                                    View
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                                {{-- Show Tooltip END --}}

                                {{-- Edit Tooltip START --}}
                                <div id="edit-tooltip-{{ $loop->iteration }}" role="tooltip" class="tooltip absolute invisible z-10 inline-block px-3 py-2 text-sm font-medium text-white bg-slate-800 rounded-lg border border-slate-600 shadow-sm opacity-0 transition-opacity duration-300 dark:text-graydark dark:bg-whiter dark:border-slate-200">
                                    Edit
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                                {{-- Edit Tooltip END --}}

                                {{-- Delete Tooltip START --}}
                                <div id="delete-tooltip-{{ $loop->iteration }}" role="tooltip" class="tooltip absolute invisible z-10 inline-block px-3 py-2 text-sm font-medium text-white bg-slate-800 rounded-lg border border-slate-600 shadow-sm opacity-0 transition-opacity duration-300 dark:text-graydark dark:bg-whiter dark:border-slate-200">
                                    Delete
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                                {{-- Delete Tooltip END --}}
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="text-center lg:text-2xl">
                        <td colspan="5" class="py-5 lg:py-8">
                            No Record Found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- ====== Table Pagination START -->
    <div class="my-5">
        {{ $this->getPosts->onEachSide(5)->links() }}
    </div>
    <!-- ====== Table Pagination END -->
    {{--                                                                                        >>>>>> TABLE SECTION END <<<< --}}
</div>

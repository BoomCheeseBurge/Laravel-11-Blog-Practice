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

    {{-- -------------------------------------------------------------------------------------------------------------- --}}
    <div class="container mx-auto px-4 py-6" x-data="datatables" x-cloak>
		<h1 class="py-4 mb-10 text-3xl border-b">Datatable</h1>

        <div x-data="{ dropdownOpen: false } }" class="relative inline-block text-left">
            <div>
              <button x-on:click="dropdownOpen = !dropdownOpen" type="button" class="w-full inline-flex justify-center gap-x-1.5 px-3 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md ring-1 ring-inset ring-gray-300 shadow-sm hover:bg-gray-50" id="menu-button" aria-expanded="true" aria-haspopup="true">
                Options
                <svg class="-mr-1 w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                  <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
              </button>
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
            <div x-show="dropdownOpen" x-on:click.outside="dropdownOpen = false"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="ring-black/5 w-56 absolute right-0 z-10 mt-2 bg-white rounded-md ring-1 shadow-lg origin-top-right focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
              <div class="py-1" role="none">
                <!-- Active: "bg-gray-100 text-gray-900 outline-none", Not Active: "text-gray-700" -->
                <a href="#" x-on:click="dropdownOpen = !dropdownOpen; printOut();" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-0">Account settings</a>
                <a href="#" x-on:click="dropdownOpen = !dropdownOpen; printOut();" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-1">Support</a>
                <a href="#" x-on:click="dropdownOpen = !dropdownOpen; printOut();" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-2">License</a>
              </div>
            </div>
        </div>


		<div x-show="selectedRows.length" class="w-full fixed top-0 right-0 left-0 z-40 bg-teal-200 shadow">
			<div class="container mx-auto px-4 py-4">
				<div class="flex md:items-center">
					<div class="flex-shrink-0 mr-4">
						<svg class="w-8 h-8 text-teal-600"  viewBox="0 0 20 20" fill="currentColor">  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
					</div>
					<div x-html="selectedRows.length + ' rows are selected'" class="text-lg text-teal-800"></div>
				</div>
			</div>
		</div>

		<div class="flex justify-between items-center mb-4">
			<div class="flex-1 pr-4">
				<div class="relative md:w-1/3">
					<input type="search"
						class="w-full py-2 pr-4 pl-10 font-medium text-gray-600 rounded-lg shadow focus:shadow-outline focus:outline-none"
						placeholder="Search...">
					<div class="absolute top-0 left-0 inline-flex items-center p-2">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 24 24"
							stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
							stroke-linejoin="round">
							<rect x="0" y="0" width="24" height="24" stroke="none"></rect>
							<circle cx="10" cy="10" r="7" />
							<line x1="21" y1="21" x2="15" y2="15" />
						</svg>
					</div>
				</div>
			</div>
			<div>
				<div class="flex rounded-lg shadow">
					<div class="relative">
						<button @click.prevent="open = !open"
							class="inline-flex items-center px-2 py-2 font-semibold text-gray-500 bg-white rounded-lg focus:shadow-outline focus:outline-none hover:text-blue-500 md:px-4">
							<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:hidden" viewBox="0 0 24 24"
								stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
								stroke-linejoin="round">
								<rect x="0" y="0" width="24" height="24" stroke="none"></rect>
								<path
									d="M5.5 5h13a1 1 0 0 1 0.5 1.5L14 12L14 19L10 16L10 12L5 6.5a1 1 0 0 1 0.5 -1.5" />
							</svg>
							<span class="hidden md:block">Display</span>
							<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" width="24" height="24"
								viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
								stroke-linecap="round" stroke-linejoin="round">
								<rect x="0" y="0" width="24" height="24" stroke="none"></rect>
								<polyline points="6 9 12 15 18 9" />
							</svg>
						</button>

						<div x-show="open" @click.away="open = false"
							class="-mr-1 w-40 overflow-hidden absolute top-0 right-0 z-40 block py-1 mt-12 bg-white rounded-lg shadow-lg">
							<template x-for="column in columns">
								<label
									class="text-truncate flex justify-start items-center px-4 py-2 hover:bg-gray-100">
									<div class="mr-3 text-teal-600">
										<input type="checkbox" class="form-checkbox focus:shadow-outline focus:outline-none" x-model="selectedColumns" :value="column">
									</div>
									<div class="text-gray-700 select-none" x-text="column"></div>
								</label>
							</template>
						</div>
					</div>
				</div>
			</div>
            <div x-text="selectedColumns"></div>
		</div>

		<div class="overflow-x-auto overflow-y-auto relative bg-white rounded-lg shadow"
			style="height: 405px;">
			<table class="table-striped whitespace-no-wrap w-full relative bg-white border-collapse table-auto">
				<thead>
					<tr class="text-left">
						<th class="sticky top-0 px-3 py-2 bg-gray-100 border-b border-gray-200">
							<label
								class="inline-flex justify-between items-center px-2 py-2 text-teal-500 rounded-lg cursor-pointer hover:bg-gray-200">
								<input type="checkbox" class="form-checkbox focus:shadow-outline focus:outline-none" @click="selectAllCheckbox($event);">
							</label>
						</th>
						<template x-for="column in columns">
							<th class="sticky top-0 px-6 py-2 text-xs font-bold tracking-wider text-gray-600 uppercase bg-gray-100 border-b border-gray-200"
								x-text="column" x-show="toggleColumn(column)"></th>
						</template>
					</tr>
				</thead>
				<tbody>
					<template x-for="r in data">
						<tr>
							<td class="px-3 border-t border-gray-200 border-dashed">
								<label
									class="inline-flex justify-between items-center px-2 py-2 text-teal-500 rounded-lg cursor-pointer hover:bg-gray-200">
									<input type="checkbox" class="form-checkbox rowCheckbox focus:shadow-outline focus:outline-none">
								</label>
							</td>
							<td x-show="toggleColumn('name')" class="userId border-t border-gray-200 border-dashed">
								<span class="flex items-center px-6 py-3 text-gray-700" x-text="r.name"></span>
							</td>
							<td class="firstName border-t border-gray-200 border-dashed">
								<span class="flex items-center px-6 py-3 text-gray-700" x-text="r.category"></span>
							</td>
							<td class="lastName border-t border-gray-200 border-dashed">
								<span class="flex items-center px-6 py-3 text-gray-700" x-text="r.tags"></span>
							</td>
							<td class="emailAddress border-t border-gray-200 border-dashed">
								<span class="flex items-center px-6 py-3 text-gray-700"
									x-text="r.description"></span>
							</td>
							<td class="gender border-t border-gray-200 border-dashed">
								<span class="flex items-center px-6 py-3 text-gray-700"
									x-text="r.price"></span>
							</td>
						</tr>
					</template>
				</tbody>
			</table>
		</div>
	</div>
    {{-- -------------------------------------------------------------------------------------------------------------- --}}

    @push('scripts')
	<script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('datatables', () => ({
                columns: [
                    'Name',
                    'Category',
                    'Tags',
                    'Description',
                    'Price',
				],
                selectedColumns: [
                    'Name',
                    'Category',
                    'Tags',
                    'Description',
                    'Price',
				],
				data: [
                    {
                        name: 'Product 1',
                        category: 'Category 1',
                        tags: 'Tag 1, Tag 2, Tag 3',
                        description: 'This is the description for the product',
                        price: '$12.33',
                    }, {
                        name: 'Product 2',
                        category: 'Category 1',
                        tags: 'Tag 1, Tag 2, Tag 3',
                        description: 'This is the description for the product',
                        price: '$12.33',
                    }, {
                        name: 'Product 3',
                        category: 'Category 3',
                        tags: 'Tag 1, Tag 2, Tag 3',
                        description: 'This is the description for the product',
                        price: '$12.33',
                    }, {
                        name: 'Product 4',
                        category: 'Category 4',
                        tags: 'Tag 1, Tag 2, Tag 3',
                        description: 'This is the description for the product',
                        price: '$12.33',
                    }, {
                        name: 'Product 5',
                        category: 'Category 5',
                        tags: 'Tag 1, Tag 2, Tag 3',
                        description: 'This is the description for the product',
                        price: '$12.33',
                    },
                ],

				toggleColumn(column) {
					let result = this.selectedColumns.find(e => {

                        return e.toLowerCase() === column.toLowerCase();
                    });

                    return result != undefined;
				},

				getRowDetail($event, id) {
					let rows = this.selectedRows;

					if (rows.includes(id)) {
						let index = rows.indexOf(id);
						rows.splice(index, 1);
					} else {
						rows.push(id);
					}
				},

				selectAllCheckbox($event) {
					let columns = document.querySelectorAll('.rowCheckbox');

					this.selectedRows = [];

					if ($event.target.checked == true) {
						columns.forEach(column => {
							column.checked = true
							this.selectedRows.push(parseInt(column.name))
						});
					} else {
						columns.forEach(column => {
							column.checked = false
						});
						this.selectedRows = [];
					}
				}
            }))
        })
	</script>
    @endpush
</x-layouts.dashboard-layout>

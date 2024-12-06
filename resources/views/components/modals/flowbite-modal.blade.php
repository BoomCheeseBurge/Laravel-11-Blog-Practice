@props(['modalID', 'height', 'width', 'position'])

<div id="{{ $modalID }}" data-modal-placement="top-right" tabindex="-1" class="h-[calc(100%-1rem)] w-full max-h-full overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 hidden p-4 md:inset-0">
    <div class="w-full {{ $height }} {{ $width }} relative">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex justify-between items-center p-4 rounded-t border-b dark:border-gray-600 md:p-5">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                </h3>
                <button type="button" class="ms-auto w-8 h-8 inline-flex justify-center items-center text-sm text-gray-400 bg-transparent rounded-lg dark:hover:text-white dark:hover:bg-gray-600 hover:text-gray-900 hover:bg-gray-200" data-modal-hide="{{ $modalID }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 space-y-4 md:p-5">
                {{ $body }}
            </div>
            <!-- Modal footer -->
            <div class="flex justify-center items-center p-4 rounded-b border-t border-gray-200 dark:border-gray-600 md:p-5">
                {{ $footer }}
            </div>
        </div>
    </div>
</div>

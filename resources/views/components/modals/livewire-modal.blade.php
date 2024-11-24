@props(['name', 'title', 'width', 'height'])

<div x-cloak x-transition 
    x-data="{ show : false,  name : '{{ $name }}' }"
    x-show="show"
    {{-- Event name must be separated with hyphen between words (camel case will not work) --}}
    x-on:open-modal.window = "show = ($event.detail.name === name)"
    x-on:close-modal.window = "show = false"
    x-trap.noscroll="show"
    x-on:keydown.escape.window = "show = false"
    class="z-999 fixed inset-0"
    >
    {{-- Modal Background --}}
    <div x-on:click="show = false" class="fixed inset-0 bg-gray-100 opacity-10 dark:bg-gray-700"></div>

    {{-- Modal Content --}}
    <div class="m-auto {{ $width }} {{ $height }} fixed shadow-md shadow-gray-400 inset-0 text-white bg-slate-800 rounded dark:text-boxdark-2 dark:bg-slate-100">
        <div class="relative flex justify-center items-center pt-5">
            @if (isset($title))
                <div class="flex justify-center items-center">
                    {{ $title }}
                </div>
            @endif
            <button class="absolute right-0 mr-1" x-on:click="$dispatch('close-modal')">
                <svg class="w-8 h-8 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                </svg>
            </button>
        </div>
        <hr class="h-px my-5 bg-gray-200 border-0 dark:bg-gray-300">
        <div>
            {{ $body }}
        </div>
        @if (isset($footer))
        <hr class="h-px my-5 bg-gray-200 border-0 dark:bg-gray-300">
        <div class="mb-5">
            {{ $footer }}
        </div>
        @endif
    </div>
</div>

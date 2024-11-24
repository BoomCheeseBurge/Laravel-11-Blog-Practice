@props(['name', 'height', 'width'])
<div class="fixed inset-0 z-50" x-cloak x-transition
    x-data="{ show : false, name: '{{ $name }}'}"
    x-show="show"
    {{-- Event name must be separated with hyphen between words (camel case will not work) --}}
    x-on:show-modal.window="show = ($event.detail.name === name)"
    x-on:hide-modal.window="show = false"
    x-trap.noscroll="show"
    x-on:keydown.escape.window="show = false">

    {{-- Modal Background --}}
    <div class="fixed inset-0 bg-slate-300 opacity-40 dark:opacity-0" x-on:click="show = false"></div>

    {{-- Modal Container --}}
    <div class="{{ $height }} {{ $width }} m-auto fixed inset-0 p-2 bg-white rounded-lg dark:bg-slate-700">
        {{-- Modal Header --}}
        <div class="flex justify-end mb-1">
            {{-- Modal Close Button --}}
            <button x-on:click="show = false">
                <svg class="w-6 h-6 text-slate-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                </svg>
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="border-t-[1px] flex flex-col items-center py-5 space-y-6 border-t-zinc-300">
            <div class="text-md font-semibold dark:text-white lg:text-lg">
                {{ $body }}
            </div>
            @if (isset($footer))
            <div>
                {{ $footer }}
            </div>
            @endif
        </div>
    </div>

</div>

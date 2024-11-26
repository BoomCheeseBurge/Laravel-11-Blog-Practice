<div class="relative">
    {{-- ================================== Profile Cover Validation Error Message END ================================== --}}
    @error('profileCover')
    <x-messages.dismissal-error :message="$message" class="mb-4"></x-messages.dismissal-error>
    @enderror
    {{-- ================================== Profile Cover Validation Error Message END ================================== --}}

    @if (isset(auth()->user()->profile_cover))
    <img wire:loading.class="opacity-60" wire:target="profileCover" src="{{ Storage::disk('cover')->url(auth()->user()->profile_cover) }}" alt="{{ auth()->user()->username }} Profile Cover"
        class="w-full rounded-t-xl lg:h-[18rem] md:h-[16rem] sm:h-[14rem] xl:h-[20rem] xs:h-[11rem]" />
    @else
    <img wire:loading.class="opacity-60" wire:target="profileCover" src="{{ asset('IMG/default/default_background.jpeg') }}" alt="Default Profile Cover"
            class="w-full rounded-t-xl lg:h-[18rem] md:h-[16rem] sm:h-[14rem] xl:h-[20rem] xs:h-[11rem]" />
    @endif

    <div wire:loading.delay wire:target="profileCover" class="right-[40%] absolute bottom-1/3 lg:right-[44%] sm:right-[42%]">
        <div role="status">
            <svg aria-hidden="true" class="h-18 w-18 text-slate-200 animate-spin fill-blue-600 dark:text-slate-600 dark:fill-slate-200 lg:h-30 lg:w-30 sm:w-24 sm:h-24" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div class="absolute right-0 bottom-0">

        <form wire:submit="save">
            <input type="file" wire:model="profileCover" id="upload_cover" hidden required>
        </form>

        <div
            class="border-l-[2px] border-t-[2px] flex items-center gap-1 px-2 text-sm font-semibold text-center text-slate-500 bg-teal-50 rounded-tl-md border-teal-400 group hover:text-slate-400 lg:text-lg md:text-base">
            <label wire:loading.class="opacity-50 pointer-events-none" wire:target="profileCover" for="upload_cover" class="inline-flex items-center gap-1 cursor-pointer">

                Change Cover

                <svg data-slot="icon" class="w-6 h-5 text-blue-700 group-hover:text-blue-500 lg:w-9 lg:h-7" fill="none" stroke-width="1.5"
                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z">
                    </path>
                </svg>
            </label>
        </div>
    </div>
</div>

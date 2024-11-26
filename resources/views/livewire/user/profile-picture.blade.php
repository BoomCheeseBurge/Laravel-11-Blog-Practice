<div class="relative">
    @if ( isset(auth()->user()->profile_pic))
    <img wire:loading.class="opacity-80" src="{{ Storage::disk('profile')->url(auth()->user()->profile_pic) }}" alt="{{ auth()->user()->username }} Profile Picture"
    class="w-20 h-20 relative left-5 bottom-10 rounded-full outline-2 outline-blue-500 outline outline-offset-2 lg:w-[10rem] lg:h-[10rem] lg:bottom-[5rem] md:w-[8rem] md:h-[8rem] sm:w-[7rem] sm:h-[7rem] sm:bottom-[4rem]" />
    @else
    <img wire:loading.class="opacity-80" src="{{ asset('IMG/default/default_user.png') }}" alt="Default Profile Picture"
    class="w-20 h-20 relative left-5 bottom-10 rounded-full outline-2 outline-blue-500 outline outline-offset-2 lg:w-[10rem] lg:h-[10rem] lg:bottom-[5rem] md:w-[8rem] md:h-[8rem] sm:bottom-[4rem]" />
    @endif

    <div wire:loading.delay wire:target="profilePic" class="-top-4 left-11.5 absolute lg:-top-10 lg:left-15.5 md:-top-7.5 md:left-14.5 sm:-top-8 sm:left-13">
        <div role="status">
            <svg aria-hidden="true" class="w-8 h-8 text-slate-200 animate-spin fill-blue-600 dark:text-slate-600 dark:fill-slate-200 lg:w-19 lg:h-19 sm:w-14 sm:h-14" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div wire:loading.class="opacity-80 pointer-events-none" class="-top-10.5 left-22.5 w-8 h-8 absolute text-center bg-teal-50 rounded-full dark:bg-teal-100 lg:-top-16 lg:left-37.5 md:-top-14 md:left-30 md:w-12 md:h-12 sm:-top-12 sm:w-10 sm:h-10 sm:left-28">

        <form wire:submit="save">
            <input type="file" wire:model="profilePic" id="upload_profile" hidden required>
        </form>

        <label for="upload_profile" class="cursor-pointer" data-tooltip-target="tooltip-change-pfp">
                <svg data-slot="icon" class="w-8 h-7 text-blue-700 dark:text-primary-custom dark:hover:text-indigo-500 hover:text-blue-500 md:w-12 md:h-11 sm:w-10 sm:h-9" fill="none"
                    stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z">
                    </path>
                </svg>
        </label>
        <div id="tooltip-change-pfp" role="tooltip" class="tooltip w-45 absolute invisible z-10 inline-block px-3 py-2 text-sm font-medium text-slate-600 bg-slate-50 rounded-lg border-2 border-blue-400 shadow-sm opacity-0 transition-opacity duration-300 dark:text-white dark:bg-slate-700">
            Change Profile Picture
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
    </div>
    
    <div class="top-22.5 w-75 absolute z-20">
        {{-- ================================== Profile Picture Validation Error Message START ================================== --}}
        @error('profilePic')
        <x-messages.dismissal-error :message="$message"></x-messages.dismissal-error>
        @enderror
        {{-- ================================== Profile Picture Validation Error Message END ================================== --}}
    </div>
</div>

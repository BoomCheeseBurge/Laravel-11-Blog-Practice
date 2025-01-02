<div x-data="{ edit: false }"  
    class="mt-6 text-gray-700 dark:text-gray-200">
    <div class="flex flex-col gap-5 mt-6 text-gray-700 dark:text-gray-200 md:flex-row md:items-center md:gap-0">
        Current Email Address:
        
        <div x-show="!edit">
            <span class="p-2 ml-5 bg-teal-300 rounded-md dark:bg-teal-500">{{ $user->email }}</span>

            @if ($user->email_verified_at)
            <button x-on:click="edit = !edit" data-tooltip-target="tooltip-edit-email" class="ml-5">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0,0,256,256">
                    <g fill="#de900b" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><path d="M19.17188,2c-0.72375,0 -1.4475,0.27562 -2,0.82813l-1.17187,1.17188l4,4l1.17188,-1.17187c1.104,-1.104 1.104,-2.895 0,-4c-0.5525,-0.5525 -1.27625,-0.82812 -2,-0.82812zM14.5,5.5l-11.5,11.5v4h4l11.5,-11.5z"></path></g></g>
                </svg>
            </button>
            <div id="tooltip-edit-email" role="tooltip" class="tooltip absolute invisible z-10 inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 dark:bg-amber-500">
                Edit Email
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            @endif
        </div>

        <div x-cloak x-show="edit" class="ml-5">
            <form wire:submit="saveEmail" class="inline">
                @csrf
                <input type="email" wire:model.blur="newMail" class="w-11/12 mt-3 bg-slate-200 rounded-md dark:text-boxdark-2 dark:bg-slate-200 lg:w-full">
                <div class="text-red-600 dark:text-red-400">@error('newMail') {{ $message }} @enderror</div>

                <button x-on:click="edit = !edit" type="submit" class="px-2 py-1 mt-3 text-white bg-blue-600 rounded-md hover:bg-blue-500">
                    <div wire:loading wire:target="saveEmail" role="status">
                        <svg aria-hidden="true" class="w-5 h-5 text-slate-200 animate-spin fill-blue-600 dark:text-slate-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                    <span wire:loading.class="invinsible">Save</span>
                </button>
            </form>

            <button x-on:click="edit = !edit" wire:loading.attr="disabled" class="ml-3 text-sm text-red-600 underline dark:text-red-400 hover:no-underline lg:mt-2">
                Cancel
            </button>
        </div>
    </div>

    <div class="flex items-center mt-3">
        @if (auth()->user()->email_verified_at)
        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 48 48">
            <path fill="#c8e6c9" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path><path fill="#4caf50" d="M34.586,14.586l-13.57,13.586l-5.602-5.586l-2.828,2.828l8.434,8.414l16.395-16.414L34.586,14.586z"></path>
        </svg>
        <span class="ml-1 text-sm text-green-400">Email Verified</span>            
        @else
        <div class="flex items-center mt-5">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48">
                <path fill="#f44336" d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"></path><path fill="#fff" d="M29.656,15.516l2.828,2.828l-14.14,14.14l-2.828-2.828L29.656,15.516z"></path><path fill="#fff" d="M32.484,29.656l-2.828,2.828l-14.14-14.14l2.828-2.828L32.484,29.656z"></path>
            </svg>
            Email not verified!
            <form action="{{ route('verification.send') }}" method="POST">
                @csrf
                <button class="bg-primary-600 px-2 py-1 ml-2 text-white rounded-md hover:bg-primary-500">Resend Verification</button>
            </form>
        </div>
        @endif
    </div>

    @push('scripts')
    <x-livewire-alert::scripts />
    @endpush
</div>

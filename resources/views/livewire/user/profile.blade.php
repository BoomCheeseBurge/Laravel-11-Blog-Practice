<section class="w-full overflow-hidden dark:bg-slate-900">

    {{-- ================================== Success Message START ================================== --}}
    @if (session('success'))
    <x-messages.dismissal-success :message="session('success')" class="mb-4"></x-messages.dismissal-success>
    @endif
    {{-- ================================== Success Message END ================================== --}}

    <div class="flex flex-col">
        <!-- ========================= Profile Cover START -->
        <livewire:user.profile-cover>
        <!--                           Profile Cover END ========================= -->

        <!-- ========================= Profile Picture and Username START -->
        <div class="w-full flex justify-start gap-10 md:gap-15 md:ml-10">

            {{-- Change Profile Picture Button --}}
            <livewire:user.profile-picture>

            <!-- ================== fullname START -->
            <h1
                class="mt-2 font-serif text-xl text-slate-800 dark:text-white lg:text-4xl md:text-3xl">
                {{ $form->username }}
            </h1>
            <!--                    fullname END ===================== -->
        </div>
        <!--                           Profile Picture and Username END ========================= -->

        <div
            class="-top-6 mx-auto relative flex flex-col items-center lg:w-[90%] lg:-top-20 md:-top-12 md:w-[90%] sm:w-[92%] xl:w-[80%] xs:w-[90%]">

            <!-- >>>>>>>>>>>>>>> Profile Detail START -->
            <div x-data="{ edit: $wire.entangle('showEdit') }"
                class="w-full">

                <div class="flex justify-end">
                    {{-- =============== Edit Profile Button START --}}
                    <button x-on:click="edit = true" x-show="!edit" type="button" 
                    class="px-5 py-2.5 me-2 mb-5 text-sm font-semibold text-white bg-amber-500 rounded-lg dark:bg-amber-600 dark:focus:ring-yellow-700 dark:hover:bg-amber-400 focus:outline-none focus:ring-4 focus:ring-yellow-300 hover:bg-amber-700 lg:px-4 lg:py-2 lg:text-base">
                        EDIT
                    </button>
                    {{--                 Edit Profile Button END =============== --}}
                </div>

                {{-- =============== Profile Information Section START --}}
                <div x-show="!edit">
                    <!-- >>>>>>>>>>>>>>> Profile Description START -->
                    <p class="text-md mx-auto w-fit pb-5 my-2 mb-8 text-slate-700 border-b-2 border-b-slate-400 dark:text-slate-400">
                        {{ $form->about ?? 'Write something about yourself!' }}
                    </p>
                    <!-- Profile Description END <<<<<<<<<<<<<<<<< -->
                    <div class="flex-col mb-8 space-y-5 font-semibold md:grid md:grid-cols-2 md:gap-4 md:space-y-0">
                            <dl class="text-slate-900 divide-y divide-slate-400 dark:text-white dark:divide-slate-700">
                                <div class="flex flex-col pb-4">
                                    <dt class="mb-1 text-sm text-slate-500 dark:text-slate-400 md:text-base">Full Name</dt>
                                    <dd class="text-base font-semibold text-slate-700 dark:text-slate-200 md:text-lg">{{ $form->fullname }}</dd>
                                </div>

                                <div class="flex flex-col pt-3 pb-4">
                                    <dt class="mb-1 text-sm text-slate-500 dark:text-slate-400 md:text-base">User Name</dt>
                                    <dd class="text-base font-semibold text-slate-700 dark:text-slate-200 md:text-lg">{{ $form->username }}</dd>
                                </div>

                                <div class="flex flex-col pt-3 pb-4">
                                    <dt class="mb-1 text-sm text-slate-500 dark:text-slate-400 md:text-base">Email</dt>
                                    <dd class="text-base font-semibold text-slate-700 dark:text-slate-200 md:text-lg">{{ $form->email }}</dd>
                                </div>

                                <div class="flex flex-col pt-3">
                                    <dt class="mb-1 text-sm text-slate-500 dark:text-slate-400 md:text-base">Sex</dt>
                                    <dd class="border-b-[1px] pb-4 text-base font-semibold text-slate-700 border-b-slate-400 dark:text-slate-200 md:pb-0 md:text-lg md:border-b-0">
                                        {{
                                            [
                                                1 => 'Male',
                                                2 => 'Female',
                                            ][$form->sex] ?? 'Prefer to not say';
                                        }}
                                    </dd>
                                </div>
                            </dl>

                            <dl class="text-slate-900 divide-y divide-slate-400 dark:text-white dark:divide-slate-700">
                                <div class="flex flex-col pb-4">
                                    <dt class="mb-1 text-sm text-slate-500 dark:text-slate-400 md:text-base">Date Of Birth</dt>
                                    <dd class="text-base font-semibold text-slate-700 dark:text-slate-200 md:text-lg">{{ $form->date_of_birth ?? '--/--/--' }}</dd>
                                </div>

                                <div class="flex flex-col pt-3 pb-4">
                                    <dt class="mb-1 text-sm text-slate-500 dark:text-slate-400 md:text-base">Location</dt>
                                    <dd class="text-base font-semibold text-slate-700 dark:text-slate-200 md:text-lg">{{ $form->location ?? 'Origin not set' }}</dd>
                                </div>

                                <div class="flex flex-col pt-3 pb-4">
                                    <dt class="mb-1 text-sm text-slate-500 dark:text-slate-400 md:text-base">Phone</dt>
                                    <dd class="text-base font-semibold text-slate-700 dark:text-slate-200 md:text-lg">{{ $this->number }}</dd>
                                </div>



                                <div class="flex flex-col pt-3">
                                    <dt class="mb-1 text-sm text-slate-500 dark:text-slate-400 md:text-base">Website</dt>
                                    <dd class="text-base font-semibold text-slate-700 dark:text-slate-200 {{ empty($website) ? '' : 'dark:hover:text-slate-400 hover:text-blue-500' }} md:text-lg">
                                        <a href="{{ empty($website) ? '#' : $website }}" {!! empty($website) ? '' : 'target="_blank"' !!}>{{ empty($website) ? 'None' : $website }}</a>
                                    </dd>
                                </div>
                            </dl>
                    </div>
                </div>
                {{--                 Profile Information Section END =============== --}}

                {{-- =============== Profile Edit Section START --}}
                <form wire:submit="update" x-cloak x-show="edit">
                    <div class="flex justify-end">
                        {{-- =============== Save Profile Button START --}}
                        <button x-cloak wire:click="$refresh" x-show="edit" type="submit" class="flex items-center gap-2 px-5 py-2.5 me-2 text-sm font-medium text-white bg-blue-600 rounded-lg dark:bg-blue-700 dark:focus:ring-blue-600 dark:hover:bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-300 hover:bg-blue-800 lg:px-4 lg:py-2 lg:text-base">
                            <div wire:loading.delay wire:target="update">
                                <div role="status">
                                    <svg aria-hidden="true" class="w-5 h-5 text-slate-200 animate-spin fill-blue-600 dark:text-slate-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            SAVE
                        </button>
                        {{--                 Save Profile Button END =============== --}}
                        {{-- =============== Cancel Profile Button START --}}
                        <button wire:loading.attr="disabled" wire:click="resetForm" x-cloak x-show="edit" type="button" class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg dark:bg-red-600 dark:focus:ring-red-700 dark:hover:bg-red-500 focus:outline-none focus:ring-4 focus:ring-red-300 hover:bg-red-800 lg:px-4 lg:py-2 lg:text-base">CANCEL</button>
                        {{--                 Cancel Profile Button END =============== --}}
                    </div>

                    {{-- -------------------------------------------- ABOUT ME INPUT -------------------------------------------- --}}
                    <div class="pb-4">
                        <label for="about" class="font-medium text-slate-900 dark:text-white">About Me</label>
                        <textarea wire:model.blur="form.about"
                        id="about" rows="3" class="w-full p-4 mt-2 rounded-lg border-2 dark:text-slate-200 dark:bg-slate-800 dark:border-slate-600"
                        placeholder="Tell us about yourself!"></textarea>
                        @error('form.about')
                        <x-messages.error :message="$message"></x-messages.error>
                        @enderror
                    </div>

                    <div class="flex-col mb-10 space-y-5 md:grid md:grid-cols-2 md:gap-10 md:mt-5 md:space-y-0">
                        <div class="space-y-4 text-slate-900 divide-y divide-slate-400 dark:text-white dark:divide-slate-700">

                            {{-- -------------------------------------------- FULLNAME INPUT -------------------------------------------- --}}
                            <div class="flex flex-col pb-4">
                                <label for="fullname" class="mt-4 font-medium text-slate-900 dark:text-white md:mt-0">Full Name</label>
                                <input wire:model.blur="form.fullname"
                                        id="fullname" type="text"
                                        class="w-full p-4 mt-2 rounded-lg border-2 dark:text-slate-200 dark:bg-slate-800 dark:border-slate-600"
                                        placeholder="Enter fullname">
                                @error('form.fullname')
                                <x-messages.error :message="$message"></x-messages.error>
                                @enderror
                            </div>

                            {{-- -------------------------------------------- USERNAME INPUT -------------------------------------------- --}}
                            <div class="flex flex-col pt-3 pb-4">
                                <label for="username" class="mt-2 font-medium text-slate-900 dark:text-white md:mt-0">User Name</label>
                                <input wire:model.blur="form.username"
                                        id="username" type="text"
                                        class="w-full p-4 mt-2 rounded-lg border-2 dark:text-slate-200 dark:bg-slate-800 dark:border-slate-600"
                                        placeholder="Enter username">
                                @error('form.username')
                                <x-messages.error :message="$message"></x-messages.error>
                                @enderror
                            </div>

                            {{-- -------------------------------------------- E-MAIL INPUT -------------------------------------------- --}}
                            <div class="flex flex-col pt-3 pb-4">
                                <label for="email" class="mt-2 font-medium text-slate-900 dark:text-white md:mt-0">E-mail</label>
                                <input wire:model.blur="form.email"
                                        id="email" type="email"
                                        class="w-full p-4 mt-2 rounded-lg border-2 dark:text-slate-200 dark:bg-slate-800 dark:border-slate-600"
                                        placeholder="Enter E-mail address">
                                @error('form.email')
                                <x-messages.error :message="$message"></x-messages.error>
                                @enderror
                            </div>

                            {{-- -------------------------------------------- SEX INPUT -------------------------------------------- --}}
                            <div class="flex flex-col pt-3 pb-4">
                                <label for="sex" class="mt-2 font-medium text-slate-900 dark:text-white md:mt-0">Sex</label>
                                <select wire:model="form.sex" id="sex" class="w-full p-4 mt-2 rounded-lg border-2 dark:text-slate-200 dark:bg-slate-800 dark:border-slate-600">
                                    <option value="0">Prefer not to say</option>
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                </select>
                                <div class="border-b-[1px] pb-4 md:pb-0 md:border-b-0"></div>
                            </div>

                        </div>

                        <div class="space-y-4 text-slate-900 divide-y divide-slate-400 dark:text-white dark:divide-slate-700">

                            {{-- -------------------------------------------- DATE OF BIRTH INPUT -------------------------------------------- --}}
                            <div class="flex flex-col pb-4">
                                <label for="date_of_birth" class="font-medium text-slate-900 dark:text-white">Date of Birth</label>
                                <input wire:model="form.date_of_birth"
                                id="date_of_birth" type="date"
                                class="w-full p-4 mt-2 rounded-lg border-2 dark:text-slate-200 dark:bg-slate-800 dark:border-slate-600">
                            </div>

                            {{-- -------------------------------------------- LOCATION INPUT -------------------------------------------- --}}
                            <div class="flex flex-col pt-2.5 pb-4">
                                <label for="location" class="mt-2 font-medium text-slate-900 dark:text-white md:mt-0">Location</label>
                                <select wire:model="form.location" id="countries" class="w-full block p-5 mt-2 text-sm text-slate-900 bg-slate-50 rounded-lg border border-slate-300 dark:placeholder-slate-400 dark:text-white dark:bg-slate-700 dark:border-slate-600 dark:focus:border-blue-500 dark:focus:ring-blue-500 focus:border-blue-500 focus:ring-blue-500">
                                    <option selected value="">Choose a country</option>
                                    <option value="Australia">Australia</option>
                                    <option value="France">France</option>
                                    <option value="Germany">Germany</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="United States">United States</option>
                                </select>
                            </div>

                            {{-- -------------------------------------------- PHONE INPUT -------------------------------------------- --}}
                            <div class="flex flex-col pt-3 pb-4">
                                <label for="phone" class="mt-2 mb-2 font-medium text-slate-900 dark:text-white md:mt-0">Phone</label>

                                <div x-data="{ dropdownOpen: false, country : $wire.entangle('code') }" class="relative flex items-center text-left">
                                    <div>
                                        <button x-on:click="dropdownOpen = !dropdownOpen" type="button" 
                                                class="w-45 flex justify-between p-5 text-sm font-medium text-center text-slate-900 bg-slate-100 rounded-s-lg border border-slate-300 ring-gray-300 shadow-sm dark:text-white dark:bg-slate-700 dark:border-slate-600 dark:focus:ring-slate-100 focus:outline-none focus:ring-1 focus:ring-blue-300 hover:bg-gray-50" 
                                                id="menu-button" aria-expanded="true" aria-haspopup="true">

                                            <div x-text="country"></div>

                                            <svg class="-mr-1 size-5 block text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                            </svg>
                                        </button>

                                        <!--
                                            Dropdown menu, show/hide based on menu state.

                                            Entering: "transition ease-out duration-100"
                                            From: "transform opacity-0 scale-95"
                                            To: "transform opacity-100 scale-100"
                                            Leaving: "transition ease-in duration-75"
                                            From: "transform opacity-100 scale-100"
                                            To: "transform opacity-0 scale-95"
                                        -->
                                        <div  x-cloak x-show="dropdownOpen" x-on:click.outside="dropdownOpen = false"
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="transform opacity-0 scale-95"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="transform opacity-100 scale-100"
                                            x-transition:leave-end="transform opacity-0 scale-95"
                                            class="ring-black/5 w-56 absolute left-0 z-10 mt-2 bg-white rounded-md ring-1 shadow-lg origin-top-right focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                            <div class="h-48 overflow-y-auto py-2 text-gray-700 dark:text-gray-200 dark:bg-slate-800" role="none">
                                                <!-- Active: "bg-gray-100 text-gray-900 outline-none", Not Active: "text-gray-700" -->
                                                <button x-on:click="country = '🇦🇺  (+61)'; dropdownOpen = !dropdownOpen" wire:click="setCode('AU')" type="button" class="center items w-full inline-flex px-4 py-2 text-sm text-slate-700 dark:text-slate-200 dark:hover:text-white dark:hover:bg-slate-600 hover:bg-slate-100">
                                                    🇦🇺 Australia (+61)
                                                </button>
                                                <button x-on:click="country = '🇫🇷  (+33)'; dropdownOpen = !dropdownOpen" wire:click="setCode('FR')" type="button" class="w-full inline-flex px-4 py-2 text-sm text-slate-700 dark:text-slate-200 dark:hover:text-white dark:hover:bg-slate-600 hover:bg-slate-100">
                                                    🇫🇷 France (+33)
                                                </button>
                                                <button x-on:click="country = '🇩🇪  (+49)'; dropdownOpen = !dropdownOpen" wire:click="setCode('DE')" type="button" class="w-full inline-flex px-4 py-2 text-sm text-slate-700 dark:text-slate-200 dark:hover:text-white dark:hover:bg-slate-600 hover:bg-slate-100">
                                                    🇩🇪 Germany (+49)
                                                </button>
                                                <button x-on:click="country = '🇮🇩  (+62)'; dropdownOpen = !dropdownOpen" wire:click="setCode('ID')" type="button" class="w-full inline-flex px-4 py-2 text-sm text-slate-700 dark:text-slate-200 dark:hover:text-white dark:hover:bg-slate-600 hover:bg-slate-100">
                                                    🇮🇩 Indonesia (+62)
                                                </button>
                                                <button x-on:click="country = '🇬🇧  (+44)'; dropdownOpen = !dropdownOpen" wire:click="setCode('GB')" type="button" class="w-full inline-flex px-4 py-2 text-sm text-slate-700 dark:text-slate-200 dark:hover:text-white dark:hover:bg-slate-600 hover:bg-slate-100">
                                                    🇬🇧 United Kingdom (+44)
                                                </button>
                                                <button x-on:click="country = '🇺🇸  (+1)'; dropdownOpen = !dropdownOpen" wire:click="setCode('US')" type="button" class="w-full inline-flex px-4 py-2 text-sm text-slate-700 dark:text-slate-200 dark:hover:text-white dark:hover:bg-slate-600 hover:bg-slate-100">
                                                    🇺🇸 United States (+1)
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" wire:model="form.phone_country">

                                    <div class="w-full relative">
                                        <input wire:model="form.phone" type="text" id="phone" class="w-full block p-5 text-sm text-slate-900 bg-slate-50 rounded-e-lg border border-s-0 border-slate-300 dark:placeholder-slate-400 dark:text-white dark:bg-slate-700 dark:border-slate-600 dark:border-s-slate-700 dark:focus:border-blue-500 focus:border-blue-500 focus:ring-blue-500" placeholder="123-456-7890"/>
                                    </div>
                                </div>

                                @error('form.phone')
                                <x-messages.error :message="$message"></x-messages.error>
                                @enderror
                            </div>

                            {{-- -------------------------------------------- WEBSITE INPUT -------------------------------------------- --}}
                            <div class="flex flex-col pt-3 pb-4">
                                <label for="website" class="mt-2 font-medium text-slate-900 dark:text-white md:mt-0">Website</label>
                                <input wire:model.blur="form.website"
                                        id="website" type="text"
                                        class="w-full p-4 mt-2 rounded-lg border-2 dark:text-slate-200 dark:bg-slate-800 dark:border-slate-600"
                                        placeholder="Ex: website.com">
                                @error('form.website')
                                <x-messages.error :message="$message"></x-messages.error>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
                {{--                 Profile Edit Section END =============== --}}

            </div>
            <!-- Profile Detail END <<<<<<<<<<<<<<<<< -->

            <!-- >>>>>>>>>>>>>>>>>>>>>>>> Social Links START -->
            <div
                class="fixed right-6 bottom-20 flex flex-col bg-slate-200 rounded-xl opacity-75 dark:bg-slate-700 dark:opacity-100">
                <a href="#">
                    <div class="p-2 pt-2 hover:text-primary hover:dark:text-primary">
                        <svg class="text-blue-500 dark:text-blue-400 lg:w-6 lg:h-6 xs:w-4 xs:h-4" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12.51 8.796v1.697a3.738 3.738 0 0 1 3.288-1.684c3.455 0 4.202 2.16 4.202 4.97V19.5h-3.2v-5.072c0-1.21-.244-2.766-2.128-2.766-1.827 0-2.139 1.317-2.139 2.676V19.5h-3.19V8.796h3.168ZM7.2 6.106a1.61 1.61 0 0 1-.988 1.483 1.595 1.595 0 0 1-1.743-.348A1.607 1.607 0 0 1 5.6 4.5a1.601 1.601 0 0 1 1.6 1.606Z"
                                clip-rule="evenodd" />
                            <path d="M7.2 8.809H4V19.5h3.2V8.809Z" />
                        </svg>

                    </div>
                </a>
                <a href="#">
                    <div class="p-2 hover:text-primary hover:dark:text-primary">
                        <svg class="text-slate-900 lg:w-6 lg:h-6 xs:w-4 xs:h-4" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M13.795 10.533 20.68 2h-3.073l-5.255 6.517L7.69 2H1l7.806 10.91L1.47 22h3.074l5.705-7.07L15.31 22H22l-8.205-11.467Zm-2.38 2.95L9.97 11.464 4.36 3.627h2.31l4.528 6.317 1.443 2.02 6.018 8.409h-2.31l-4.934-6.89Z" />
                        </svg>

                    </div>
                </a>
                <a href="#">
                    <div class="p-2 hover:text-blue-500 hover:dark:text-blue-500">
                        <svg class="text-blue-700 dark:text-blue-400 lg:w-6 lg:h-6 xs:w-4 xs:h-4" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </a>
                <a href="#">
                    <div class="p-2 pb-2 hover:text-primary hover:dark:text-primary">
                        <svg class="text-red-600 dark:text-rose-500 lg:w-6 lg:h-6 xs:w-4 xs:h-4" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M21.7 8.037a4.26 4.26 0 0 0-.789-1.964 2.84 2.84 0 0 0-1.984-.839c-2.767-.2-6.926-.2-6.926-.2s-4.157 0-6.928.2a2.836 2.836 0 0 0-1.983.839 4.225 4.225 0 0 0-.79 1.965 30.146 30.146 0 0 0-.2 3.206v1.5a30.12 30.12 0 0 0 .2 3.206c.094.712.364 1.39.784 1.972.604.536 1.38.837 2.187.848 1.583.151 6.731.2 6.731.2s4.161 0 6.928-.2a2.844 2.844 0 0 0 1.985-.84 4.27 4.27 0 0 0 .787-1.965 30.12 30.12 0 0 0 .2-3.206v-1.516a30.672 30.672 0 0 0-.202-3.206Zm-11.692 6.554v-5.62l5.4 2.819-5.4 2.801Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </a>
            </div>
            <!-- >>>>>>>>>>>>>>>>>>>>>>>> Social Links END -->
        </div>
    </div>
</section>

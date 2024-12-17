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
            <li class="text-primary-500 font-medium">Create</li>
            </ol>
        </nav>
    </div>
    <!-- Breadcrumb End -->

    <!-- Create Post Form Start -->
    <div class="w-full p-10 bg-white rounded-md shadow-lg shadow-slate-300 dark:bg-slate-600 dark:shadow-slate-700">
        <form action="{{ route('users.store') }}" id="registrationForm" method="POST" enctype="multipart/form-data">
            @csrf
            <h2 class="text-graydark block mb-2 text-xl font-semibold dark:text-white md:text-md">
                Personal Info
            </h2>

            <hr>

            <section class="grid gap-y-5 my-8 md:grid-cols-2 md:gap-x-8">
                {{-- ============================================================ Fullname Input ============================================================ --}}
                <div class="relative">
                    <label for="fullname" class="text-graydark block mb-2 text-base font-medium dark:text-white md:text-md">Fullname</label>
                    <input type="text" name="fullname" id="fullname" class="bg-gray text-graydark w-full block p-2.5 rounded-lg dark:placeholder-gray-3 dark:text-white dark:bg-slate-700
                    @error('fullname')
                    is-invalid
                    @else
                    is-valid
                    @enderror" placeholder="Enter your fullname" value="{{ old('fullname') }}" autofocus autocomplete="off" required>
                    <svg class="w-6 h-6 text-red-600 dark:text-rose-500
                    @error('fullname')
                    absolute top-11 right-0 mr-3
                    @else
                    hidden
                    @enderror" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    @error('fullname')
                    <x-messages.error :message="$message"></x-messages.error>
                    @enderror
                </div>
                {{-- ============================================================ Email Input ============================================================ --}}
                <div class="relative">
                    <label for="email" class="text-graydark block mb-2 text-base font-medium dark:text-white md:text-md">Email Address</label>
                    <input type="email" name="email" id="email" class="bg-gray text-graydark w-full block p-2.5 rounded-lg dark:placeholder-gray-3 dark:text-white dark:bg-slate-700
                    @error('email')
                    is-invalid
                    @else
                    is-valid
                    @enderror" placeholder="name@domain.com" value="{{ old('email') }}" required>
                    <svg class="w-6 h-6 text-red-600 dark:text-rose-500
                    @error('email')
                    absolute top-11 right-0 mr-3
                    @else
                    hidden
                    @enderror" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    @error('email')
                    <x-messages.error :message="$message"></x-messages.error>
                    @enderror
                </div>
                {{-- ============================================================ Password Input ============================================================ --}}
                <div class="relative">
                    <label for="password" class="text-graydark block mb-2 text-base font-medium dark:text-white md:text-md">Password</label>
                    <input type="password" id="password" name="password" class="bg-gray text-graydark w-full block p-2.5 rounded-lg dark:placeholder-gray-3 dark:text-white dark:bg-slate-700
                    @error('password')
                    is-invalid
                    @else
                    is-valid
                    @enderror" onkeyup="match()" required>
                    <svg class="w-6 h-6 text-red-600 dark:text-rose-500
                    @error('password')
                    absolute top-11 right-0 mr-3
                    @else
                    hidden
                    @enderror" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    @error('password')
                    <x-messages.error :message="$message"></x-messages.error>
                    @enderror
                </div>
                {{-- ============================================================ Confirm Password Input ============================================================ --}}
                <div class="relative">
                    <label for="confirmPassword" class="text-graydark block mb-2 text-base font-medium dark:text-white md:text-md">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" class="bg-gray text-graydark w-full block p-2.5 rounded-lg dark:placeholder-gray-3 dark:text-white dark:bg-slate-700
                    @error('confirmPassword')
                    is-invalid
                    @else
                    is-valid
                    @enderror" onkeyup="match()" required>
                    <svg class="w-6 h-6 text-red-600 dark:text-rose-500
                    @error('confirmPassword')
                    absolute top-11 right-0 mr-3
                    @else
                    hidden
                    @enderror" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    @error('confirmPassword')
                    <x-messages.error :message="$message"></x-messages.error>
                    @enderror
                    {{-- Mismatch Password START --}}
                    <div id='matchMessage'></div>
                    {{-- Mismatch Password END --}}
                </div>
            </section>

            <h2 class="text-graydark block mt-5 mb-2 text-xl font-semibold dark:text-white md:text-md">
                Profile Info
            </h2>

            <hr>

            <section class="grid gap-y-8 my-10 md:grid-cols-2 md:gap-x-16">
                {{-- ============================================================ Username Input ============================================================ --}}
                <div class="relative">
                    <label for="username" class="text-graydark block mb-2 text-base font-medium dark:text-white md:text-md">Username</label>
                    <input type="text" name="username" id="username" class="bg-gray text-graydark w-full block p-2.5 rounded-lg dark:placeholder-gray-3 dark:text-white dark:bg-slate-700
                    @error('username')
                    is-invalid
                    @else
                    is-valid
                    @enderror" placeholder="Enter your username" value="{{ old('username') }}" required>
                    <svg class="w-6 h-6 text-red-600 dark:text-rose-500
                    @error('username')
                    absolute top-11 right-0 mr-3
                    @else
                    hidden
                    @enderror" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    @error('username')
                    <x-messages.error :message="$message"></x-messages.error>
                    @enderror
                    <p class="mt-2 text-sm text-neutral-500 dark:text-gray-2" id="thumbnail_help">This information will be displayed in public</p>
                </div>
                {{-- ============================================================ About Me Input ============================================================ --}}
                <div>
                    <label for="about" class="text-graydark block mb-2 text-base font-medium dark:text-white md:text-md"> About </label>
                    @error('about')
                    <x-messages.error :message="$message"></x-messages.error>
                    @enderror
                    <div class="mt-1">
                        <textarea id="about" name="about" rows="6" class="bg-gray w-full block rounded-md border-2 border-slate-200 shadow-sm dark:placeholder-gray-3 dark:text-white dark:bg-slate-700 dark:border-slate-600 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('about') }}</textarea>
                    </div>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-2">Write a few sentences about yourself!</p>
                </div>
            </section>

            <h2 class="text-graydark block mt-5 mb-2 text-xl font-semibold dark:text-white md:text-md">
                Profile Display
            </h2>

            <hr>

            <section>
                <div class="w-full mt-5 dark:bg-slate-600">
                    <div class="mx-auto w-full">
                        <!-- User Profile Cover -->
                        <img src="{{ asset('IMG/default/default_background.jpeg') }}" alt="Default Profile Cover" id="cover_preview"
                                class="max-h-50 w-full object-fill rounded-md lg:max-h-75" />

                        <!-- User Profile Picture -->
                        <div class="mb-25 mx-auto w-full relative flex justify-center">
                            <img src="{{ asset('IMG/default/default_user.png') }}" alt="Default Profile Picture" id="profile_preview"
                                    class="-bottom-5 w-20 h-20 object-cover absolute rounded-full outline-2 outline-sky-400 outline outline-offset-2 shadow-xl lg:-bottom-15 lg:w-35 lg:h-35 md:w-30 md:h-30 md:-bottom-10" />
                        </div>
                    </div>
                </div>

                <div class="[&_div]:mb-4 md:grid md:grid-cols-2 md:gap-x-16 md:gap-y-4 w-full">
                    {{-- ============================================================ Profile Picture Upload ============================================================ --}}
                    <div>
                        <label class="text-graydark block mb-3 text-base font-medium dark:text-white md:text-md" for="profile_pic">Profile Picture</label>
                        <button type="button" id="profile_default" class="hidden px-5 py-2.5 me-2 mb-2 text-sm font-medium text-white bg-sky-700 rounded-lg dark:bg-sky-600 dark:focus:ring-sky-900 dark:hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-300 hover:bg-sky-800" onclick="profileDefault()">
                            Use Default
                        </button>
                        <input class="border-gray-2 text-graydark w-full block ml-0 text-sm bg-neutral-50 rounded-lg border cursor-pointer dark:text-gray-3 dark:placeholder-neutral-400 dark:bg-neutral-700 dark:border-neutral-600 focus:outline-none lg:w-4/6 md:ml-10" aria-describedby="profile_pic_help" id="profile_pic" name="profile_pic" type="file" onchange="handleImageChange(this)">
                        @error('profile_pic')
                        <x-messages.error :message="$message"></x-messages.error>
                        @enderror
                        <p class="mt-2 ml-10 text-sm text-neutral-500 dark:text-gray-2" id="thumbnail_help">PNG, JPG or JPEG (Max: 1 MB)</p>
                    </div>
                    {{-- ============================================================ Profile Cover Input ============================================================ --}}
                    <div>
                        <label for="profile_cover" class="text-graydark block mb-2 text-base font-medium dark:text-white md:text-md">Profile Cover</label>
                        <button type="button" id="cover_default" class="hidden px-5 py-2.5 me-2 mb-2 text-sm font-medium text-white bg-sky-700 rounded-lg dark:bg-sky-600 dark:focus:ring-sky-900 dark:hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-300 hover:bg-sky-800" onclick="coverDefault()">
                            Use Default
                        </button>
                        <div class="max-w-md relative flex justify-center px-6 pt-5 pb-6 mt-1 rounded-md border-2 border-gray-300 border-dashed">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto w-12 h-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-slate-600">
                                    <label for="profile_cover" class="relative font-medium text-indigo-600 rounded-md cursor-pointer dark:font-semibold dark:text-white dark:hover:text-slate-200 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <span>Upload a file</span>
                                        <input id="profile_cover" name="profile_cover" type="file" class="sr-only" onchange="handleCoverChange(this)">
                                    </label>
                                    <p class="pl-1 dark:text-slate-300">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-2">PNG, JPG, JPEG up to 2MB</p>
                            </div>
                        </div>
                        @error('profile_cover')
                        <x-messages.error :message="$message"></x-messages.error>
                        @enderror
                    </div>
                </div>
            </section>

            <h2 class="text-graydark block mb-2 text-xl font-semibold dark:text-white md:text-md">
                Admin Rights
            </h2>

            <hr>

            <section>
                {{-- ============================================================ Admin Rights Selection ============================================================ --}}
                <div class="mb-15">
                    <label for="is_admin" class="block mt-2 mb-2 text-sm font-medium text-neutral-800 dark:text-white md:text-md">Set this user as an admin?</label>
                    <select id="is_admin" name="is_admin" class="border-gray-2 w-20 block p-2.5 text-sm text-neutral-800 bg-slate-50 rounded-lg border dark:bg-graydark dark:placeholder-slate-400 dark:text-white dark:border-slate-600 dark:focus:border-blue-500 dark:focus:ring-blue-500 focus:border-blue-500 focus:ring-blue-500">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </section>

            <div class="flex flex-col items-center">
                <button type="submit" class="bg-primary-600 w-full px-5 py-2.5 mt-5 text-lg font-medium text-white rounded-lg dark:bg-primary-600 dark:focus:ring-primary-800 dark:hover:bg-primary-700 focus:ring-primary-300 focus:outline-none focus:ring-4 hover:bg-primary-700 md:max-w-md">Register</button>
            </div>
        </form>
    </div>
    <!-- Create Post Form End -->

    @push('scripts')
    <script src="{{ asset('JS/admin-users.js') }}"></script>
    @endpush
</x-layouts.dashboard-layout>

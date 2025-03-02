<x-layouts.base-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <section class="bg-gray-50 dark:bg-gray-800">
        <div class="mx-auto flex flex-col justify-center items-center px-6 py-8">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo">
                Flowbite
            </a>
            <div class="w-full bg-white rounded-lg shadow dark:bg-gray-900 dark:border dark:border-gray-700 md:mt-0 sm:max-w-md xl:p-0">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold tracking-tight leading-tight text-center text-gray-900 dark:text-white md:text-2xl">
                        Sign up a new account!
                    </h1>
                    <form class="space-y-6" action="{{ route('register.store') }}" method="POST" x-data="formSubmit" @submit.prevent="submit">
                        @csrf
                        {{-- ------------------------------------------------- USERNAME INPUT ------------------------------------------------- --}}
                        <div class="relative">
                            <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                            <input type="text" name="username" id="username" class="w-full block p-2.5 text-gray-900 bg-gray-50 rounded-lg dark:placeholder-gray-400 dark:text-white dark:bg-gray-700
                            @error('username')
                            is-invalid
                            @else
                            is-valid
                            @enderror" placeholder="Enter username" value="{{ old('username') }}" required="" autofocus autocomplete="off">
                            <svg class="w-6 h-6 text-red-600 dark:text-white
                            @error('username')
                            absolute bottom-0 top-10 right-0 mr-3
                            @else
                            hidden
                            @enderror" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            @error('username')
                            <x-messages.error :message="$message"></x-messages.error>
                            @enderror
                        </div>

                        {{-- ------------------------------------------------- FULLNAME INPUT ------------------------------------------------- --}}
                        <div class="relative">
                            <label for="fullname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fullname</label>
                            <input type="text" name="fullname" id="fullname" class="w-full block p-2.5 text-gray-900 bg-gray-50 rounded-lg dark:placeholder-gray-400 dark:text-white dark:bg-gray-700
                            @error('fullname')
                            is-invalid
                            @else
                            is-valid
                            @enderror" placeholder="Enter fullname" value="{{ old('fullname') }}" required="" autocomplete="off">
                            <svg class="w-6 h-6 text-red-600 dark:text-white
                            @error('fullname')
                            absolute bottom-0 top-10 right-0 mr-3
                            @else
                            hidden
                            @enderror" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            @error('fullname')
                            <x-messages.error :message="$message"></x-messages.error>
                            @enderror
                        </div>

                        {{-- ------------------------------------------------- EMAIL ADDRESS INPUT ------------------------------------------------- --}}
                        <div class="relative">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">E-Mail</label>
                            <input type="email" name="email" id="email" class="w-full block p-2.5 text-gray-900 bg-gray-50 rounded-lg dark:placeholder-gray-400 dark:text-white dark:bg-gray-700
                            @error('email')
                            is-invalid
                            @else
                            is-valid
                            @enderror" placeholder="username@domain.com" value="{{ old('email') }}" required="" autocomplete="off">
                            <svg class="w-6 h-6 text-red-600 dark:text-white
                            @error('email')
                            absolute bottom-0 top-10 right-0 mr-3
                            @else
                            hidden
                            @enderror" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            @error('email')
                            <x-messages.error :message="$message"></x-messages.error>
                            @enderror
                        </div>

                        {{-- ------------------------------------------------- PASSWORD INPUT ------------------------------------------------- --}}
                        <div class="relative">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password" class="w-full block p-2.5 text-gray-900 bg-gray-50 rounded-lg dark:placeholder-gray-400 dark:text-white dark:bg-gray-700
                            @error('password')
                            is-invalid
                            @else
                            is-valid
                            @enderror" placeholder="••••••••" required="" autocomplete="off">
                            <svg class="w-6 h-6 text-red-600 dark:text-white
                            @error('password')
                            absolute bottom-0 top-10 right-0 mr-3
                            @else
                            hidden
                            @enderror" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            @error('password')
                            <x-messages.error :message="$message"></x-messages.error>
                            @enderror
                        </div>

                        {{-- ------------------------------------------------- SUBMIT BUTTON ------------------------------------------------- --}}
                        <button x-ref="btn" id="btn" type="submit" class="bg-primary-600 btn w-full relative px-5 py-2.5 text-sm font-medium text-center text-white rounded-lg dark:bg-primary-600 dark:focus:ring-primary-800 dark:hover:bg-primary-700 focus:ring-primary-300 focus:outline-none focus:ring-4 hover:bg-primary-700">Register</button>

                        {{-- ------------------------------------------------- LOGIN OPTION ------------------------------------------------- --}}
                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                            Already have an existing account? <a href="/login" class="text-primary-600 font-medium dark:text-primary-500 hover:underline">Log in</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('JS/register.js') }}"></script>
</x-layouts.base-layout>

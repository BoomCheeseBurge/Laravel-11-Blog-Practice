<x-layouts.base-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <section class="bg-gray-100 dark:bg-gray-800">
        <div class="mx-auto flex flex-col justify-center items-center px-6 py-8 lg:py-0 md:h-screen">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo">
                Flowbite
            </a>

            {{-- ------------------------------------ Successful Message ------------------------------------ --}}
            @if (session()->has('success'))
            <x-messages.dismissal-success :message="session('success')" class="w-1/2 mb-4"></x-messages.dismissal-success>
            @endif

            {{-- ------------------------------------ Failed Message ------------------------------------ --}}
            @if (session()->has('failed'))
            <x-messages.dismissal-error :message="session('failed')" class="mb-4"></x-messages.dismissal-error>
            @endif

            <div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 dark:border dark:border-gray-700 md:mt-0 sm:max-w-md xl:p-0">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold tracking-tight leading-tight text-center text-gray-900 dark:text-white md:text-2xl">
                        Sign in to your account
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="{{ route('login.authenticate') }}" method="POST">
                        @csrf
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">E-Mail</label>
                            <input type="email" name="email" id="email" class="w-full block p-2.5 text-gray-900 bg-gray-50 rounded-lg border border-gray-300 dark:placeholder-gray-400 dark:text-white dark:bg-gray-700 dark:border-gray-600 dark:focus:border-blue-500 dark:focus:ring-blue-500 focus:ring-primary-600 focus:border-primary-600" placeholder="name@company.com" required="" autofocus>
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="w-full block p-2.5 text-gray-900 bg-gray-50 rounded-lg border border-gray-300 dark:placeholder-gray-400 dark:text-white dark:bg-gray-700 dark:border-gray-600 dark:focus:border-blue-500 dark:focus:ring-blue-500 focus:ring-primary-600 focus:border-primary-600" required="">
                        </div>
                        <div class="flex justify-between items-center">
                            <a href="#" class="text-primary-600 text-sm font-medium dark:text-primary-500 hover:underline">Forgot password?</a>
                        </div>
                        <button type="submit" class="bg-primary-600 w-full px-5 py-2.5 text-sm font-medium text-center text-white rounded-lg dark:bg-primary-600 dark:focus:ring-primary-800 dark:hover:bg-primary-700 focus:ring-primary-300 focus:outline-none focus:ring-4 hover:bg-primary-700">Sign in</button>
                        <p class="text-sm font-light text-gray-500 dark:text-gray-300">
                            Don’t have an account yet? <a href="/register" class="text-primary-600 font-medium dark:text-primary-500 hover:underline">Sign up</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

</x-layouts.base-layout>

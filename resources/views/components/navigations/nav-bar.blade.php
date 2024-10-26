<nav class="bg-gray-800" x-data="{ isOpen: false }">
    <div class="mx-auto max-w-7xl px-4 lg:px-8 sm:px-6">
        <div class="h-16 flex justify-between items-center">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img class="w-8 h-8" src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company">
                </div>
                <div class="hidden md:block">
                    <div class="flex items-baseline ml-10 space-x-4">
                        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                        <x-navigations.nav-link href="/" :active="request()->is('/')" class="text-sm">Home</x-navigations.nav-link>
                        <x-navigations.nav-link href="/about" :active="request()->is('about')" class="text-sm">About</x-navigations.nav-link>
                        <x-navigations.nav-link href="/posts" :active="request()->is('posts')" class="text-sm">Blog</x-navigations.nav-link>
                        <x-navigations.nav-link href="/contact" :active="request()->is('contact')" class="text-sm">Contact</x-navigations.nav-link>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="flex items-center ml-4 md:ml-6">

                    <!-- Profile dropdown -->
                    <div class="relative ml-3">
                        <div>
                            <button type="button" x-on:click="isOpen = !isOpen"
                            class="max-w-xs relative flex items-center text-sm bg-gray-800 rounded-full focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="-inset-1.5 absolute"></span>
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            </button>
                        </div>

                        <!--
                        Dropdown menu, show/hide based on menu state.

                        Entering: "transition ease-out duration-100"
                            From: "transform opacity-0 scale-95"
                            To: "transform opacity-100 scale-100"
                        Leaving: "transition ease-in duration-75"
                            From: "transform opacity-100 scale-100"
                            To: "transform opacity-0 scale-95"
                        -->
                        <div x-show="isOpen"
                        x-transition:enter="transition ease-out duration-100 transform"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75 transform"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="ring-opacity-5 w-48 absolute right-0 z-10 py-1 mt-2 bg-white rounded-md ring-1 ring-black shadow-lg origin-top-right focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <!-- Active: "bg-gray-100", Not Active: "" -->
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="-mr-2 flex md:hidden">
                <!-- Mobile menu button -->
                <button type="button" x-on:click="isOpen = !isOpen"
                class="relative inline-flex justify-center items-center p-2 text-gray-400 bg-gray-800 rounded-md focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 hover:text-white hover:bg-gray-700" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="-inset-0.5 absolute"></span>
                    <span class="sr-only">Open main menu</span>
                    <!-- Menu open: "hidden", Menu closed: "block" -->
                    <svg x-bind:class="{'hidden': isOpen, 'block': !isOpen }" class="w-6 h-6 block" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!-- Menu open: "block", Menu closed: "hidden" -->
                    <svg x-bind:class="{'block': isOpen, 'hidden': !isOpen }" class="w-6 h-6 hidden" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div x-show="isOpen" class="md:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <x-navigations.nav-link href="/" :active="request()->is('/')" class="block text-base">Home</x-navigations.nav-link>
            <x-navigations.nav-link href="/about" :active="request()->is('about')" class="block text-base">About</x-navigations.nav-link>
            <x-navigations.nav-link href="/posts" :active="request()->is('posts')" class="block text-base">Blog</x-navigations.nav-link>
            <x-navigations.nav-link href="/contact" :active="request()->is('contact')" class="block text-base">Contact</x-navigations.nav-link>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-700">
            <div class="flex items-center px-5">
                <div class="flex-shrink-0">
                    <img class="w-10 h-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium leading-none text-white">Tom Cook</div>
                    <div class="text-sm font-medium leading-none text-gray-400">tom@example.com</div>
                </div>
            </div>
            <div class="px-2 mt-3 space-y-1">
                <a href="#" class="block px-3 py-2 text-base font-medium text-gray-400 rounded-md hover:text-white hover:bg-gray-700">Your Profile</a>
                <a href="#" class="block px-3 py-2 text-base font-medium text-gray-400 rounded-md hover:text-white hover:bg-gray-700">Settings</a>
                <a href="#" class="block px-3 py-2 text-base font-medium text-gray-400 rounded-md hover:text-white hover:bg-gray-700">Sign out</a>
            </div>
        </div>
    </div>
</nav>

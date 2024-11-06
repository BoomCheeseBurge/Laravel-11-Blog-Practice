<x-layouts.base-layout :title="$title">
    <x-slot:title>{{ $title }}</x-slot:title>

    <!--
    This example requires some changes to your config:

    ```
    // tailwind.config.js
    module.exports = {
        // ...
        plugins: [
        // ...
        require('@tailwindcss/forms'),
        ],
    }
    ```
    -->
    <div class="isolate px-6 py-24 bg-slate-50 rounded-md dark:bg-slate-800 lg:px-8 sm:py-32">
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="font-serif text-4xl font-semibold tracking-tight text-balance text-gray-900 dark:text-slate-100 sm:text-5xl">Contact Us</h2>
            <p class="text-lg/8 mt-2 text-gray-600 dark:text-gray-300">Have questions to ask or an assistant on a trouble?</p>
        </div>
        <form action="#" method="POST" class="mx-auto max-w-xl mt-10 text-gray-900 dark:text-gray-300 sm:mt-15 [&>div>div>div>input]:dark:bg-slate-700 [&>div>div>div>input]:dark:text-slate-300">
            <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                <div>
                    <label for="first-name" class="text-sm/6 block font-semibold">First name</label>
                    <div class="mt-2.5">
                        <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="w-full block px-3.5 py-2 rounded-md border-0 ring-1 ring-inset ring-gray-300 shadow-sm focus:ring-2 focus:ring-inset focus:ring-indigo-600 placeholder:text-gray-400 sm:text-sm/6">
                    </div>
                </div>
                <div>
                    <label for="last-name" class="text-sm/6 block font-semibold">Last name</label>
                    <div class="mt-2.5">
                        <input type="text" name="last-name" id="last-name" autocomplete="family-name" class="w-full block px-3.5 py-2 rounded-md border-0 ring-1 ring-inset ring-gray-300 shadow-sm focus:ring-2 focus:ring-inset focus:ring-indigo-600 placeholder:text-gray-400 sm:text-sm/6">
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="company" class="text-sm/6 block font-semibold">Company</label>
                    <div class="mt-2.5">
                        <input type="text" name="company" id="company" autocomplete="organization" class="w-full block px-3.5 py-2 rounded-md border-0 ring-1 ring-inset ring-gray-300 shadow-sm focus:ring-2 focus:ring-inset focus:ring-indigo-600 placeholder:text-gray-400 sm:text-sm/6">
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="email" class="text-sm/6 block font-semibold">Email</label>
                    <div class="mt-2.5">
                        <input type="email" name="email" id="email" autocomplete="email" class="w-full block px-3.5 py-2 rounded-md border-0 ring-1 ring-inset ring-gray-300 shadow-sm focus:ring-2 focus:ring-inset focus:ring-indigo-600 placeholder:text-gray-400 sm:text-sm/6">
                    </div>
                </div>
                <div class="sm:col-span-2">
                <label for="phone-number" class="text-sm/6 block font-semibold">Phone number</label>
                    <div class="relative mt-2.5">
                        <div class="absolute inset-y-0 left-0 flex items-center">
                        <label for="country" class="sr-only">Country</label>
                        <select id="country" name="country" class="h-full py-0 pr-9 pl-4 text-gray-400 bg-transparent bg-none [&>option]:bg-slate-100 [&>option]:text-boxdark-2 rounded-md border-0 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                            <option>US</option>
                            <option>CA</option>
                            <option>EU</option>
                        </select>
                        <svg class="w-5 h-full absolute top-0 right-1.5 text-gray-400 pointer-events-none" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                        </div>
                        <input type="tel" name="phone-number" id="phone-number" autocomplete="tel" class="w-full block px-3.5 py-2 pl-20 text-gray-900 rounded-md border-0 ring-1 ring-inset ring-gray-300 shadow-sm focus:ring-2 focus:ring-inset focus:ring-indigo-600 placeholder:text-gray-400 sm:text-sm/6">
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="message" class="text-sm/6 block font-semibold text-gray-900 dark:text-gray-300">Message</label>
                    <div class="mt-2.5">
                        <textarea name="message" id="message" rows="4" class="w-full block px-3.5 py-2 text-gray-900 rounded-md border-0 ring-1 ring-inset ring-gray-300 shadow-sm dark:text-slate-300 dark:bg-slate-700 focus:ring-2 focus:ring-inset focus:ring-indigo-600 placeholder:text-gray-400 sm:text-sm/6"></textarea>
                    </div>
                </div>
                <div class="flex gap-x-4 sm:col-span-2">
                    <div class="h-6 flex items-center">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="peer sr-only">
                            <span class="sr-only">Agree to policies</span>
                            <div class="peer w-9 h-5 relative bg-gray-200 rounded-full after:content-[ dark:bg-gray-700 dark:peer-focus:ring-blue-800 peer-checked:after:border-white peer-checked:after:translate-x-full peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rtl:peer-checked:after:-translate-x-full''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    <label class="text-sm/6 text-gray-600 dark:text-gray-300" id="switch-1-label">
                        By selecting this, you agree to our
                        <a href="#" class="font-semibold text-indigo-600">privacy&nbsp;policy</a>.
                    </label>
                </div>
            </div>
            <div class="mt-10">
                <button type="submit" class="w-full block px-3.5 py-2.5 text-base font-semibold text-center text-white bg-indigo-600 rounded-md shadow-sm focus-visible:outline-2 focus-visible:outline-indigo-600 focus-visible:outline focus-visible:outline-offset-2 hover:bg-indigo-500">Send</button>
            </div>
        </form>
    </div>
</x-layouts.base-layout>

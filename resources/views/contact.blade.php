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
        <form x-data="{ agreed : false }" action="#" method="POST" 
            class="mx-auto max-w-xl mt-10 text-gray-900 dark:text-gray-300 sm:mt-15 [&_input]:dark:bg-slate-700 [&_input]:dark:text-slate-300 [&_textarea]:dark:bg-slate-700 [&_textarea]:dark:text-slate-300">
            @csrf
            <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                <div>
                    <x-input.group :error="$errors->first('firstName')">
                        <x-input.label icon="user">First Name</x-input.label>
                        
                        <x-input.text name="first-name" class="mt-2.5" autofocus autocomplete="off"></x-input.text>
                    </x-input.group>
                </div>
                
                <div>
                    <x-input.group :error="$errors->first('lastName')">
                        <x-input.label>Last Name</x-input.label>

                        <x-input.text name="last-name" class="mt-2.5" autocomplete="off"></x-input.text>
                    </x-input.group>
                </div>

                <div class="sm:col-span-2">
                    <x-input.group :error="$errors->first('company')">
                        <x-input.label icon="company">Company</x-input.label>

                        <x-input.text name="company" class="mt-2.5" autocomplete="off"></x-input.text>
                    </x-input.group>
                </div>

                <x-input.group class="sm:col-span-2" :error="$errors->first('email')">
                    <x-input.label icon="mailbox">E-Mail</x-input.label>

                    <x-input.email class="mt-2.5" name="email"></x-input.email>
                </x-input.group>

                <x-input.group class="sm:col-span-2" :error="$errors->first('phone')">
                    <x-input.label icon="phone">Phone Number</x-input.label>

                    <x-input.phone class="mt-2.5"></x-input.phone>
                </x-input.group>

                <div class="sm:col-span-2">
                    <x-input.group :error="$errors->first('message')">
                        <x-input.label>Message</x-input.label>

                        <x-input.textarea name="message" class="mt-2.5" rows="4"></x-input.textarea>
                    </x-input.group>
                </div>

                <x-input.group class="flex gap-x-4 sm:col-span-2" :error="$errors->first('terms')">
                    <x-input.toggle name="terms" x-model="agreed"></x-input.toggle>

                    <x-input.label>
                        By selecting this, you agree to our
                        <a href="#" class="font-semibold text-indigo-600">privacy&nbsp;policy</a>.
                    </x-input.label>
                </x-input.group>
            </div>
            <div class="mt-10">
                <button x-bind:disabled="!agreed" type="submit" class="w-full block px-3.5 py-2.5 text-base font-semibold text-center text-white bg-indigo-600 rounded-md shadow-sm focus-visible:outline-2 focus-visible:outline-indigo-600 focus-visible:outline focus-visible:outline-offset-2 hover:bg-indigo-500">Send</button>
            </div>
        </form>
    </div>
</x-layouts.base-layout>

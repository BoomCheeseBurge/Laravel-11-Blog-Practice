<x-layouts.base-layout :title="$title">
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="max-w-screen-xl items-center sm:flex">
        <div class="p-5 sm:w-1/2">
            <div class="text">
                <span class="text-gray-500 uppercase border-b-2 border-indigo-600 dark:text-gray-300">Email has been sent!</span>
                <p class="text-gray-700 dark:text-gray-200">
                    Kindly check your mailbox...
                </p>
            </div>
        </div>
    </div>
</x-layouts.base-layout>

<x-layouts.base-layout :title="$title">
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="max-w-screen-xl items-center sm:flex">
        <div class="p-10 sm:w-1/2">
            <div class="image object-center text-center">
                <img src="{{ asset('IMG/app/about-cover.png') }}">
            </div>
        </div>
        <div class="p-5 sm:w-1/2">
            <div class="text">
                <span class="text-gray-500 uppercase border-b-2 border-indigo-600 dark:text-gray-300">About us</span>
                <h2 class="my-4 text-3xl font-bold sm:text-4xl">About <span class="text-indigo-600">Blog Post</span>
                </h2>
                <p class="text-gray-700 dark:text-gray-200">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, commodi
                    doloremque, fugiat illum magni minus nisi nulla numquam obcaecati placeat quia, repellat tempore
                    voluptatum.
                </p>
            </div>
        </div>
    </div>
</x-layouts.base-layout>

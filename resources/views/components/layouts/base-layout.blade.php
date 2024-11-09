<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        {{-- Vite to dynamically import the processed Tailwind CSS file during the build process --}}
        @vite(['resources/css/app.css','resources/js/app.js'])

        {{-- TalwindUI's Default Font for their Components --}}
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

        {{-- TalwindUI's Default Font for their Components --}}
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

        <title>{{ $title }}</title>
    </head>

    <body x-cloak class="h-full"
            x-data="{ isOpen: false , 'loaded': true, 'darkMode': true }"
            x-init="
                darkMode = JSON.parse(localStorage.getItem('darkMode'));
                $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
            :class="{'dark text-bodydark bg-boxdark-2': darkMode === true}">
        <!--
        This example requires updating your template:

        ```
        <html class="h-full bg-gray-100">
        <body class="h-full">
        ```
        -->
        <div class="min-h-full bg-gray-100 dark:bg-gray-800">
            <x-navigations.nav-bar></x-navigations.nav-bar>

            @if (Route::currentRouteName() != 'home')
            <x-headers.base-header>{{ $title }}</x-headers.base-header>
            @endif

            <main>
                <div class="mx-auto {{ Route::currentRouteName() == 'home' ? 'w-full h-auto' : 'max-w-7xl px-4 py-6 lg:px-8 sm:px-6' }}">
                    <!-- Your content -->
                    {{ $slot }}
                </div>
            </main>
        </div>

        {{-- AlpineJS Bundled Script --}}
        <script src="{{ asset('JS/alpine.js') }}"></script>
    </body>
</html>

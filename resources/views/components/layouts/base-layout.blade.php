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

    <title>Home</title>
</head>
<body class="h-full">
    <!--
    This example requires updating your template:

    ```
    <html class="h-full bg-gray-100">
    <body class="h-full">
    ```
    -->
    <div class="min-h-full">
        <x-navigations.nav-bar></x-navigations.nav-bar>

        <x-headers.base-header>{{ $title }}</x-headers.base-header>

        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 lg:px-8 sm:px-6">
                <!-- Your content -->
                {{ $slot }}
            </div>
        </main>
    </div>

    {{-- AlpineJS Bundled Script --}}
    <script src="{{ asset('JS/alpine.js') }}"></script>
</body>
</html>

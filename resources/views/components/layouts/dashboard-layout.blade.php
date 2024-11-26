<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {{-- Vite to dynamically import the processed Tailwind CSS file during the build process --}}
    @vite(['resources/css/app.css','resources/js/app.js'])

    {{-- Ziggy's Laravel Route Helper JS --}}
    @routes

    {{-- TalwindUI's Default Font for their Components --}}
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    {{-- Trix Editor Style --}}
    <link rel="stylesheet" href="{{ asset('CSS/trix.css') }}">

    {{-- Custom CSS Style --}}
    <link rel="stylesheet" href="{{ asset('CSS/style.css') }}">

    {{-- Livewire Style --}}
    @livewireStyles

    <title>
      {{ $title }} | TailAdmin
    </title>
  </head>

  <body class="dashboard-body"
    x-data="{ page: '{{ $page }}', 'loaded': true, 'darkMode': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark text-bodydark bg-boxdark-2': darkMode === true}"
  >
        <!-- ===== Page Wrapper Start ===== -->
        <div class="h-screen overflow-hidden flex">
            <!-- ===== Sidebar Start ===== -->
                <x-navigations.side-bar></x-navigations.side-bar>
            <!-- ===== Sidebar End ===== -->

            <!-- ===== Content Area Start ===== -->
            <div class="overflow-y-auto overflow-x-hidden relative flex flex-col flex-1">
                <!-- ===== Header Start ===== -->
                <x-headers.dashboard-header></x-headers.dashboard-header>
                <!-- ===== Header End ===== -->

                <!-- ===== Main Content Start ===== -->
                <main>
                    <div class="mx-auto max-w-screen-2xl p-4 2xl:p-10 md:p-6">
                        {{ $slot }}
                    </div>
                </main>
                <!-- ===== Main Content End ===== -->
            </div>
        <!-- ===== Content Area End ===== -->
        </div>
        <!-- ===== Page Wrapper End ===== -->

        {{-- LiveWire Script with AlpineJS included--}}
        @livewireScripts

        {{-- Custom Scripts --}}
        @stack('scripts')
    </body>
</html>

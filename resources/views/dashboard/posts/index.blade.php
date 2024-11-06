<x-layouts.dashboard-layout :page="$page" :title="$title">
    <!-- Breadcrumb Start -->
    <div
    class="flex flex-col gap-3 mb-6 sm:flex-row sm:justify-between sm:items-center"
    >
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            {{ $subTitle }}
        </h2>

        <nav>
            <ol class="flex items-center gap-2">
            <li>
                <div class="font-medium">{{ $title }} /</div>
            </li>
            <li class="text-primary-500 font-medium">Tables</li>
            </ol>
        </nav>
    </div>
    <!-- Breadcrumb End -->

    {{-- ------------------------------------ Successful Message ------------------------------------ --}}
    @if (session()->has('success'))
    <x-messages.dismissal-success :message="session('success')" class="mb-4"></x-messages.dismissal-success>
    @endif

    <!-- ====== Table Section Start -->
    <div class="flex flex-col gap-10">
        <x-tables.table id actions :headers="$headers" :columns="$columns" :records="$posts" route="post"></x-tables.table>
    </div>
    <!-- ====== Table Section End -->

    @push('scripts')
    <script src="{{ asset('JS/dashboard-table.js') }}"></script>
    @endpush
</x-layouts.dashboard-layout>

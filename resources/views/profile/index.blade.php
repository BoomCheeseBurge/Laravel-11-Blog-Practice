<x-layouts.dashboard-layout :page="$page" :title="$title">
    <!-- Breadcrumb Start -->
    <div
    class="flex flex-col gap-3 mb-6 sm:flex-row sm:justify-between sm:items-center"
    >
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            {{ $subTitle }}
        </h2>
    </div>
    <!-- Breadcrumb End -->

    <livewire:user.profile :user="$user">

    @push('scripts')
    <x-livewire-alert::scripts />
    @endpush
</x-layouts.dashboard-layout>

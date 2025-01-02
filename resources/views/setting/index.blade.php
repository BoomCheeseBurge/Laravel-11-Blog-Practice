<x-layouts.base-layout :title="$title">
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- ------------------------------------ Successful Message ------------------------------------ --}}
    @if (session()->has('success'))
    <x-messages.dismissal-success :message="session('success')" class="w-1/2 mb-4"></x-messages.dismissal-success>
    @endif
    {{-- ------------------------------------ Successful Message ------------------------------------ --}}
    
    <div class="max-w-screen-xl items-stretch p-5 bg-slate-200 rounded-sm dark:bg-slate-700 sm:flex">
        <div class="border-primary-500 space-y-15 p-5 border-b-2 sm:w-1/2 sm:border-r-2 sm:border-b-0">
            <div>
                <span class="text-gray-500 uppercase border-b-2 border-indigo-600 dark:text-gray-300">E-Mail Address Configuration</span>

                <livewire:setting.email-config :user="$user">
            </div>

            <div>
                <span class="text-gray-500 uppercase border-b-2 border-indigo-600 dark:text-gray-300">Password Configuration</span>
                
                <livewire:setting.password-change :user="$user">
            </div>
        </div>

        <div class="p-10 space-y-5 sm:w-1/2">
            <div>
                @if (auth()->user()->profile_pic)
                <img src="{{ Storage::disk('profile')->url(auth()->user()->profile_pic) }}" alt="{{ auth()->user()->username }} Profile Picture" class="h-15 w-15 rounded-full md:w-20 md:h-20">
                @else
                <div class="h-15 text-primary-500 w-15 pt-4 text-2xl font-semibold tracking-widest text-center bg-slate-100 rounded-full border border-slate-300 dark:border-none md:w-20 md:h-20 md:pt-6">
                {{ strtoupper(implode('', array_map(fn($n) => $n[0], array_slice(explode(' ', auth()->user()->fullname), 0, 2)))); }}
                </div>
                @endif
            </div>

            <div>
                <a href="{{ route('user.profile', ['user' => auth()->user()->username]) }}" class="hover:underline">Edit Profile</a>
            </div>
        </div>
    </div>

    @stack('scripts')
</x-layouts.base-layout>

<x-layouts.base-layout :title="$title">
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- ------------------------------------ Status Message ------------------------------------ --}}
    @if (session()->has('status'))
        <x-messages.dismissal-success :message="session('status')" wire:ignore wire:key="1" class="mb-4"></x-messages.dismissal-success>
    @endif

    {{-- ------------------------------------ Error Email Message ------------------------------------ --}}
    @if ($errors->has('email')) 
        <x-messages.dismissal-error :message="$errors->first('email')" wire:ignore wire:key="2" class="mb-4"></x-messages.dismissal-error>
    @endif
    
    <img class="h-13 w-17 mx-auto mb-5" src="{{ asset('IMG/logo/book-logo-2.jpg') }}" alt="Logo">
    
    <div class="mx-auto max-w-screen-sm flex flex-col justify-center items-center p-10 text-slate-700 bg-slate-200 rounded-lg dark:text-slate-200 dark:bg-slate-700">
        <h2 class="text-xl lg:text-3xl md:text-2xl">Forgot your password?</h2>
        <h5 class="mt-3 text-sm lg:text-base md:text-lg">Please enter your email below to request for a password reset link.</h5>
        <div class="w-full flex flex-col justify-center items-center p-5 mt-5 space-y-8">
            <form action="{{ route('password.email') }}" method="POST" class="w-full flex flex-col items-center">
                @csrf
                <label for="email" class="text-sm">E-mail Address:</label>
                <input type="email" name="email" id="email" class="bg-primary-200 w-10/12 mt-3 text-center rounded-md dark:text-boxdark-2 dark:bg-slate-200"  autofocus autocomplete="off">
                @error('email')
                <x-messages.error :message="$message"></x-messages.error>
                @enderror

                <button type="submit" class="bg-primary-600 w-1/2 px-4 py-2 mt-12 text-center text-white rounded-md">Send Request Link</button>
            </form>

            <a href="{{ route('login.index') }}" class="text-primary-500 text-sm underline hover:no-underline">Back to Login</a>
        </div>
    </div>
</x-layouts.base-layout>

<x-layouts.base-layout :title="$title">
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- ------------------------------------ Successful Message ------------------------------------ --}}
    @if (session()->has('success'))
    <x-messages.dismissal-success :message="session('success')" class="w-1/2 mb-4"></x-messages.dismissal-success>
    @endif
    {{-- ------------------------------------ Successful Message ------------------------------------ --}}

    {{-- ------------------------------------ Error Email Message ------------------------------------ --}}
    @if ($errors->has('email')) 
        <x-messages.dismissal-error :message="$errors->first('email')" wire:ignore wire:key="2" class="mb-4"></x-messages.dismissal-error>
    @endif
    
    <img class="h-13 w-17 mx-auto mb-5" src="{{ asset('IMG/logo/book-logo-2.jpg') }}" alt="Logo">
    
    <div class="mx-auto max-w-screen-sm flex flex-col justify-center items-center p-10 text-slate-700 bg-slate-200 rounded-lg dark:text-slate-200 dark:bg-slate-700">
        <h2 class="text-lg text-center lg:text-2xl md:text-xl">Fill in the form below to reset your password.</h2>
        <div class="w-full flex flex-col justify-center items-center p-5 mt-5 space-y-8">
            <form action="{{ route('password.update') }}" method="POST" class="w-full flex flex-col items-center gap-3">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="mx-auto">
                    <label for="email" class="text-sm">E-mail Address:</label>
                    <input type="email" name="email" id="email" class="bg-primary-200 w-full mt-3 rounded-md dark:text-boxdark-2 dark:bg-slate-200" autofocus autocomplete="off">
                    @error('email')
                    <x-messages.error :message="$message"></x-messages.error>
                    @enderror
                </div>
                
                <div>
                    <label for="password" class="text-sm">New Password:</label>
                    <input type="password" name="password" id="password" class="bg-primary-200 w-full mt-3 rounded-md dark:text-boxdark-2 dark:bg-slate-200" autocomplete="off">
                    @error('password')
                    <x-messages.error :message="$message"></x-messages.error>
                    @enderror
                </div>
                
                <div>
                    <label for="password_confirmation" class="text-sm">Confirm Password:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="bg-primary-200 w-full mt-3 rounded-md dark:text-boxdark-2 dark:bg-slate-200" autocomplete="off">
                    @error('password_confirmation')
                    <x-messages.error :message="$message"></x-messages.error>
                    @enderror

                </div>

                <button type="submit" class="bg-primary-600 w-1/2 px-4 py-2 mt-10 text-center text-white rounded-md">Reset Password</button>
            </form>
        </div>
    </div>
</x-layouts.base-layout>

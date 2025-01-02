<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\Fullname;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Jobs\SendEmailVerification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
// use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function index(): View
    {
        return view('register.index', [
            'title' => 'User Register',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate user input
        $validatedData = $request->validate([
            'username' => 'required | max:255 | unique:users',
            'fullname' => ['required', new Fullname],
            'email' => 'required | email:dns | unique:users',
            'password' => ['required', Password::defaults()],
        ]);

        // Encrypt the user password input
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Insert new user record into database
        $user = User::create($validatedData);

        /*
         * If you are manually implementing registration within your application instead of using a starter kit, 
         * you should ensure that you are dispatching the Illuminate\Auth\Events\Registered event after a user's registration is successful
        */
        // event(new Registered($user));

        // Send email verification with queue
        SendEmailVerification::dispatch($user);

        // Redirect to login page
        return redirect('/login')->with('success', 'Registration successful! Please login.');
    }
}

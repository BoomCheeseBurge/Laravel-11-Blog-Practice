<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\Fullname;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

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
        User::create($validatedData);

        // Redirect to login page
        return redirect('/login')->with('success', 'Registration successful! Please login.');
    }
}

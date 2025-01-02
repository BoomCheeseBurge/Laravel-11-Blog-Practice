<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\SendEmailVerification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class AuthController extends Controller
{
    /**
     * Email Verification Notice
     */
    public function verifyNotice () {

        // Check if user has been verified
        if (auth()->user()->hasVerifiedEmail())
        {
            // If user email is verified, redirect to kanban dashboard
            return to_route('dashboard.kanban');
        }

        return view('auth.verify-email', ['title' => 'Email Verification']);
    }

    /**
     * Email Verification Handler
     */
    public function verifyEmail (EmailVerificationRequest $request) {
        $request->fulfill();

        // Send a mail to the registered user of their created account
        Mail::to(auth()->user()->email)->queue(new WelcomeEmail(auth()->user()->username));
     
        return to_route('dashboard.kanban');
    }

    /**
     * Resending the Verification Email
     */
    public function verifyHandler (Request $request) {
        // $request->user()->sendEmailVerificationNotification();

        SendEmailVerification::dispatch(Auth::user());
     
        return back()->with('success', 'Verification link sent!');
    }

    // --------------------------------------------------------------------------------------------------------

    /**
     * Password Reset Link Request Form
     */
    public function resetPasswordLinkForm()
    {
        return view('auth.forgot-password', ['title' => 'Password Reset']);
    }

    /**
     * Handling the Link Form Submission
     */
    public function sendResetPassword (Request $request) {

        $request->validate(['email' => 'required|email:dns']);
     
        $status = Password::sendResetLink(
            $request->only('email')
        );
     
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Password Reset Form
     */
    public function resetPasswordForm (string $token) {
        return view('auth.reset-password', [
            'title' => 'Reset Password',
            'token' => $token
        ]);
    }

    /**
     * Handling the Reset Form Submission
     */
    public function performResetPassword (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email:dns',
            'password' => ['required', 'min:8', 'max:255', 'confirmed', Password::defaults()],
        ]);
     
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login.index')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}

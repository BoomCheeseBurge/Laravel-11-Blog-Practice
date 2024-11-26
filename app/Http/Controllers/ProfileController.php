<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        return view('profile.index', [
            'title' => 'Profile',
            'subTitle' => 'Your Profile',
            'page' => 'profile',
            'user' => $user,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('profile.show', [
            'title' => $user->username . '\'s Profile',
            'user' => $user,
            'posts' => Post::recent($user->username)->with('author')->with('category')->latest()->limit(3)->get(),
        ]);
    }
}

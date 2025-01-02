<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(User $user)
    {
        return view('setting.index', [
            'title' => 'Settings',
            'user' => $user,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Rules\Search;
use App\Rules\Fullname;
use App\Rules\MaxCharacter;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        if(!auth()->user()->is_admin)
        {
            abort(403);
        }

        $adminPosts = User::latest(); // Base Eloquent query

        // Check for a search keyword input
        if(request()->has('search'))
        {
            // Validate the search input
            $keyword = request()->validate([
                'search' => ['max:50', new Search],
            ])['search'];

            // Search by keyword input or empty string by default
            $adminPosts = $adminPosts->whereAny(['fullname', 'username', 'email'], 'like', '%'. $keyword .'%');
        }

        $perPage = request()->perPage ?? 10; // Get the pagination number or a default

        $archive = request()->archive ?? false; // Determines whether to switch to archive records

        return view('admin.users.index', [
            'title' => 'Admin',
            'subTitle' => 'Admin Users',
            'page' => 'users',
            'users' => $adminPosts
                        ->when($archive, fn($query) => $query->onlyTrashed()) // Switch to archived posts
                        ->paginate(5),
            'headers' => ['No', 'Fullname', 'Username', 'Email', 'Role', 'Date Created', 'Action'],
            'columns' => ['name', 'fullname', 'username', 'email', 'is_admin', 'created_at'],
            'perPage' => $perPage,
            'archive' => $archive,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        if(!auth()->user()->is_admin)
        {
            abort(403);
        }

        return view('admin.users.create', [
            'title' => 'Admin',
            'subTitle' => 'Create User',
            'page' => 'createUser',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        if(!auth()->user()->is_admin)
        {
            abort(403);
        }

        $validatedData = $request->validate([
            'fullname' => ['required', 'max:255', new Fullname],
            'username' => 'required | min:3 | max:255 | unique:users',
            'email' => 'required | email:dns | unique:users',
            'password' => ['required', 'confirmed:confirmPassword', 'max:255', Password::defaults()],
            'profile_pic' => 'nullable | image | mimes:png,jpeg,jpg | max:1024',
            'profile_cover' => 'nullable | image | mimes:png,jpeg,jpg | max:2048',
            'about' => ['nullable', 'ascii', new MaxCharacter(200)],
            'is_admin' => 'required',
        ]);

        // Check if there is an uploaded profile picture
        if ($request->hasFile('profile_pic'))
        {
            $profile_pic = $request->file('profile_pic');

            $validatedData['profile_pic'] = Storage::disk('profile')->putFileAs('/', $profile_pic, str()->uuid() . '.' . $profile_pic->extension() );
        }

        // Check if there is an uploaded cover photo
        if ($request->hasFile('profile_cover'))
        {
            $profile_cover = $request->file('profile_cover');

            $validatedData['profile_cover'] = Storage::disk('cover')->putFileAs('/', $profile_cover, str()->uuid() . '.' . $profile_cover->extension() );
        }

        // Create the post with the validated data above
        User::create($validatedData);

        return to_route('users.index')->with('success', 'User successfully created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): RedirectResponse
    {
        return to_route('user.account', ['user' => $user->username]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        if(!auth()->user()->is_admin)
        {
            abort(403);
        }

        return view('admin.users.edit', [
            'title' => 'Admin',
            'subTitle' => 'Edit User',
            'page' => 'editUser',
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        if(!auth()->user()->is_admin)
        {
            abort(403);
        }

        $validatedData = $request->validate([
            'fullname' => ['nullable', 'max:255', new Fullname],
            'username' => ['nullable', 'min:3', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['nullable', 'email:dns', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed:confirmPassword', 'max:255', Password::defaults()],
            'profile_pic' => 'nullable | image | mimes:png,jpeg,jpg | max:1024',
            'profile_cover' => 'nullable | image | mimes:png,jpeg,jpg | max:2048',
            'about' => ['nullable', 'ascii', new MaxCharacter(200)],
            'is_admin' => 'nullable',
        ]);

        if ($request->hasFile('profile_pic')) // Check if there is an uploaded profile cover
        {
            // Check if the current post has an existing featured image
            if(!is_null($user->profile_pic) && Storage::disk('profile')->exists($user->profile_pic))
            {
                dd(Storage::disk('profile')->exists($user->profile_pic));
                // Delete the old featured image file
                Storage::disk('profile')->delete($user->profile_pic);
            }

            $profile_pic = $request->file('profile_pic');

            $validatedData['profile_pic'] = Storage::disk('profile')->putFileAs('/', $profile_pic, str()->uuid() . '.' . $profile_pic->extension() );
        }

        if ($request->hasFile('profile_cover')) // Check if there is an uploaded profile cover
        {
            // Check if the current post has an existing featured image
            if(!empty($user->profile_cover) && Storage::disk('cover')->exists($user->profile_cover))
            {
                // Delete the old featured image file
                Storage::disk('cover')->delete($user->profile_cover);
            }

            $profile_cover = $request->file('profile_cover');

            $validatedData['profile_cover'] = Storage::disk('cover')->putFileAs('/', $profile_cover, str()->uuid() . '.' . $profile_cover->extension() );
        }

        $user->fullname = $validatedData['fullname'] ?? $user->fullname;
        $user->username = $validatedData['username'] ?? $user->username;
        $user->email = $validatedData['email'] ?? $user->email;
        $user->password = $validatedData['password'] ? Hash::make($validatedData['password']) : $user->password;
        $user->profile_pic = $validatedData['profile_pic'] ?? $user->profile_pic;
        $user->profile_cover = $validatedData['profile_cover'] ?? $user->profile_cover;
        $user->about = $validatedData['about'] ?? $user->about;
        $user->is_admin = $validatedData['is_admin'] ?? $user->is_admin;

        $user->save();

        if(!$user->wasChanged())
        {
            return to_route('users.index');
        }

        return to_route('users.index')->with('success', 'User successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if(!auth()->user()->is_admin)
        {
            abort(403);
        }

        if($user->is_admin === 1 && User::where('is_admin', 1)->count() === 1) // Check if there is only one admin user left
        {
            return to_route('users.index')->with('fail', 'There must be at least one admin user!');
        }

        // Temporarily delete or archive the user
        $user->delete();

        return to_route('users.index')->with('success', 'User successfully removed! Check the archive.');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(User $user): RedirectResponse
    {
        if(!auth()->user()->is_admin)
        {
            abort(403);
        }

        // Temporarily delete or archive the user
        $user->restore();

        return to_route('users.index')->with('success', 'User successfully restored! Check the active.');
    }

    /**
     * Delete the specified resource from storage.
     */
    public function erase(User $user): RedirectResponse
    {
        if(!auth()->user()->is_admin)
        {
            abort(403);
        }

        // Check if the user has a profile picture
        if(Storage::disk('profile')->exists($user->profile_pic))
        {
            // Delete the profile picture file
            Storage::disk('profile')->delete($user->profile_pic);
        }

        // Check if the user has a profile cover
        if(Storage::disk('cover')->exists($user->profile_cover))
        {
            // Delete the profile cover file
            Storage::disk('cover')->delete($user->profile_cover);
        }

        // Completely delete the user
        $user->forceDelete();

        return to_route('users.index')->with('success', 'User completely deleted!');
    }
}

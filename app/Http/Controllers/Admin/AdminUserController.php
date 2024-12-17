<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;

use App\Rules\Search;
use Illuminate\View\View;
use App\Traits\File\HasImage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class AdminUserController extends Controller
{
    use HasImage;
    
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Check if the user can access this resource
        if (auth()->user()->cannot('viewAny', User::class)) {
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
        // Check if the user can access this resource
        if (auth()->user()->cannot('create', User::class)) {
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
    public function store(StoreUserRequest $request): RedirectResponse
    {
        // Retrieve the validated input data from the form request
        $validatedData = $request->validated();

        // Check if there is an uploaded profile picture
        if ($request->hasFile('profile_pic'))
        {
            $validatedData['profile_pic'] = $this->uploadImage($request->file('profile_pic'), 'profile', str()->uuid());
        }

        // Check if there is an uploaded cover photo
        if ($request->hasFile('profile_cover'))
        {
            $validatedData['profile_cover'] = $this->uploadImage($request->file('profile_cover'), 'cover', str()->uuid());
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
        // Check if the user can access this resource
        if (auth()->user()->cannot('view', $user)) {
            abort(403);
        }
        
        return to_route('user.account', ['user' => $user->username]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        // Check if the user can perform this action through policy
        if (auth()->user()->cannot('update', $user)) {
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
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        // Retrieve the validated input data from the form request
        $validatedData = $request->validated();

        if ($request->hasFile('profile_pic')) // Check if there is an uploaded profile cover
        {
            // Check if the current post has an existing featured image
            if(!is_null($user->profile_pic) && Storage::disk('profile')->exists($user->profile_pic))
            {
                // Delete the old featured image file
                Storage::disk('profile')->delete($user->profile_pic);
            }

            $validatedData['profile_pic'] = $this->uploadImage($request->file('profile_pic'), 'profile', str()->uuid());
        }

        if ($request->hasFile('profile_cover')) // Check if there is an uploaded profile cover
        {
            // Check if the current post has an existing featured image
            if(!empty($user->profile_cover) && Storage::disk('cover')->exists($user->profile_cover))
            {
                // Delete the old featured image file
                Storage::disk('cover')->delete($user->profile_cover);
            }

            $validatedData['profile_cover'] = $this->uploadImage($request->file('profile_cover'), 'cover', str()->uuid());
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
        // Check if the user can perform this action through policy
        if (auth()->user()->cannot('delete', $user)) {
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
        // Check if the user can perform this action through policy
        if (auth()->user()->cannot('restore', $user)) {
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
        // Check if the user can perform this action through policy
        if (auth()->user()->cannot('forceDelete', $user)) {
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

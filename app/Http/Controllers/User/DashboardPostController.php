<?php

namespace App\Http\Controllers\User;

use App\Models\Post;

use App\Rules\Search;
use App\Models\Category;
use Illuminate\View\View;
use App\Traits\File\HasImage;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;

class DashboardPostController extends Controller
{
    use HasImage;
    
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Check if the user can access this resource
        if (auth()->user()->cannot('viewAny', Post::class)) {
            abort(403);
        }

        $userPosts = Auth::user()->posts()->with('category'); // Base Eloquent query

        // Check for a search keyword input
        if(request()->has('search'))
        {
            // Validate the search input
            $keyword = request()->validate([
                'search' => ['max:50', new Search],
            ])['search'];

            // Search by keyword input or empty string by default
            $userPosts = $userPosts->where('title', 'like', '%'. $keyword .'%')
                                    ->orWhereHas('category', function (Builder $query) use($keyword) {
                                        $query->where('name', 'like', "%$keyword%");
                                    });
        }

        $perPage = request()->perPage ?? 10; // Get the pagination number or a default

        return view('dashboard.posts.index', [
            'title' => 'Dashboard',
            'subTitle' => 'Dashboard Posts',
            'page' => 'posts',
            'posts' => $userPosts->latest()->paginate($perPage), // Get the posts belonging to the authenticated user
            'headers' => ['No', 'Title', 'Slug', 'Category', 'Date Created', 'Action'],
            'columns' => ['title', 'slug', 'category', 'created_at'],
            'perPage' => $perPage,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // Check if the user can perform this action through policy
        if (auth()->user()->cannot('create', Post::class)) {
            abort(403);
        }
                
        return view('dashboard.posts.create', [
            'title' => 'Dashboard',
            'subTitle' => 'Create Post',
            'page' => 'createPost',
            'categories' => Category::select('name', 'id')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): RedirectResponse
    {        
        // Retrieve the validated input data from the form request
        $validatedData = $request->validated();

        // Check if there is an uploaded featured image for the post
        if ($request->hasFile('featured_image'))
        {
            $validatedData['featured_image'] = $this->uploadImage($request->file('featured_image'), 'posts', str()->uuid());
        }

        // Assign the authorized user ID who wrote the post
        $validatedData['author_id'] = auth()->user()->id;

        // Create the post with the validated data above
        Post::create($validatedData);

        return to_route('posts.index')->with('success', 'Post successfully created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): View
    {
        // Check if the user can access this resource
        if (auth()->user()->cannot('view', Post::class)) {
            abort(403);
        }
        
        return view('dashboard.posts.show', [
            'title' => 'Single Post',
            'page' => 'singlePost',
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): View
    {
        // Check if the user can perform this action through policy 
        if (auth()->user()->cannot('update', $post)) {
            abort(403);
        }

        return view('dashboard.posts.edit', [
            'title' => 'Dashboard',
            'subTitle' => 'Edit Post',
            'page' => 'editPost',
            'post' => $post,
            'categories' => Category::select('name', 'id')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        // Retrieve the validated input data from the form request
        $validatedData = $request->validated();

        // Check if there is an uploaded featured image for the post
        if ($request->hasFile('featured_image'))
        {
            // Check if the current post has an existing featured image
            if($post->featured_image)
            {
                // Delete the old featured image file
                Storage::disk('posts')->delete($post->featured_image);
            }

            $validatedData['featured_image'] = $this->uploadImage($request->file('featured_image'), 'posts', str()->uuid());
        }

        $post->title = $validatedData['title'];
        $post->slug = $validatedData['slug'];
        $post->category_id = $validatedData['category_id'];
        $post->body = $validatedData['body'];
        $post->featured_image = $validatedData['featured_image'] ?? $post->featured_image;

        $post->save();

        if(!$post->wasChanged())
        {
            return to_route('posts.index');
        }

        return to_route('posts.index')->with('success', 'Post successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        // Check if the user can perform this action through policy 
        if (auth()->user()->cannot('forceDelete', $post)) {
            abort(403);
        }

        // Check if the post has any related comments
        if(!is_null($post->comments()->withTrashed()->first()))
        {
            return to_route('posts.index')->with('fail', 'This post has comments!');
        }

        // Check if the current post has an existing featured image
        if($post->featured_image)
        {
            // Delete the featured image file
            Storage::disk('posts')->delete($post->featured_image);
        }

        // Delete the likes on the post
        $post->likes()->detach();

        // Soft delete the post from user deletion
        $post->delete();

        return to_route('posts.index')->with('success', 'Post successfully deleted!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function checkSlug(String $val): JsonResponse
    {
        $slug = SlugService::createSlug(Post::class, 'slug', $val);

        return response()->json(['slug' => $slug]);
    }
}

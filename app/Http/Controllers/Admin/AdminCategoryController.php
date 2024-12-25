<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Rules\Search;
use App\Models\Category;
use Illuminate\View\View;
use App\Actions\CheckSlug;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Traits\File\HasImage;
use Cviebrock\EloquentSluggable\Services\SlugService;

class AdminCategoryController extends Controller
{
    use HasImage;

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Check if the user can access this resource
        if (auth()->user()->cannot('viewAny', Category::class)) {
            abort(403);
        }

        // Store the available category colors (whether already used or not)
        $colors = [
            "Slate", "Gray", "Zinc", "Neutral", "Stone",
            "Red", "Orange", "Amber", "Yellow", "Lime",
            "Green", "Emerald", "Teal", "Cyan", "Sky",
            "Blue", "Indigo", "Violet", "Purple", "Fuchsia",
            "Pink", "Rose"
        ];

        // Convert the collection to an associative array
        $catColors = Category::all()->pluck('color')->toArray();

        $adminCats = Category::latest(); // Base Eloquent query

        // Check for a search keyword input
        if(request()->has('search'))
        {
            // Validate the search input
            $keyword = request()->validate([
                'search' => ['max:50', new Search],
            ])['search'];

            // Search by keyword input or empty string by default
            $adminCats = $adminCats->whereAny(['name', 'color'], 'like', '%'. $keyword .'%');
        }

        $perPage = request()->perPage ?? 10; // Get the pagination number or a default

        return view('admin.categories.index', [
            'title' => 'Admin',
            'subTitle' => 'Admin Categories',
            'page' => 'categories',
            'categories' => $adminCats->paginate($perPage),
            'headers' => ['No', 'Name', 'Slug', 'Color', 'Date Created', 'Action'],
            'columns' => ['name', 'slug', 'color', 'created_at'],
            'colors' => $colors,
            'catColors' => $catColors,
            'perPage' => $perPage,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        // Check if the user can access this resource
        if (auth()->user()->cannot('create', Category::class)) {
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        // Retrieve the validated input data from the form request
        $validatedData = $request->validated();

        if ($request->hasFile('image'))
        {
            $validatedData['image'] = $this->uploadImage($request->file('image'), 'categories');
        }

        Category::create($validatedData);

        return to_route('categories.index')->with('success', 'Category successfully created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): RedirectResponse
    {
        // Check if the user can access this resource
        if (auth()->user()->cannot('view', $category)) {
            abort(403);
        }
        
        return to_route('blog.posts', ['category' => $category->slug]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category, CheckSlug $checkSlug): RedirectResponse
    {
        // Retrieve the validated input data from the form request
        $validatedData = $request->validated();

        $category->name = $validatedData['catName'];
        $category->color = $validatedData['catColor'];

        if($category->isDirty('name') && ($checkSlug->handle($validatedData['catName'], '-', $category->slug)))
        {
            $validatedData['slug'] = SlugService::createSlug(Category::class, 'slug', $validatedData['catName']);
            $category->slug = $validatedData['slug'];

            if ($request->hasFile('image')) // Check if there is a new uploaded category image
            {
                // Check if the current category has an existing featured image
                if(Storage::disk('categories')->exists($category->image))
                {
                    // Delete the featured image file
                    Storage::disk('categories')->delete($category->image);
                }

                $category->image = $this->uploadImage($request->file('image'), 'categories', $validatedData['slug']);

            } else {

                $pathInfo = pathinfo($category->image); // Get the current image file

                Storage::disk('categories')->move($category->image, $category->slug . '.' . $pathInfo['extension']); // Rename the old filename to the new category slug

                $category->image =  $category->slug . '.' . $pathInfo['extension'];
            }
        } else if ($request->hasFile('image')) { // Check if there is a new uploaded category image

            // Check if the current category has an existing featured image
            if(Storage::disk('categories')->exists($category->image))
            {
                // Delete the featured image file
                Storage::disk('categories')->delete($category->image);
            }

            $category->image = $this->uploadImage($request->file('image'), 'categories', $validatedData['slug']);
        }

        $category->save();

        if(!$category->wasChanged()) // Check if the category model was not changed at all
        {
            return to_route('categories.index');
        }

        return to_route('categories.index')->with('success', 'Category successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Check if the user can perform this action through policy
        if (auth()->user()->cannot('delete', $category)) {
            abort(403);
        }

        // Find if there is existing post(s) associated with the category
        $match = Post::firstWhere('category_id', $category->id);

        // Check if there was a match found from the query above
        if(!is_null($match))
        {
            // Return with the corresponding message
            return back()->with('fail', 'Category cannot be deleted due to existing post associations');
        }

        // Check if the current category has an existing featured image
        if(Storage::disk('categories')->exists($category->image))
        {
            // Delete the featured image file
            Storage::disk('categories')->delete($category->image);
        }

        // Destroy the category model instance
        $category->delete();

        // Return to the previous page with a message
        return back()->with('success', 'Category successfully deleted!');
    }
}

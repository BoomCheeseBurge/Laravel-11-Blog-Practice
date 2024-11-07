<x-layouts.dashboard-layout :page="$page" :title="$title">
    {{-- Utility Options START --}}
    <div class="flex items-center px-4 space-x-4 lg:px-8 sm:px-6">
        <a href="{{ route('posts.index') }}" class="text-primary-500 dark:text-white hover:underline">&laquo; Back to Posts</a>
        {{-- Edit Utility START --}}
        <a href="{{ route('posts.edit', ['post' => $post]) }}" data-tooltip-target="edit-tooltip" class="block px-3.5 py-2.5 text-sm font-semibold text-white bg-amber-500 rounded-lg dark:bg-amber-400 dark:focus:ring-amber-900 focus:outline-none focus:ring-4 focus:ring-amber-300 hover:bg-amber-500 md:text-base">
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
            </svg>
        </a>
        <div id="edit-tooltip" role="tooltip" class="tooltip z-9999 absolute invisible inline-block px-3 py-2 text-sm font-semibold text-amber-500 bg-slate-50 rounded-lg border border-slate-200 shadow-sm opacity-0 transition-opacity duration-300 dark:bg-gray-700">
            Edit
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
        {{-- Edit Utility END --}}

        {{-- Delete Utility START --}}
        <button data-tooltip-target="delete-tooltip" type="button" class="px-3.5 py-2.5 text-sm font-medium text-white bg-red-700 rounded-lg dark:bg-red-600 dark:focus:ring-red-900 dark:hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 hover:bg-red-800">
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
            </svg>
        </button>
        <div id="delete-tooltip" role="tooltip" class="tooltip z-9999 absolute invisible inline-block px-3 py-2 text-sm font-semibold text-red-500 bg-slate-50 rounded-lg border border-slate-200 shadow-sm opacity-0 transition-opacity duration-300 dark:bg-gray-700">
            Delete
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
        {{-- Delete Utility END --}}
    </div>
    {{-- Utility Options END --}}

    {{-- Blog Post START --}}
    <div class="mx-auto max-w-7xl px-4 lg:px-8 sm:px-6">
        <div class="mx-auto max-w-3xl">
            <!-- Blog Post Header START -->
            <div class="py-8">
                <h1 class="mb-2 text-3xl font-bold dark:text-slate-300">{{ $post->title }}</h1>
                <p class="text-sm font-semibold text-gray-500 dark:text-whiten">Published on <time datetime="{{ $post->created_at->format('Y-m-d') }}">{{ $post->created_at->format('F j, Y') }}</time></p>
            </div>
            <!-- Blog Post Header END -->

            <!-- Blog Post Featured Image START -->
            @if ($post->featured_image)
            <img src="{{ asset($post->featured_image) }}" alt="Featured image" class="w-full h-auto mb-8 rounded-md dark:opacity-90">
            @else
            <img src="{{ asset('IMG/default/'. $post->category->slug .'.jpg') }}" alt="Featured image" class="w-full h-auto mb-8 rounded-md dark:opacity-90">
            @endif
            <!-- Blog Post Featured Image END -->

            <!-- Blog Post Content START -->
            <div class="prose prose-sm mx-auto lg:prose-lg sm:prose xl:prose-xl">
                <p>{!! $post->body !!}</p>
            </div>
            <!-- Blog Post Content END -->
        </div>
    </div>
    {{-- Blog Post END --}}
</x-layouts.dashboard-layout>

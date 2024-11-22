<x-layouts.base-layout :title="$title">
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="mx-auto max-w-screen-xl px-4 py-4 lg:px-6 lg:py-8">
        <div class="mx-auto max-w-screen-md sm:text-center">
            <h2 class="mb-6 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">Found the post you're looking for?</h2>
            <form action="/posts" method="GET">
                {{-- Include category slug if the search is within a category --}}
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                {{-- Include author's username if the search is within a category --}}
                @if (request('author'))
                    <input type="hidden" name="author" value="{{ request('author') }}">
                @endif
                <div class="mx-auto max-w-screen-sm items-center mb-3 space-y-4 sm:flex sm:space-y-0">
                    <div class="w-full relative">
                        <label for="search" class="hidden mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Search</label>
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input class="w-full block p-3 pl-9 text-sm text-gray-900 bg-white rounded-lg border border-gray-300 dark:placeholder-gray-400 dark:text-white dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-500 dark:focus:border-primary-500 focus:ring-primary-500 focus:border-primary-500 sm:rounded-none sm:rounded-l-lg" placeholder="Enter search keyword" type="search" id="search" name="search" autocomplete="off">
                    </div>
                    <div>
                        <button type="submit" class="bg-primary-700 border-primary-600 w-full px-5 py-3 text-sm font-medium text-center text-white rounded-lg border cursor-pointer dark:bg-primary-600 dark:focus:ring-primary-800 dark:hover:bg-primary-700 focus:ring-primary-300 focus:ring-4 hover:bg-primary-800 sm:rounded-none sm:rounded-r-lg">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{ $posts->links() }}

    <section class="mx-auto max-w-screen-xl py-4">

        <div class="{{ $posts->isNotEmpty() ? 'grid gap-8 lg:grid-cols-3 md:grid-cols-2' : '' }}">
            @forelse ($posts as $post)
            <article class="flex flex-col justify-between p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                <div class="p-0 m-0">
                    {{-- Blog Post Category --}}
                    <div class="flex justify-between items-center mb-5 text-gray-500">
                        <a href="/posts?category={{ $post->category->slug }}" class="transition hover:scale-105">
                            <span class="bg-{{ $post->category->color }}-100 text-primary-800 inline-flex items-center px-2.5 py-0.5 lg:text-sm text-xs font-medium rounded dark:bg-primary-200 dark:text-primary-800">
                                {{ $post->category->name }}
                            </span>
                        </a>
                        <span class="text-sm dark:text-slate-200">{{ $post->created_at->diffForHumans() }}</span>
                    </div>

                    {{-- Blog Post Title --}}
                    <a href="/posts/{{ $post->slug }}" class="hover:underline">
                        <h2 class="mb-2 text-xl font-semibold tracking-tight text-gray-800 dark:text-white">{{ $post['title'] }}</h2>
                    </a>

                    {{-- Post Featured Image --}}
                    @if ($post->featured_image)
                    <img src="{{ Storage::disk('posts')->url($post->featured_image) }}" alt="Post Featured Image" class="w-full h-1/2">
                    @else
                    <img src="{{ Storage::disk('categories')->url($post->category->image) }}" alt="Default Featured Image" class="w-full h-1/2">
                    @endif

                    {{-- Blog Post Excerpt --}}
                    <p class="mt-2 mb-5 text-gray-600 dark:font-light dark:text-slate-200">{{ Str::limit(strip_tags($post['body']), 100) }}</p>
                </div>

                {{-- Blog Post Author --}}
                <div class="flex justify-between items-center mt-5">
                    <a href="/posts?author={{ $post->author->username }}">
                        <div class="flex items-center space-x-3">
                            <img class="w-7 h-7 rounded-full" src="{{ asset('IMG/default/default-user.png') }}" alt="Default Profile Image" />
                            <span class="text-sm font-medium dark:text-white">
                                {{ $post->author->username }}
                            </span>
                        </div>
                    </a>
                    <a href="/posts/{{ $post['slug'] }}" class="text-primary-600 inline-flex items-center font-medium dark:text-primary-500 hover:underline">
                        Read more
                        <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a>
                </div>
            </article>
            @empty
            <div class="w-full">
                <p class="my-4 text-3xl font-semibold text-center">Posts Not Found!</p>
                <a href="/posts" class="ml-10 text-blue-600 hover:underline">&laquo Back to Posts</a>
            </div>
            @endforelse
        </div>
    </section>

    {{ $posts->links() }}

</x-layouts.base-layout>

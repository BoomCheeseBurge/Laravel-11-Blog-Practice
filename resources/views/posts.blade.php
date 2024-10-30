<x-layouts.base-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

        <section class="mx-auto max-w-screen-xl py-4">
            <div class="grid gap-8 lg:grid-cols-3 md:grid-cols-2">
                @foreach ($posts as $post)
                <article class="flex flex-col justify-between p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-0 m-0">
                        {{-- Blog Post Category --}}
                        <div class="flex justify-between items-center mb-5 text-gray-500">
                            <a href="/categories/{{ $post->category->slug }}" class="transition hover:scale-105">
                                <span class="bg-{{ $post->category->color }}-100 text-primary-800 inline-flex items-center px-2.5 py-0.5 text-xs font-medium rounded dark:bg-primary-200 dark:text-primary-800">
                                    {{ $post->category->name }}
                                </span>
                            </a>
                            <span class="text-sm">{{ $post->created_at->diffForHumans() }}</span>
                        </div>

                        {{-- Blog Post Title --}}
                        <a href="/posts/{{ $post->slug }}" class="hover:underline">
                            <h2 class="mb-2 text-2xl font-semibold tracking-tight text-gray-800 dark:text-white">{{ $post['title'] }}</h2>
                        </a>

                        {{-- Blog Post Excerpt --}}
                        <p class="mb-5 font-light text-gray-500 dark:text-gray-400">{{ Str::limit($post['body'], 100) }}</p>
                    </div>

                    {{-- Blog Post Author --}}
                    <div class="flex justify-between items-center">
                        <a href="/authors/{{ $post->author->username }}">
                            <div class="flex items-center space-x-3">
                                <img class="w-7 h-7 rounded-full" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/jese-leos.png" alt="Jese Leos avatar" />
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
                @endforeach
            </div>
        </section>

</x-layouts.base-layout>

<x-layouts.base-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <article class="max-w-screen-md py-8">
        <h2 class="mb-1 text-3xl font-bold tracking-tight text-gray-900">{{ $post['title'] }}</h2>

        <div class="text-base text-gray-500">
            <a href="/authors/{{  $post->author->id }}" class="hover:underline">{{ $post->author->name }}</a>
            | {{ $post->created_at->format('F j, Y') }}
        </div>
        <p class="my-4 font-light">{{ $post['body'] }}</p>
        <a href="/posts" class="font-medium text-blue-500 hover:underline">&laquo; Back to Posts</a>
    </article>

</x-layouts.base-layout>

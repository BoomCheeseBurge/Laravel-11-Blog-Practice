<x-layouts.dashboard-layout :page="$page" :title="$title">
    <!-- Breadcrumb Start -->
    <div
    class="flex flex-col gap-3 mb-6 sm:flex-row sm:justify-between sm:items-center"
    >
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        {{ $subTitle }}
    </h2>

    <nav>
        <ol class="flex items-center gap-2">
        <li>
            <div class="font-medium">{{ $title }} /</div>
        </li>
        <li class="text-primary-500 font-medium">Edit</li>
        </ol>
    </nav>
    </div>
    <!-- Breadcrumb End -->

    <!-- Create Post START -->
    <div class="bg-white/75 font-[sans-serif] shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] rounded-md dark:bg-slate-800">
        <form action="{{ route('posts.update', ['post' => $post]) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="flex flex-col items-center gap-10 py-10 md:py-15">
                <div class="w-full flex flex-col px-6 space-y-5 text-slate-900 md:flex-row md:justify-center md:space-x-5 md:space-y-0">
                    {{-- Post Title Input START --}}
                    <div class="w-full relative px-6 space-y-2 md:px-0">
                        <label for="title" class="text-boxdark-2 font-sans font-semibold dark:text-slate-200">Title</label>
                        <input id="title" name="title" type='text' placeholder='Enter title here'
                        class="outline-primary-600 w-full px-4 py-3.5 text-sm rounded-md dark:placeholder-slate-200 dark:text-slate-200 dark:bg-slate-600
                        @error('title')
                        is-invalid
                        @else
                        is-valid
                        @enderror" placeholder="Ente title here" value="{{ old('title', $post->title) }}" autocomplete="off" autofocus required>
                        <svg class="w-6 h-6 text-red-600 dark:text-white
                        @error('title')
                        absolute bottom-0 top-10 right-0 mr-3
                        @else
                        hidden
                        @enderror" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        @error('title')
                        <x-messages.error :message="$message"></x-messages.error>
                        @enderror
                    </div>
                    {{-- Post Title Input END --}}

                    {{-- Post Slug Input START --}}
                    <div class="w-full px-6 space-y-2 md:px-0">
                        <label for="slug" class="text-boxdark-2 font-sans font-semibold dark:text-slate-200">Slug</label>
                        <div class="rounded-md border border-slate-300 dark:border-slate-500">
                            <input id="slug" name="slug" type='text' placeholder='Auto-generated'
                            class="w-full px-4 py-3.5 text-sm rounded-md border-none cursor-default dark:placeholder-slate-200 dark:text-slate-200 dark:bg-slate-600 focus:outline-none focus:ring-0" value="{{ old('slug', $post->slug) }}" readonly required/>
                            @error('slug')
                            <div class="ps-2 text-sm text-red-800 dark:text-red-400" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    {{-- Post Slug Input END --}}
                </div>

                {{-- Post Category Input START --}}
                <div class="w-4/5 px-6 space-y-2 md:w-1/3 md:px-0">
                    <label for="category_id" class="text-boxdark-2 font-sans font-semibold dark:text-slate-200">Post Category</label>
                    <select id="category_id" name="category_id" class="w-full block p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 dark:placeholder-gray-400 dark:text-white dark:bg-gray-700 dark:border-gray-600 dark:focus:border-blue-500 dark:focus:ring-blue-500 focus:border-blue-500 focus:ring-blue-500" required>
                        <option disabled>Choose a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : ' ' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Post Category Input END --}}
            </div>

            <div x-data="{ fileExist: '{{ $post->featured_image ? Storage::disk('posts')->url($post->featured_image) : '' }}' }" class="mx-auto max-w-3xl px-5 pb-10">
                {{-- Featured Image Input START --}}
                <h3 class="mb-2 font-mono text-2xl font-bold text-gray-900 dark:text-slate-100">Featured Image</h3>
                @error('featured_image')
                <x-messages.error :message="$message"></x-messages.error>
                @enderror
                <div x-data="imageData(fileExist)" class="mb-15 items-center p-6 text-center text-gray-900 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:text-gray-400 dark:bg-gray-800 dark:border-gray-400">
                    <div x-show="previewUrl == ''">
                        <label for="featured_image" class="cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto w-8 h-8 mb-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                            </svg>
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-slate-800 dark:text-gray-300">Upload picture</h5>
                            <p class="text-sm font-normal md:px-6">Choose photo size should be less than <b class="text-slate-800 dark:text-gray-300">2mb</b></p>
                            <p class="text-sm font-normal md:px-6">and should be in <b class="text-slate-800 dark:text-gray-300">JPG, PNG, or GIF</b> format.</p>
                            <span id="filename" class="z-50 text-gray-500 bg-gray-200"></span>
                        </label>
                        <input id="featured_image" name="featured_image" type="file" class="hidden" @change="updatePreview()" />
                    </div>
                    <div class="w-full space-y-5" x-show="previewUrl !== ''">
                        @if ($post->featured_image)
                        <img :src="previewUrl" alt="current featured image" class="h-[24rem] w-[40rem] mx-auto">
                        @else
                        <img :src="previewUrl" alt="uploaded featured image" class="h-[24rem] w-[40rem] mx-auto">
                        @endif
                        <div class="">
                            <button type="button" @click="clearPreview()" class="px-5 py-2.5 me-2 mb-2 text-sm font-medium text-center text-white bg-teal-600 rounded-full dark:font-semibold dark:text-teal-800 dark:bg-teal-400 dark:focus:ring-teal-500 dark:hover:bg-teal-600 focus:outline-none focus:ring-4 focus:ring-teal-500 hover:bg-teal-800">Choose Another</button>
                        </div>
                    </div>
                </div>
                {{-- Featured Image Input END --}}

                {{-- Post Content Input START --}}
                <label for="body" class="text-boxdark-2 font-sans text-lg font-medium dark:text-slate-200">Post Content</label>
                @error('body')
                <x-messages.error :message="$message"></x-messages.error>
                @enderror
                <trix-toolbar id="post_toolbar" class="[&>div>span>button]:dark:bg-primary-600 mt-2"></trix-toolbar>
                <input id="body" name="body" class="w-0 float-left opacity-0" value="{{ old('body', $post->body) }}" required>
                <trix-editor toolbar="post_toolbar" input="body" class="dark:text-slate-800 dark:bg-slate-300" placeholder="Convey your writing here!"></trix-editor>
                {{-- Post Content Input END --}}

                {{-- Post Create Submit START --}}
                <div class="flex justify-center mt-10">
                    <button type='submit'
                    class="bg-primary-600 w-full px-4 py-2.5 text-sm font-semibold text-white rounded-md hover:bg-primary-700 md:w-2/3 md:text-lg">Update</button>
                </div>
                {{-- Post Create Submit END --}}
            </div>
        </form>
    </div>
    <!-- Create Post END -->

    @push('scripts')
    <script src="{{ asset('JS/dashboard-form.js') }}"></script>
    <script src="{{ asset('JS/trix.js') }}"></script>
    @endpush
</x-layouts.dashboard-layout>

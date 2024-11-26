<x-layouts.base-layout :title="$title">
    <x-slot:title>{{ $title }}</x-slot:title>

    <!-- Profile Page Start -->
    <div class="max-w-full bg-gray-100 rounded-lg dark:bg-slate-500 dark:shadow-none">
        {{-- =================== Profile Background Start =================== --}}
        <section class="h-[350px] relative block bg-gray-100 dark:bg-slate-800">
            <!-- User Profile Cover START -->
            @if (isset($user->profile_cover))
                <img class="w-full h-full absolute top-0 bg-center bg-cover rounded-lg"
                    src="{{  Storage::disk('cover')->url($user->profile_cover) }}">
                    <span id="blackOverlay" class="w-full h-full absolute bg-black opacity-50"></span>
                </img>
            @else
                <img class="w-full h-4/5 absolute top-0 bg-center bg-cover rounded-lg md:h-fit"
                        src="{{ asset('IMG/default/default_background.jpeg') }}">
                </img>
            @endif
            <!-- User Profile Cover END -->
        </section>
        {{-- =================== Profile Background End =================== --}}
        {{-- =================== Front Profile Start =================== --}}
        <section class="py-16 bg-gray-100 rounded-b-lg dark:bg-slate-800">
          <div class="container mx-auto px-4">
            <div class="-mt-64 w-full min-w-0 relative flex flex-col mb-6 break-words bg-gray-100 rounded-lg shadow-xl dark:bg-slate-700">
              <div class="px-6">
                <div class="flex flex-wrap justify-center">
                    <div class="w-full relative flex justify-center px-4 lg:w-3/12 lg:order-2">
                        <!-- =================== User Profile Picture =================== -->
                        @if (isset($user->profile_pic))
                            <div class="mx-auto w-full flex justify-center">
                                <img src="{{  Storage::disk('profile')->url($user->profile_pic) }}" alt="{{ $user->username }}'s' profile picture"
                                        class="bottom-15 h-26 w-26 object-cover relative rounded-full outline-2 outline-emerald-400 outline outline-offset-2 shadow-xl lg:w-36 lg:h-36 md:w-30 md:h-30" />
                            </div>
                        @else
                            <img alt="default profile picture" src="{{ asset('IMG/default/default_user.png') }}" class="-top-20 w-30 h-auto absolute rounded-full border-none outline-2 outline-emerald-400 outline outline-offset-2 shadow-xl md:w-40">
                        @endif
                    </div>
                    <div class="w-full px-4 mt-20 text-center lg:w-4/12 lg:order-3 lg:mt-0 md:mt-30">
                        <div class="flex justify-center lg:pt-12">
                            <button class="flex items-center px-4 py-2 mb-1 space-x-1 text-sm font-bold text-white uppercase bg-pink-700 rounded outline-none shadow transition-all duration-150 ease-linear dark:bg-pink-500 dark:hover:bg-pink-600 focus:outline-none hover:bg-pink-600 hover:shadow-md md:text-md sm:mr-2" type="button">
                                <span>FOLLOW</span>
                                <svg class="w-6 h-6 inline text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M9 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H7Zm8-1a1 1 0 0 1 1-1h1v-1a1 1 0 1 1 2 0v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0v-1h-1a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- ------------------------------------------- TRACK RECORD START ------------------------------------------- --}}
                    <div class="w-full px-4 lg:w-4/12 lg:order-1">
                        <div class="flex justify-center pt-8">
                            <div class="p-3 mr-4 font-bold text-center">
                            <span class="block text-xl tracking-wide text-slate-600 uppercase dark:text-white">0</span><span class="text-sm text-slate-400 dark:text-slate-200">Posts</span>
                            </div>
                            <div class="p-3 font-bold text-center lg:mr-4">
                            <span class="block text-xl tracking-wide text-slate-600 uppercase dark:text-white">0</span><span class="text-sm text-slate-400 dark:text-slate-200">Comments</span>
                            </div>
                        <div class="p-3 mr-4 font-bold text-center">
                            <span class="block text-xl tracking-wide text-slate-600 uppercase dark:text-white">0</span><span class="text-sm text-slate-400 dark:text-slate-200">Friends</span>
                        </div>
                        </div>
                    </div>
                    {{-- ------------------------------------------- TRACK RECORD END ------------------------------------------- --}}

                </div>
                <div class="mt-6 text-center">
                    <!-- =================== Username START =================== -->
                    <h3 class="mb-2 text-2xl font-semibold leading-normal text-slate-700 dark:text-slate-100 md:text-4xl">
                        {{ $user->username }}
                    </h3>
                    <!-- =================== Username END =================== -->

                    <!-- =================== Location START =================== -->
                    <div class="mb-2 text-sm font-bold tracking-wider leading-normal text-amber-500 uppercase dark:text-primary-300 md:text-base">
                            <svg class="w-6 h-6 inline text-amber-500 dark:text-primary-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z" clip-rule="evenodd"/>
                            </svg>
                            {{ $user->location ?? 'Country' }}
                    </div>
                    <!-- =================== Location END =================== -->

                    <!-- =================== Book Section START =================== -->
                    <div class="w-full px-5 py-6 mt-10 bg-slate-100 rounded-md dark:bg-slate-600">

                        <!-- For Medium and Larger Screens START -->
                        <div class="hidden md:flex book [&>.page]:mt-2 md:[&>.page]:w-[19rem] lg:[&>.page]:h-[22.5rem] md:[&>.page]:h-[20.5rem] md:h-[24rem] lg:h-[25rem] justify-center pr-[13rem] md:pr-[20rem] lg:[&>.cover]:w-[21rem] md:[&>.cover]:w-[19rem] lg:[&>.cover]:h-[24rem] md:[&>.cover]:h-[23rem]">
                            <span class="page turn"></span>
                            <span class="page turn"></span>
                            <span class="page turn"></span>
                            <span class="page turn flex flex-col justify-between lg:w-[21rem] lg:h-[22.5rem] md:w-[19rem] md:h-[20.5rem]">
                                <hr class="border-t-[1px] border-t-zinc-500 border-dashed">
                                <div class="text-flip pl-2 text-pretty text-center">
                                    <h1 class="text-base font-bold text-blue-500 md:text-lg">Contact Me!</h1>
                                    <p class="pt-4 pb-4 text-xs font-light text-slate-700 md:text-sm">
                                        {{ $user->email ?? 'E-mail is private' }}
                                    </p>
                                    <hr class="border-t-[1px] my-4 border-t-zinc-500 border-dashed md:my-10">
                                    <h1 class="text-base font-bold text-blue-500 md:text-lg">My Website</h1>
                                    <p class="pt-4 pb-4 text-xs font-light text-slate-700 md:text-sm">
                                        {{ $user->website ?? 'Website is private' }}
                                    </p>
                                </div>
                                <hr class="border-t-[1px] border-t-zinc-500 border-dashed">
                            </span>
                            <span class="page turn"></span>
                            <span class="page turn flex flex-col justify-between">
                                <hr class="border-t-[1px] border-t-zinc-500 border-dashed">
                                <div class="pl-2 text-pretty">
                                    <h1 class="text-base font-bold text-center text-blue-500 md:text-lg">About Me</h1>
                                    <p class="pt-4 pb-4 text-xs md:text-sm font-light {{ empty($user->about) ? 'text-center' : 'text-left' }} text-slate-700">
                                        {{ $user->about ?? 'Write something about yourself!' }}
                                    </p>
                                </div>
                                <hr class="border-t-[1px] border-t-zinc-500 border-dashed">
                            </span>
                            <span class="cover"></span>
                            <span class="page"></span>
                            <span class="cover turn"></span>
                        </div>
                        <!-- For Medium and Larger Screens END -->

                        <!-- For Small Screen START -->
                         <div class="block space-y-10 md:hidden">
                            <div>
                                <div class="font-semibold tracking-wide text-slate-900 dark:text-slate-300">
                                    About
                                </div>
                                <p class="border-b-[1px] pb-3 mt-3 text-slate-900 border-b-gray-400 dark:text-slate-100">{{ $user->about ?? 'Nothing written yet...' }}</p>
                            </div>

                            <div>
                                <div class="font-semibold tracking-wide text-slate-900 dark:text-slate-300">
                                    Contact
                                </div>
                                <p class="border-b-[1px] pb-3 mt-3 text-slate-900 border-b-gray-400 dark:text-slate-100">{{ $user->email ?? 'E-mail is private' }}</p>
                            </div>

                            <div>
                                <div class="font-semibold tracking-wide text-slate-900 dark:text-slate-300">
                                    Website
                                </div>
                                <p class="border-b-[1px] pb-3 mt-3 text-slate-900 border-b-gray-400 dark:text-slate-100">{{ $user->website ?? 'Website is private' }}</p>
                            </div>                            
                         </div>
                        <!-- For Small Screen END -->

                      </div>
                    <!-- =================== Book Section END =================== -->
                </div>
                <div class="relative flex items-center pt-20">
                    <div class="flex-grow border-t border-slate-500 dark:border-slate-200"></div>
                    <span class="flex-shrink mx-4 text-lg text-slate-500 dark:text-slate-200">Posts by {{ $user->username }}</span>
                    <div class="flex-grow border-t border-slate-500 dark:border-slate-200"></div>
                </div>
                <div class="pb-5 my-10 text-center">
                    <div class="flex flex-wrap justify-center">
                      <div class="w-full px-4">
                        <div class="font-['Cursive'] text-4xl italic">Latest</div>
                        <div class="flex flex-col justify-center items-center my-4 lg:grid-cols-3 md:grid md:grid-cols-2 md:items-stretch md:gap-5 md:my-8">
                            @foreach ($posts as $post)
                            <article class="w-full p-6 my-5 bg-white rounded-lg border border-slate-200 shadow-md dark:bg-slate-900/60 dark:border-none dark:shadow-inner lg:my-0">
                                <div class="flex justify-between items-center mb-5 text-slate-500">
                                    <a href="/posts?category={{ $post->category->slug }}">
                                        <span class="bg-{{ $post->category->color }}-200 text-primary-800 text-xs font-medium inline-flex items-center px-2 py-1.5 rounded dark:text-primary-800">
                                            {{ $post->category->name }}
                                        </span>
                                    </a>
                                    <span class="text-sm text-slate-900 dark:text-white">{{ $post->category->created_at->diffForHumans() }}</span>
                                </div>
                                @if ($post->featured_image)
                                <div class="max-h-[200px] max-w-100 mx-auto overflow-hidden rounded-md cursor-zoom-in">
                                    <img src="{{ Storage::disk('posts')->url($post->featured_image) }}" alt="Post Featured Image">
                                </div>
                                @else
                                <div class="max-h-[200px] max-w-100 mx-auto overflow-hidden mb-3 rounded-md cursor-zoom-in">
                                    <img src="{{ Storage::disk('categories')->url($post->category->image) }}" alt="Default Post Featured Image">
                                </div>
                                @endif
                                <a href="/posts/{{ $post->slug }}">
                                    <h2 class="mb-2 text-lg font-bold tracking-tight text-slate-700 dark:text-white hover:underline md:text-2xl">
                                        {{ $post->title }}
                                    </h2>
                                </a>
                                <p class="mb-5 font-light text-slate-500 dark:text-slate-400">
                                    {{ $post->excerpt }}
                                </p>
                                <div>
                                    <a href="/posts/{{ $post->slug }}" class="text-primary-600 inline-flex items-center px-3 py-2 text-sm font-medium bg-sky-200 rounded-md dark:text-primary-500 md:p-0 md:text-base md:bg-transparent md:rounded-none md:hover:underline">
                                        Read more
                                    </a>
                                </div>
                            </article>
                            @endforeach
                        </div>
                        <a href="/posts?author={{ $user->username }}" class="p-2 text-lg font-normal text-pink-100 bg-rose-600 rounded-md dark:text-rose-600 lg:text-xl md:p-0 md:text-pink-600 md:bg-transparent md:rounded-none md:dark:text-pink-400 md:hover:underline">View More</a>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        {{-- Front Profile End --}}
    </div>
    <!-- Profile Page End -->

</x-layouts.base-layout>

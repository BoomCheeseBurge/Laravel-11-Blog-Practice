<article x-init="initFlowbite()"
    x-data="{
        edit: '',
        reply: '',
        openReply: false,
        resetReply() {
            this.reply = '';
        },
    }">
    
    <section class="border-[1px] px-5 py-5 text-base bg-gray-100 rounded-lg border-slate-400 dark:bg-slate-900 dark:border-0 md:px-10">
        <div class="flex justify-between items-center">
            <span class="flex items-center">
                <div class="w-8 h-8 flex flex-col justify-center mr-2 rounded-full">
                        @isset($comment->user->profile_pic)
                            <img
                                class="object-cover"
                                src="{{ Storage::disks('profile')->url($comment->user->profile_pic) }}"
                                alt="Default Profile Picture">
                        @else
                            <img
                                class="object-cover"
                                src="{{ asset('IMG/default/default_user.png') }}"
                                alt="Default Profile Picture">
                        @endif
                    </div>
                    <span class="mr-3 text-sm font-semibold text-slate-900 dark:text-white">
                        {{ $comment->user->username }}
                    </span>
                    <span class="text-sm text-slate-600 dark:text-slate-300">
                        <time pubdate datetime="{{ $comment->updated_at->format('Y-m-d') }}" title="{{ $comment->updated_at->format('F jS, Y') }}">
                            {{ $comment->updated_at->diffForHumans() }}
                        </time>
                    </span>
                </span>
                {{-- Comment Actions START --}}
                {{-- Check if the comment is not trashed --}}
                @if (!$comment->trashed()) 
                    {{-- Check if the user can perform comment actions --}}
                    @can ('dropdown', $comment)
                        {{-- Comment Dropdown Button START --}}
                        <button type="button" id="dropdownButton-{{ $comment->id }}" x-data data-dropdown-toggle="dropdownComment-{{ $comment->id }}"
                            class="inline-flex items-center p-2 text-sm font-medium text-center text-slate-500 bg-slate-50 rounded-lg dark:text-slate-400 dark:bg-slate-900 dark:focus:ring-slate-600 dark:hover:bg-slate-700 focus:ring-primary-custom focus:outline-none focus:ring-2 hover:bg-slate-100"
                            type="button">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                                <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                            </svg>
                            <span class="sr-only">Comment settings</span>
                        </button>
                        {{-- Comment Dropdown Button END --}}

                        {{-- Comment Dropdown Menu START --}}
                        <div id="dropdownComment-{{ $comment->id }}"
                            class="w-24 z-10 hidden bg-white rounded shadow dark:bg-slate-700">
                            <div class="py-1"
                                aria-labelledby="dropdownMenuIconHorizontalButton">
                                <div>
                                    {{-- Comment Edit Action START --}}
                                    <button id="editButton-{{ $comment->id }}" x-on:click="hideDropdown('dropdownComment-{{ $comment->id }}'); edit = 'edit-'+{{ $comment->id }}; onFocus('editInput-{{ $comment->id }}')" class="border-b-[1px] w-full block px-4 py-2 text-sm text-slate-700 no-underline border-b-slate-400 dark:text-slate-200 dark:hover:bg-slate-600 hover:bg-slate-100">Edit</button>
                                    {{-- Comment Edit Action END --}}
                                </div>
                                <div>
                                    {{-- Comment Delete Action START --}}
                                    <button x-on:click="hideDropdown('dropdownComment-{{ $comment->id }}'); $dispatch('show-modal', { name: 'deleteModal-'+{{ $comment->id }} })" class="w-full block px-4 py-2 text-sm text-slate-700 no-underline dark:text-slate-200 dark:hover:bg-slate-600 hover:bg-slate-100">Remove</button>
                                    {{-- Comment Delete Action END --}}
                                </div>
                            </div>
                        </div>
                        {{-- Comment Dropdown Menu END --}}
                    @else
                    <button type="button" class="hover:underline {{ !auth()->check() ? 'hidden' : '' }}">Report</button>
                    @endcan
                @endif
                {{-- Comment Actions END --}}
            </span>
        </div>
        {{-- Comment Content START --}}
        <p x-show="edit == ''" class="text-md text-slate-700 dark:text-slate-200 md:text-lg">
            {{ $comment->comment }}
        </p>
        {{-- Comment Content END --}}
        
        {{-- Comment Edit START --}}
        <div x-cloak x-show="edit == 'edit-'+{{ $comment->id }}" class="flex flex-col mt-4">
            <textarea id="editInput-{{ $comment->id }}" wire:model="commentContent" rows="3" class="max-w-3xl mb-5 rounded-md dark:placeholder-white dark:text-white dark:bg-slate-500"></textarea>
            <div>
                <button wire:click="updateComment" x-on:click="edit = ''" type="button" class="text-md px-3 py-2.5 me-2 font-medium text-white bg-blue-700 rounded-lg dark:bg-blue-600 dark:focus:ring-blue-800 dark:hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 hover:bg-blue-800 lg:px-4 lg:py-3">Edit</button>
                <button x-on:click="edit = ''" type="button" class="text-md px-3 py-2.5 font-medium text-white bg-red-700 rounded-lg dark:bg-red-600 dark:focus:ring-red-800 dark:hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 hover:bg-red-800 lg:px-4 lg:py-3">Cancel</button>
            </div>
        </div>
        {{-- Comment Edit END --}}

        {{-- Comment Actions START --}}
        <div class="flex justify-between mt-8">
            <div class="inline-flex justify-between items-center mr-3 md:mr-0">
                <div class="flex justify-start items-center md:gap-5">
                    {{-- Reply Action START --}}
                    <button id="replyButton-{{ $comment->id }}" x-cloak x-on:click="reply = 'reply-'+{{ $comment->id }}; onFocus('replyInput-{{ $comment->id }}')" type="button"
                        class="@if($comment->trashed()) pointer-events-none @endif flex items-center text-sm font-medium text-slate-500 dark:text-slate-400 hover:underline"
                        @guest disabled @endguest 
                        @if($comment->trashed()) disabled @endif>
                        <svg class="w-5 h-5 hidden mr-1.5 md:block" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>
                        </svg>
                        <span class="text-slate-900 dark:text-slate-300">Reply</span>
                    </button>
                    {{-- Reply Action END --}}
                    
                    {{-- Like Action START --}}
                    @auth                            
                    <livewire:like-button :key="'likeComment-'.$count" :likeID="$count" :set_icon="false" :model="$comment"/>
                    @endauth
                    {{-- Like Action END --}}
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <button x-on:click="openReply = ! openReply" class="hidden text-slate-900 dark:text-slate-300 md:block" {!! $comment->comments->isNotEmpty() ? '' : 'disabled' !!}>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none">
                        <path
                            d="M7.04962 9.99504L7 10M12 10L11.9504 10.005M17 10L16.9504 10.005M10.5 3H13.5C16.7875 3 18.4312 3 19.5376 3.90796C19.7401 4.07418 19.9258 4.25989 20.092 4.46243C21 5.56878 21 7.21252 21 10.5V12.4777C21 13.8941 21 14.6023 20.8226 15.1779C20.4329 16.4427 19.4427 17.4329 18.1779 17.8226C17.6023 18 16.8941 18 15.4777 18C15.0811 18 14.8828 18 14.6985 18.0349C14.2966 18.1109 13.9277 18.3083 13.6415 18.6005C13.5103 18.7345 13.4003 18.8995 13.1803 19.2295L13.1116 19.3326C12.779 19.8316 12.6126 20.081 12.409 20.198C12.1334 20.3564 11.7988 20.3743 11.5079 20.2462C11.2929 20.1515 11.101 19.9212 10.7171 19.4605L10.2896 18.9475C10.1037 18.7244 10.0108 18.6129 9.90791 18.5195C9.61025 18.2492 9.23801 18.0748 8.83977 18.0192C8.70218 18 8.55699 18 8.26662 18C7.08889 18 6.50002 18 6.01542 17.8769C4.59398 17.5159 3.48406 16.406 3.12307 14.9846C3 14.5 3 13.9111 3 12.7334V10.5C3 7.21252 3 5.56878 3.90796 4.46243C4.07418 4.25989 4.25989 4.07418 4.46243 3.90796C5.56878 3 7.21252 3 10.5 3Z"
                            stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                    </svg>
                </button>
                <h5 class="hidden text-sm font-normal leading-snug text-slate-500 dark:text-slate-300 md:block">{{ $comment->comments->isNotEmpty() ? $comment->comments->count() : '0' }} Replies</h5>
                <button x-on:click="openReply = ! openReply" class="text-sm md:hidden" {!! $comment->comments->isNotEmpty() ? '' : 'disabled' !!}>Show Reply</button>
            </div>
        </div>
        {{-- Comment Actions END --}}

        {{-- Comment Reply START --}}
        <div x-cloak x-show="reply == 'reply-'+{{ $comment->id }}" class="flex flex-col mt-4">
            <textarea id="replyInput-{{ $comment->id }}" rows="3" wire:model="commentReply" class="max-w-3xl mb-5 rounded-md dark:placeholder-white dark:text-white dark:bg-slate-500" placeholder="Leave a reply..."></textarea>
            <div>
                <button type="button" x-on:click="reply = ''" wire:click="createReply" class="text-md px-3 py-2 me-2 font-medium text-white bg-blue-700 rounded-lg dark:bg-blue-600 dark:focus:ring-blue-800 dark:hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 hover:bg-blue-800">Reply</button>
                <button type="button" x-on:click="reply = ''" class="text-md px-3 py-2 font-medium text-white bg-red-700 rounded-lg dark:bg-red-600 dark:focus:ring-red-800 dark:hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 hover:bg-red-800">Cancel</button>
            </div>
        </div>
        {{-- Comment Reply END --}}
    </section>

    <!-- -------------------------------------------------------------------------------------------------------------------- -->

    {{-- Comment Replies Section START --}}
    @if($comment->comments->isNotEmpty())
        <div x-cloak x-transition x-show="openReply" class="ml-30 space-y-4">
            @foreach ($this->getChildComments as $childComment)
                <div wire:key="reply-{{ $childComment->id }}" class="relative">
                    <svg class="-left-6.5 w-6 h-6 absolute text-slate-800 dark:text-slate-100" fill="currentColor" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 50 50" xml:space="preserve">
                        <desc>Created with Fabric.js 5.2.4</desc>
                        <defs>
                        </defs>
                        <rect x="0" y="0" width="100%" height="100%" fill="transparent"></rect>
                        <g transform="matrix(1 0 0 1 25 25)" id="34bc211f-eb27-480f-986d-da62887d52df"  >
                        <rect style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1; visibility: hidden;" vector-effect="non-scaling-stroke"  x="-25" y="-25" rx="0" ry="0" width="50" height="50" />
                        </g>
                        <g transform="matrix(-2 0 0 -2 25 25)"  >
                        <path style="stroke: rgb(83,83,88); stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill-rule: nonzero; opacity: 1;" vector-effect="non-scaling-stroke"  transform=" translate(-16.04, -16.27)" d="M 5.608 12.526 L 12.648 6.072 C 13.931 4.896 16 5.806 16 7.546 L 16 11 C 29 11 27 27 27 27 C 27 27 23 17 16 17 L 16 20.453 C 16 22.192999999999998 13.931000000000001 23.102999999999998 12.649000000000001 21.928 L 5.609000000000001 15.474 C 5.195945409553897 15.095193215558865 4.960785485940725 14.560453989750481 4.960785485940725 14 C 4.960785485940725 13.439546010249519 5.195945409553897 12.904806784441135 5.609000000000001 12.526 z" stroke-linecap="round" />
                        </g>
                    </svg>
                </div>
                <livewire:comment.comment-item :key="'childComment-'.$childComment->id.$count" :comment="$childComment" :$post />
            @endforeach
        </div>
    @endif
    {{-- Comment Replies Section END --}}

    <!-- -------------------------------------------------------------------------------------------------------------------- -->

    {{-- Delete Comment Modal START --}}
    <x-modals.modal name="deleteModal-{{ $comment->id }}" height="max-h-40" width="max-w-xs">
        @slot('body')
            Are you sure?
        @endslot
        @slot('footer')
            <button x-on:click="show = false" wire:click.prevent="deleteComment" type="button" class="px-5 py-2.5 me-2 text-sm font-medium text-white bg-red-700 rounded-lg dark:bg-red-600 dark:focus:ring-red-900 dark:hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 hover:bg-red-800">Delete</button>
            <button x-on:click="show = false" type="button" class="px-5 py-2.5 text-sm font-medium text-white bg-slate-800 rounded-lg border border-slate-600 dark:text-slate-900 dark:bg-white dark:border-slate-300 dark:focus:outline-none dark:focus:ring-slate-100 dark:hover:bg-slate-100 dark:hover:border-slate-600 focus:ring-4 focus:ring-slate-700 hover:bg-slate-700">Cancel</button>
        @endslot
    </x-modals.modal>
    {{-- Delete Comment Modal END --}}

    <!-- -------------------------------------------------------------------------------------------------------------------- -->

    @push('scripts')
        <script src="{{ asset('JS/comment.js') }}"></script>
    @endpush
</article>
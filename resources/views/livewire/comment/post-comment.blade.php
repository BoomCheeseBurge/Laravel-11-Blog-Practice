<div>
    {{-- Comment Section Header START --}}
    <h3 class="text-lg font-semibold">Discussions ({{ $this->countComments() }})</h3>
    {{-- Comment Section Header END --}}

    {{-- Comment Create START --}}
    @auth
    <livewire:comment.comment-create :$post />
    @else
    <section class="w-full flex flex-col items-center py-6 bg-slate-100 rounded-md opacity-90 dark:bg-primary-800">
        <div class="dark:text-slate-100">Already a user? Login to comment!</div>
        <a href="/login" class="dark:text-cyan-300">Click Here</a>
    </section>
    @endauth
    {{-- Comment Create END --}}

    {{-- Comment Section Body START --}}
    <div class="space-y-8">
        @forelse ($this->getComments as $comment)
            <livewire:comment.comment-item :key="'comment-'.$comment->id.$count" :$comment :$post />
        @empty
        <section class="px-5 py-5 mt-5 text-lg font-semibold text-center bg-slate-100 rounded-lg dark:bg-slate-900 lg:text-xl md:px-10">
            Be the first to comment!
        </section>
        @endforelse
    </div>
    {{-- Comment Section Body END --}}
    
    {{-- Comment Section Pagination START --}}
    <div class="my-2">
        {{ $this->getComments->links(data: ['scrollTo' => false]) }}
    </div>
    {{-- Comment Section Pagination END --}}
</div>
<div x-cloak x-data="{
        focused: false,
        init() {
            $wire.on('submitComment', () => focused = false);
        }
    }" class="flex flex-col">
    <textarea x-on:click="focused = true" x-on:click.away="focused = false" wire:model="comment" :rows="focused ? '6' : '1'" 
    :class="focused ? 'placeholder-primary-800 max-w-lg' : 'max-w-xs'" 
    class="mb-5 rounded-md resize-none dark:placeholder-slate-300 dark:text-white dark:bg-slate-800" 
    placeholder="Write a comment..."></textarea>
    <button  wire:click="submitComment" x-bind:class="focused ? 'block' : 'hidden'" type="button" class="max-w-26 py-3.5 me-2 mb-2 text-sm font-medium text-white bg-blue-700 rounded-lg dark:bg-blue-600 dark:focus:ring-blue-800 dark:hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 hover:bg-blue-800 lg:max-w-32 lg:text-base">Submit</button>
</div>
<div class="clear-input-container w-full h-full relative inline-block">
    <input name="search" type="search" 
        class="clear-input w-full h-full text-xs font-thin tracking-wider leading-normal text-slate-800 rounded rounded-l-none border border-l-0 border-none dark:placeholder-white dark:text-teal-100 dark:bg-slate-600 dark:focus:ring-teal-400 focus:outline-none lg:text-base"
        {{ $attributes }}
    >
    
    <button
        class="clear-input-button rounded-[50%] w-6 h-6 absolute top-3 right-3 hidden justify-center items-center p-0.5 m-0 text-base text-white bg-gray-500 border-none appearance-none cursor-pointer hover:bg-slate-400"
        aria-label="Clear input"
        title="Clear input"
        onclick="event.preventDefault();"
    >×</button>
</div>
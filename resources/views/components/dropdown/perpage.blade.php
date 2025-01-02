@props(['perPage' => 10])

<div class="w-full flex justify-center items-center space-y-3 text-slate-900 dark:text-white md:max-w-29 md:max-h-10 md:space-x-2 md:space-y-0">
    <span class="text-sm max-md:pt-2 max-md:mr-3">Per Page:</span>

    <form id="itemsPerPage">
        <select id="pagination" name="perPage" class="border-t-0 border-r-0 border-b-2 border-l-0 border-b-slate-700 dark:bg-slate-700 focus:ring-0">
            <option value="10" 
            @if ($perPage == 10)
                selected
            @endif
            >10</option>
            <option value="15" 
            @if ($perPage == 15)
                selected
            @endif
            >15</option>
            <option value="20" 
            @if ($perPage == 20)
                selected
            @endif
            >20</option>
        </select>
    </form>
</div>
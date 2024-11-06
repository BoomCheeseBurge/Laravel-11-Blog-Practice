@props(['active' => false])

<a {{ $attributes->merge(['class' => ($active ? 'bg-primary-800 dark:bg-slate-200 text-slate-200 dark:text-primary-800 font-bold' : 'text-primary-600 hover:bg-slate-300 hover:text-primary-800 dark:text-gray-200 dark:hover:bg-slate-700 dark:hover:text-whiter hover:underline font-medium') . ' rounded-md px-3 py-2 tracking-widest text-[1rem]']) }}
    aria-current="{{ $active ? 'page' : false }}">
    {{ $slot }}
</a>

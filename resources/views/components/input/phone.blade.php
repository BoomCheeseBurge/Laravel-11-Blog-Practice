@aware(['error'])
@props(['error'])

<div {{ $attributes->merge(['class' => 'relative']) }}>
    <div class="absolute inset-y-0 left-0 flex items-center">
        <label for="country" class="sr-only">Country</label>
        <select id="country" name="country" class="h-full py-0 pr-9 pl-4 text-gray-400 bg-transparent bg-none [&>option]:bg-slate-100 [&>option]:text-boxdark-2 rounded-md border-0 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
            <option>US</option>
            <option>CA</option>
            <option>EU</option>
        </select>
        <svg class="w-5 h-full absolute top-0 right-1.5 text-gray-400 pointer-events-none" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
        </svg>
    </div>
    <input type="tel" name="phone-number" x-bind:id="$id('input')"  
        {{ $attributes->class(['w-full block px-3.5 py-2 rounded-md shadow-sm placeholder:text-gray-400 ring-1 ring-gray-300 dark:ring-gray-600 sm:text-sm/6',
            'border-none focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-600' => !$error,
            'border-2 border-red-500 ring-offset-0 ring-0 focus:ring-0 outline-0' => $error
        ]) }}
    autocomplete="off">
</div>
@props([
    'placeholder' => 'Search…',
    'value' => null,
])

<form method="GET" class="relative w-full sm:w-72">
    <span class="pointer-events-none absolute inset-y-0 left-0 grid w-9 place-items-center text-slate-400">
        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path fill-rule="evenodd" d="M9 3a6 6 0 1 0 3.84 10.6l3.78 3.78a1 1 0 1 0 1.42-1.42l-3.78-3.78A6 6 0 0 0 9 3Zm-4 6a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" clip-rule="evenodd"/></svg>
    </span>
    <input type="search" name="q" value="{{ $value }}" placeholder="{{ $placeholder }}"
           class="w-full rounded-full border border-slate-200 bg-white py-2 pl-9 pr-3 text-sm shadow-sm transition focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
    @if (filled($value))
        <a href="{{ url()->current() }}" class="absolute inset-y-0 right-0 grid w-9 place-items-center text-slate-400 hover:text-brand-red-500" title="Clear search">
            <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5"><path d="M6.3 5.3a1 1 0 0 1 1.4 0L10 7.6l2.3-2.3a1 1 0 1 1 1.4 1.4L11.4 9l2.3 2.3a1 1 0 0 1-1.4 1.4L10 10.4l-2.3 2.3a1 1 0 0 1-1.4-1.4L8.6 9 6.3 6.7a1 1 0 0 1 0-1.4Z"/></svg>
        </a>
    @endif
</form>

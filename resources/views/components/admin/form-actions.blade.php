@props([
    'backTo',
    'submitLabel' => 'Save',
])

<div class="sticky bottom-0 -mx-5 flex items-center justify-between border-t border-slate-200 bg-white/95 px-5 py-3 backdrop-blur lg:-mx-8 lg:px-8">
    <a href="{{ $backTo }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-800">
        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M17 10a.75.75 0 0 1-.75.75H5.6l4.18 3.96a.75.75 0 1 1-1.08 1.04l-5.5-5.75a.75.75 0 0 1 0-1.04l5.5-5.75a.75.75 0 1 1 1.08 1.04L5.6 9.25h10.65A.75.75 0 0 1 17 10Z"/></svg>
        Back
    </a>
    <button type="submit" class="inline-flex items-center gap-1.5 rounded-full bg-brand-red-500 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-red-600">
        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 0 1 0 1.4l-7.5 7.5a1 1 0 0 1-1.4 0L3.3 9.7a1 1 0 1 1 1.4-1.4l3.8 3.8 6.8-6.8a1 1 0 0 1 1.4 0Z" clip-rule="evenodd"/></svg>
        {{ $submitLabel }}
    </button>
</div>

{{-- Reusable share row. Pass $url + $title via @include data. Vertical on lg+. --}}
@php
    $shareUrl   = urlencode($url);
    $shareTitle = urlencode($title);
@endphp

<div x-data="{ copied: false }"
     class="flex flex-wrap items-center gap-2 lg:flex-col lg:items-stretch">

    <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}"
       target="_blank" rel="noopener" aria-label="Share on X"
       class="group inline-flex items-center justify-center gap-2 rounded-full bg-brand-cream px-3 py-2 text-xs font-semibold text-brand-ink transition hover:bg-brand-red-500 hover:text-white">
        <svg viewBox="0 0 24 24" fill="currentColor" class="h-3.5 w-3.5">
            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24h-6.66l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231Zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77Z"/>
        </svg>
        <span class="lg:hidden">X</span>
    </a>

    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
       target="_blank" rel="noopener" aria-label="Share on Facebook"
       class="group inline-flex items-center justify-center gap-2 rounded-full bg-brand-cream px-3 py-2 text-xs font-semibold text-brand-ink transition hover:bg-brand-red-500 hover:text-white">
        <svg viewBox="0 0 24 24" fill="currentColor" class="h-3.5 w-3.5">
            <path d="M22 12a10 10 0 1 0-11.6 9.9v-7H8v-3h2.4V9.5C10.4 7 11.9 6 14 6c.9 0 1.8.2 1.8.2v2h-1c-1 0-1.3.6-1.3 1.3V12H16l-.4 3H13.5v7A10 10 0 0 0 22 12Z"/>
        </svg>
        <span class="lg:hidden">FB</span>
    </a>

    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}"
       target="_blank" rel="noopener" aria-label="Share on LinkedIn"
       class="group inline-flex items-center justify-center gap-2 rounded-full bg-brand-cream px-3 py-2 text-xs font-semibold text-brand-ink transition hover:bg-brand-red-500 hover:text-white">
        <svg viewBox="0 0 24 24" fill="currentColor" class="h-3.5 w-3.5">
            <path d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2ZM8.4 18H5.6V10h2.8v8ZM7 8.7a1.6 1.6 0 1 1 0-3.3 1.6 1.6 0 0 1 0 3.3ZM18.4 18h-2.8v-4.1c0-1-.4-1.6-1.3-1.6-.8 0-1.2.5-1.4 1.1V18h-2.8v-8h2.7v1.2a3 3 0 0 1 2.6-1.4c1.9 0 3 1.3 3 3.7V18Z"/>
        </svg>
        <span class="lg:hidden">in</span>
    </a>

    <button type="button"
            @click="navigator.clipboard.writeText('{{ $url }}'); copied = true; setTimeout(() => copied = false, 1800)"
            aria-label="Copy link"
            class="group inline-flex items-center justify-center gap-2 rounded-full bg-brand-cream px-3 py-2 text-xs font-semibold text-brand-ink transition hover:bg-brand-red-500 hover:text-white">
        <svg x-show="!copied" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
            <path d="M8.7 2.7a4 4 0 0 1 5.7 5.7l-2.5 2.5a4 4 0 0 1-5.7 0 1 1 0 0 1 1.4-1.4 2 2 0 0 0 2.9 0l2.5-2.5a2 2 0 0 0-2.9-2.9l-1 1a1 1 0 1 1-1.4-1.4l1-1Z"/>
            <path d="M6.7 9.3a4 4 0 0 1 5.7 0 1 1 0 0 1-1.4 1.4 2 2 0 0 0-2.9 0L5.6 13.2a2 2 0 0 0 2.9 2.9l1-1a1 1 0 1 1 1.4 1.4l-1 1a4 4 0 0 1-5.7-5.7l2.5-2.5Z"/>
        </svg>
        <svg x-show="copied" x-cloak viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5 text-brand-green-600">
            <path fill-rule="evenodd" d="M16.7 5.3a1 1 0 0 1 0 1.4l-7.5 7.5a1 1 0 0 1-1.4 0L3.3 9.7a1 1 0 1 1 1.4-1.4l3.8 3.8 6.8-6.8a1 1 0 0 1 1.4 0Z" clip-rule="evenodd"/>
        </svg>
        <span class="lg:hidden" x-text="copied ? 'Copied' : 'Copy'"></span>
    </button>
</div>

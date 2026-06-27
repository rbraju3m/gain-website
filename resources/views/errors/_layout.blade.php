{{-- Shared inner content for branded error pages.
     Props (via @include data): $code, $title, $body, $iconPath. --}}
<section class="relative -mt-[72px] overflow-hidden bg-hero-wash py-32 lg:py-40">
    <div class="blob-drift-a pointer-events-none absolute -top-32 -left-32 h-[460px] w-[460px] rounded-full bg-brand-red-100/60 blur-3xl"></div>
    <div class="blob-drift-b pointer-events-none absolute bottom-0 right-0 h-[420px] w-[420px] rounded-full bg-brand-green-100/70 blur-3xl"></div>

    <div class="relative mx-auto max-w-3xl px-6 text-center lg:px-10">
        <div class="reveal mx-auto grid h-20 w-20 place-items-center rounded-full bg-brand-red-100 text-brand-red-500">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-10 w-10">
                <path d="{{ $iconPath }}"/>
            </svg>
        </div>

        <div class="reveal reveal-delay-100 mt-8 font-display text-[120px] font-bold leading-none text-brand-red-500 sm:text-[160px]">
            {{ $code }}
        </div>

        <h1 class="reveal reveal-delay-100 mt-2 font-display text-3xl font-bold text-brand-ink sm:text-4xl">
            {{ $title }}
        </h1>
        <p class="reveal reveal-delay-200 mx-auto mt-4 max-w-xl text-brand-muted">
            {{ $body }}
        </p>

        <div class="reveal reveal-delay-300 mt-8 flex flex-wrap items-center justify-center gap-3">
            <a href="{{ url('/') }}"
               class="btn-shimmer inline-flex items-center gap-2 rounded-full bg-brand-red-500 px-6 py-3 text-sm font-semibold text-white shadow-pill hover:bg-brand-red-600">
                <span class="inline-flex items-center gap-2">
                    Back to homepage
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/></svg>
                </span>
            </a>
            <a href="{{ url('/#contact') }}" class="inline-flex items-center gap-2 rounded-full border border-brand-ink/15 bg-white px-6 py-3 text-sm font-semibold text-brand-ink hover:border-brand-ink/30 hover:bg-brand-red-50">
                Contact us
            </a>
        </div>
    </div>
</section>

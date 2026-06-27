{{-- Dark editorial CTA card that lives at the end of every Programme + News
     detail page. Bypasses the standard donate flow by linking to the
     homepage CTA section (the donation tiers). --}}
<div class="reveal mt-16 overflow-hidden rounded-3xl bg-cta-burgundy p-8 text-white shadow-card sm:p-12">
    <div class="grid items-center gap-8 lg:grid-cols-[1fr_auto]">
        <div>
            <div class="text-[10px] font-semibold uppercase tracking-[0.18em] text-brand-orange-300">
                Help us continue this work
            </div>
            <h3 class="mt-3 font-display text-2xl font-bold leading-tight sm:text-3xl">
                Every contribution funds a meal,
                a training, a healthier future.
            </h3>
            <p class="mt-3 max-w-xl text-sm text-white/75 sm:text-base">
                Independent funding lets us keep going where we're needed most.
                Join us — give once, give monthly, or partner with us.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ url('/#cta') }}"
               class="btn-shimmer inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 text-sm font-semibold text-brand-red-500 shadow-pill hover:bg-brand-cream">
                <span class="inline-flex items-center gap-2">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                        <path d="M10 17s-6-4.1-6-9.1A3.9 3.9 0 0 1 10 4.4 3.9 3.9 0 0 1 16 7.9c0 5-6 9.1-6 9.1Z"/>
                    </svg>
                    Donate
                </span>
            </a>
            <a href="{{ url('/#contact') }}"
               class="inline-flex items-center gap-2 rounded-full border border-white/40 px-6 py-3 text-sm font-semibold text-white hover:bg-white/10">
                Partner with us
            </a>
        </div>
    </div>
</div>

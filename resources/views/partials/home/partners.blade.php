{{-- Section 10: Our Partners --}}
@php
    $strategicPartners    = \App\Models\Partner::forHomepageStrategic();
    $implementingPartners = \App\Models\Partner::forHomepageImplementing();
@endphp

<section id="partners" class="relative overflow-hidden bg-section-cream-alt py-24">
    {{-- Subtle dotted backdrop --}}
    <div class="pointer-events-none absolute inset-0 bg-dots opacity-40"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-10">

        <div class="text-center">
            <h2 class="reveal font-display text-4xl font-bold text-brand-ink sm:text-5xl">
                Our <span class="text-brand-red-500">Partners</span>
            </h2>
            <p class="reveal reveal-delay-100 mx-auto mt-4 max-w-2xl text-brand-muted">
                Working together with leading organizations to amplify our impact.
            </p>
        </div>

        {{-- Row 1: Strategic partners — static grid --}}
        @if ($strategicPartners->isNotEmpty())
            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @php $delays = ['', 'reveal-delay-100', 'reveal-delay-200', 'reveal-delay-300']; @endphp
                @foreach ($strategicPartners as $i => $p)
                    @php $logo = $p->logoUrl(); @endphp
                    @php $tag  = $p->url ? 'a' : 'div'; @endphp
                    <{{ $tag }} @if ($p->url) href="{{ $p->url }}" target="_blank" rel="noopener" @endif
                        class="reveal {{ $delays[$i % count($delays)] }} group flex h-32 items-center justify-center rounded-2xl bg-white p-5 shadow-card ring-1 ring-black/5 transition-all duration-300 hover:-translate-y-1 hover:shadow-soft">
                        @if ($logo)
                            <img src="{{ $logo }}" alt="{{ $p->name }}" class="max-h-full max-w-full object-contain transition group-hover:scale-105">
                        @else
                            <span class="text-sm font-semibold text-brand-ink">{{ $p->name }}</span>
                        @endif
                    </{{ $tag }}>
                @endforeach
            </div>
        @endif

        {{-- Row 2: Implementing partners — horizontal scrolling marquee --}}
        @if ($implementingPartners->isNotEmpty())
            <div class="reveal reveal-delay-200 mt-8 group relative overflow-hidden">
                {{-- Fade edges --}}
                <div class="pointer-events-none absolute inset-y-0 left-0 z-10 w-20 bg-gradient-to-r from-brand-cream to-transparent"></div>
                <div class="pointer-events-none absolute inset-y-0 right-0 z-10 w-20 bg-gradient-to-l from-brand-cream to-transparent"></div>

                <div class="marquee-track flex w-max gap-6">
                    @foreach (collect()->range(1, 3)->flatMap(fn () => $implementingPartners) as $p)
                        @php $logo = $p->logoUrl(); @endphp
                        <div class="flex h-32 w-72 shrink-0 items-center justify-center rounded-2xl bg-white p-5 shadow-card ring-1 ring-black/5">
                            @if ($logo)
                                <img src="{{ $logo }}" alt="{{ $p->name }}" class="max-h-full max-w-full object-contain">
                            @else
                                <span class="text-sm font-semibold text-brand-ink">{{ $p->name }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    {{-- Divider: cream → burgundy (into CTA) --}}
    <svg viewBox="0 0 1440 90" class="relative mt-12 block w-full text-[#9C2245]" preserveAspectRatio="none" aria-hidden="true">
        <path fill="currentColor" d="M0,40 C300,80 600,10 900,45 C1140,75 1300,60 1440,30 L1440,90 L0,90 Z"/>
    </svg>
</section>

<style>
    @keyframes marquee {
        0%   { transform: translateX(0); }
        100% { transform: translateX(-33.3333%); }
    }
    .marquee-track {
        animation: marquee 28s linear infinite;
    }
    .group:hover .marquee-track {
        animation-play-state: paused;
    }
</style>

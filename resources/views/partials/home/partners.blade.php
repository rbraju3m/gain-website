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
                Our <span class="draw-underline-red text-brand-red-500">Partners</span>
            </h2>
            <p class="reveal reveal-delay-100 mx-auto mt-4 max-w-2xl text-brand-muted">
                Working together with leading organizations to amplify our impact.
            </p>
        </div>

        {{-- Row 1: Strategic partners — horizontal scrolling marquee (left → right) --}}
        @if ($strategicPartners->isNotEmpty())
            <div class="reveal mt-14 group relative overflow-hidden">
                <div class="pointer-events-none absolute inset-y-0 left-0 z-10 w-20 bg-gradient-to-r from-brand-cream to-transparent"></div>
                <div class="pointer-events-none absolute inset-y-0 right-0 z-10 w-20 bg-gradient-to-l from-brand-cream to-transparent"></div>

                <div class="marquee-track flex w-max gap-4">
                    @foreach (collect()->range(1, 3)->flatMap(fn () => $strategicPartners) as $p)
                        @php $logo = $p->logoUrl(); @endphp
                        @php $tag  = $p->url ? 'a' : 'div'; @endphp
                        <{{ $tag }} @if ($p->url) href="{{ $p->url }}" target="_blank" rel="noopener" @endif
                            class="flex h-24 w-52 shrink-0 items-center justify-center rounded-xl bg-white p-3 shadow-card ring-1 ring-black/5 transition hover:-translate-y-0.5 hover:shadow-soft">
                            @if ($logo)
                                <img src="{{ $logo }}" alt="{{ $p->name }}" class="max-h-full max-w-full object-contain">
                            @else
                                <span class="text-sm font-semibold text-brand-ink">{{ $p->name }}</span>
                            @endif
                        </{{ $tag }}>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Row 2: Implementing partners — horizontal scrolling marquee (right → left) --}}
        @if ($implementingPartners->isNotEmpty())
            <div class="reveal reveal-delay-200 mt-6 group relative overflow-hidden">
                <div class="pointer-events-none absolute inset-y-0 left-0 z-10 w-20 bg-gradient-to-r from-brand-cream to-transparent"></div>
                <div class="pointer-events-none absolute inset-y-0 right-0 z-10 w-20 bg-gradient-to-l from-brand-cream to-transparent"></div>

                <div class="marquee-track marquee-track-reverse flex w-max gap-4">
                    @foreach (collect()->range(1, 3)->flatMap(fn () => $implementingPartners) as $p)
                        @php $logo = $p->logoUrl(); @endphp
                        <div class="flex h-24 w-52 shrink-0 items-center justify-center rounded-xl bg-white p-3 shadow-card ring-1 ring-black/5">
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

    {{-- Layered wave: cream → burgundy (into CTA) --}}
    @include('partials.wave-divider', ['colorClass' => 'text-[#9C2245]', 'variant' => 'burgundy'])
</section>

<style>
    @keyframes marquee {
        0%   { transform: translateX(0); }
        100% { transform: translateX(-33.3333%); }
    }
    @keyframes marquee-reverse {
        0%   { transform: translateX(-33.3333%); }
        100% { transform: translateX(0); }
    }
    .marquee-track          { animation: marquee 28s linear infinite; }
    .marquee-track-reverse  { animation: marquee-reverse 32s linear infinite; }
    .group:hover .marquee-track { animation-play-state: paused; }
</style>

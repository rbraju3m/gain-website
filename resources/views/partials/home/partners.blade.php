{{-- Section 10: Our Partners --}}
@php
    // Strategic partners (Row 1: static grid)
    $strategicPartners = [
        ['name' => 'World Food Programme', 'slug' => 'wfp'],
        ['name' => 'UNICEF Bangladesh',    'slug' => 'unicef'],
        ['name' => 'BRAC',                 'slug' => 'brac'],
        ['name' => 'FAO Bangladesh',       'slug' => 'fao'],
    ];

    // Implementing partners (Row 2: horizontal scrolling marquee)
    $implementingPartners = [
        ['name' => 'Save the Children',         'slug' => 'savethechildren'],
        ['name' => 'ActionAid',                 'slug' => 'actionaid'],
        ['name' => 'Ministry of Health',        'slug' => 'moh'],
        ['name' => 'Local Government Division', 'slug' => 'lgd'],
    ];
@endphp

<section id="partners" class="bg-brand-cream py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">

        <div class="text-center">
            <h2 class="font-display text-4xl font-bold text-brand-ink sm:text-5xl">
                Our <span class="text-brand-red-500">Partners</span>
            </h2>
            <p class="mx-auto mt-4 max-w-2xl text-brand-muted">
                Working together with leading organizations to amplify our impact.
            </p>
        </div>

        {{-- Row 1: Strategic partners — static grid --}}
        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($strategicPartners as $p)
                <div class="group flex h-32 items-center justify-center rounded-2xl bg-white p-5 shadow-card ring-1 ring-black/5 transition hover:-translate-y-0.5 hover:shadow-soft">
                    <img
                        src="{{ asset('images/partners/' . $p['slug'] . '.svg') }}"
                        alt="{{ $p['name'] }}"
                        class="max-h-full max-w-full object-contain transition group-hover:scale-105"
                    >
                </div>
            @endforeach
        </div>

        {{-- Row 2: Implementing partners — horizontal scrolling marquee --}}
        <div class="mt-8 group relative overflow-hidden">
            {{-- Fade edges --}}
            <div class="pointer-events-none absolute inset-y-0 left-0 z-10 w-20 bg-gradient-to-r from-brand-cream to-transparent"></div>
            <div class="pointer-events-none absolute inset-y-0 right-0 z-10 w-20 bg-gradient-to-l from-brand-cream to-transparent"></div>

            <div class="marquee-track flex w-max gap-6">
                @foreach (array_merge($implementingPartners, $implementingPartners, $implementingPartners) as $p)
                    <div class="flex h-32 w-72 shrink-0 items-center justify-center rounded-2xl bg-white p-5 shadow-card ring-1 ring-black/5">
                        <img
                            src="{{ asset('images/partners/' . $p['slug'] . '.svg') }}"
                            alt="{{ $p['name'] }}"
                            class="max-h-full max-w-full object-contain"
                        >
                    </div>
                @endforeach
            </div>
        </div>
    </div>
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

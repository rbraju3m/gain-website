{{-- Section 8: Bangladesh Map — divisions + active-district coverage --}}
@php
    // Pre-computed structure (divisionInfo + districts[] w/ x/y already
    // projected). forHomepage() is cached forever; saving any Division or
    // District (including the bulk districts toggle) busts the cache.
    ['divisionInfo' => $divisionInfo, 'districts' => $districts] = \App\Models\Division::forHomepage();
@endphp

<section id="map" class="bg-blueprint py-24"
         x-data="{
            active: 'dhaka',
            divisions: @js($divisionInfo),
            current() { return this.divisions[this.active]; }
         }"
         x-init="
            $nextTick(() => {
                $refs.map.querySelectorAll('.bd-div').forEach(g => {
                    const key = g.dataset.division;
                    g.addEventListener('mouseenter', () => active = key);
                    g.addEventListener('click',      () => active = key);
                });
            });
            $watch('active', value => {
                $refs.map.querySelectorAll('.bd-div').forEach(g => {
                    g.classList.toggle('is-active', g.dataset.division === value);
                });
            });
         ">

    <div class="mx-auto max-w-7xl px-6 lg:px-10">

        <div class="text-center">
            <span class="reveal inline-flex items-center gap-2 rounded-full border border-brand-red-200 bg-white/80 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-brand-red-500">
                <span class="h-1.5 w-1.5 rounded-full bg-brand-red-500"></span>
                Where We Work
            </span>
            <h2 class="reveal reveal-delay-100 mt-5 font-display text-4xl font-bold text-brand-ink sm:text-5xl">
                Our Reach Across <span class="draw-underline-green text-brand-green-600">Bangladesh</span>
            </h2>
            <p class="reveal reveal-delay-200 mx-auto mt-4 max-w-2xl text-brand-muted">
                Hover or tap a division to see impact. Filled dots mark districts with active programmes.
            </p>
        </div>

        <div class="mt-12 grid items-start gap-8 lg:grid-cols-5">

            {{-- Map (3 of 5 cols) --}}
            <div class="lg:col-span-3">
                <div class="relative rounded-[2rem] bg-white p-4 sm:p-6 shadow-card ring-1 ring-black/5">
                    <div class="bd-map relative" x-ref="map">
                        {{-- Base SVG: real Bangladesh divisions --}}
                        {!! file_get_contents(public_path('images/bangladesh-divisions.svg')) !!}

                        {{-- Overlay SVG: district markers (same viewBox) — active districts only --}}
                        <svg viewBox="0 0 1550 2149" class="district-overlay" aria-hidden="true">
                            @foreach ($districts as $d)
                                @continue(! $d['active'])
                                <g class="district-marker"
                                   data-name="{{ $d['name'] }}"
                                   data-division="{{ $d['division'] }}">
                                    <circle cx="{{ $d['x'] }}" cy="{{ $d['y'] }}" r="22" class="pulse-ring"/>
                                    <circle cx="{{ $d['x'] }}" cy="{{ $d['y'] }}" r="14" fill="#FFFFFF" stroke="#9C2245" stroke-width="3"/>
                                    <circle cx="{{ $d['x'] }}" cy="{{ $d['y'] }}" r="7"  fill="#9C2245"/>
                                    {{-- Label: white halo behind for legibility on the green division fill --}}
                                    <text x="{{ $d['x'] + 28 }}" y="{{ $d['y'] + 14 }}"
                                          class="district-label-halo">{{ $d['name'] }}</text>
                                    <text x="{{ $d['x'] + 28 }}" y="{{ $d['y'] + 14 }}"
                                          class="district-label">{{ $d['name'] }}</text>
                                    <title>{{ $d['name'] }} — Active programme</title>
                                </g>
                            @endforeach
                        </svg>
                    </div>

                    {{-- Legend --}}
                    <div class="mt-4 flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-xs text-brand-muted">
                        <div class="flex items-center gap-2">
                            <span class="grid h-4 w-4 place-items-center rounded-full bg-brand-red-500 ring-2 ring-white"></span>
                            Active programme district
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar (2 of 5 cols): active districts in the hovered region --}}
            <div class="lg:col-span-2">
                <div class="rounded-[2rem] bg-white p-8 shadow-card ring-1 ring-black/5">
                    <div class="flex items-center gap-3">
                        <span class="grid h-10 w-10 place-items-center rounded-full bg-brand-red-100 text-brand-red-500">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                <path d="M12 2a7 7 0 0 0-7 7c0 5.5 7 13 7 13s7-7.5 7-13a7 7 0 0 0-7-7Zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
                            </svg>
                        </span>
                        <div>
                            <div class="text-xs uppercase tracking-wider text-brand-muted">Active Districts</div>
                            <div class="font-display text-2xl font-bold text-brand-red-500">
                                <span x-text="current().active_districts">6</span>
                                <span class="text-sm font-semibold text-brand-muted">/ <span x-text="current().total_districts">13</span> covered</span>
                            </div>
                        </div>
                    </div>

                    <ul class="mt-6 grid grid-cols-2 gap-x-4 gap-y-2 text-sm text-brand-ink"
                        x-show="current().active_district_names.length">
                        <template x-for="name in current().active_district_names" :key="name">
                            <li class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-brand-red-500"></span>
                                <span x-text="name"></span>
                            </li>
                        </template>
                    </ul>
                    <p class="mt-6 text-sm italic text-brand-muted"
                       x-show="! current().active_district_names.length">
                        No active districts in this region yet.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .bd-map svg { width: 100%; height: auto; max-height: 640px; display: block; }
    .bd-map .district-overlay { position: absolute; inset: 1rem; pointer-events: none; z-index: 2; }

    /* Base division paths */
    .bd-map g.bd-div path {
        fill: #E3F0D4;
        stroke: #FFFFFF;
        stroke-width: 2;
        transition: fill 0.18s ease;
        cursor: pointer;
    }
    .bd-map g.bd-div:hover path { fill: #B5D78F; }
    .bd-map g.bd-div.is-active path { fill: #87B558; }

    /* District markers */
    .district-marker { pointer-events: auto; cursor: pointer; }
    .district-marker:hover { filter: drop-shadow(0 4px 6px rgba(156,34,69,0.45)); }

    /* District name labels (rendered inside SVG viewBox 1550x2149) */
    .district-label, .district-label-halo {
        font-family: 'Figtree', system-ui, sans-serif;
        font-size: 38px;
        font-weight: 700;
        dominant-baseline: middle;
        pointer-events: none;
    }
    .district-label { fill: #9C2245; }
    .district-label-halo {
        fill: none;
        stroke: #FFFFFF;
        stroke-width: 7;
        stroke-linejoin: round;
        paint-order: stroke;
    }

    /* Pulse ring for active districts */
    .pulse-ring {
        fill: #9C2245;
        opacity: 0.2;
        transform-origin: center;
        transform-box: fill-box;
        animation: marker-pulse 2.4s ease-out infinite;
    }
    @keyframes marker-pulse {
        0%   { transform: scale(0.5); opacity: 0.45; }
        70%  { transform: scale(1.4); opacity: 0;    }
        100% { transform: scale(1.4); opacity: 0;    }
    }
</style>

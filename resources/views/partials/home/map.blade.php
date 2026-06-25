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
                Our Reach Across <span class="text-brand-green-600">Bangladesh</span>
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

                        {{-- Overlay SVG: district markers (same viewBox) --}}
                        <svg viewBox="0 0 1550 2149" class="district-overlay" aria-hidden="true">
                            @foreach ($districts as $d)
                                <g class="district-marker"
                                   data-name="{{ $d['name'] }}"
                                   data-division="{{ $d['division'] }}">
                                    @if ($d['active'])
                                        {{-- Active: pulsing ring + solid dot --}}
                                        <circle cx="{{ $d['x'] }}" cy="{{ $d['y'] }}" r="22" class="pulse-ring"/>
                                        <circle cx="{{ $d['x'] }}" cy="{{ $d['y'] }}" r="14" fill="#FFFFFF" stroke="#9C2245" stroke-width="3"/>
                                        <circle cx="{{ $d['x'] }}" cy="{{ $d['y'] }}" r="7"  fill="#9C2245"/>
                                    @else
                                        {{-- Inactive: small muted dot --}}
                                        <circle cx="{{ $d['x'] }}" cy="{{ $d['y'] }}" r="6" fill="#FFFFFF" stroke="#1F1B22" stroke-opacity="0.35" stroke-width="1.5"/>
                                    @endif
                                    <title>{{ $d['name'] }}{{ $d['active'] ? ' — Active programme' : '' }}</title>
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
                        <div class="flex items-center gap-2">
                            <span class="grid h-4 w-4 place-items-center rounded-full bg-white ring-2 ring-brand-ink/30"></span>
                            Not yet covered
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar (2 of 5 cols) --}}
            <div class="lg:col-span-2">
                <div class="rounded-[2rem] bg-white p-8 shadow-card ring-1 ring-black/5">
                    <div class="flex items-center gap-3">
                        <span class="grid h-10 w-10 place-items-center rounded-full bg-brand-red-100 text-brand-red-500">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                <path d="M12 2a7 7 0 0 0-7 7c0 5.5 7 13 7 13s7-7.5 7-13a7 7 0 0 0-7-7Zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
                            </svg>
                        </span>
                        <div>
                            <div class="text-xs uppercase tracking-wider text-brand-muted">Division</div>
                            <div class="font-display text-2xl font-bold text-brand-red-500" x-text="current().name">Dhaka</div>
                        </div>
                    </div>

                    <dl class="mt-6 space-y-4">
                        <div class="flex items-center justify-between border-b border-brand-cream pb-3">
                            <dt class="text-sm text-brand-muted">Families Served</dt>
                            <dd class="font-display text-xl font-bold text-brand-red-500" x-text="current().families">4,200+</dd>
                        </div>
                        <div class="flex items-center justify-between border-b border-brand-cream pb-3">
                            <dt class="text-sm text-brand-muted">Active Programmes</dt>
                            <dd class="font-display text-xl font-bold text-brand-green-600" x-text="current().programmes">62</dd>
                        </div>
                        <div class="flex items-center justify-between border-b border-brand-cream pb-3">
                            <dt class="text-sm text-brand-muted">Districts Covered</dt>
                            <dd class="font-display text-xl font-bold text-brand-orange-500">
                                <span x-text="current().active_districts">6</span>
                                <span class="text-sm text-brand-muted">/ <span x-text="current().total_districts">13</span></span>
                            </dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-sm text-brand-muted">Success Rate</dt>
                            <dd class="font-display text-xl font-bold text-brand-green-600" x-text="current().success">98%</dd>
                        </div>
                    </dl>

                    <a href="#" class="mt-7 inline-flex w-full items-center justify-center gap-2 rounded-full bg-brand-red-500 px-5 py-3 text-sm font-semibold text-white shadow-pill hover:bg-brand-red-600">
                        View Full Report
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                            <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
                        </svg>
                    </a>

                    <div class="mt-7 flex flex-wrap gap-2">
                        @foreach ($divisionInfo as $key => $d)
                            <button type="button"
                                @click="active = '{{ $key }}'"
                                :class="active === '{{ $key }}' ? 'bg-brand-red-500 text-white' : 'bg-brand-cream text-brand-muted hover:bg-brand-red-100 hover:text-brand-red-500'"
                                class="rounded-full px-3 py-1 text-xs font-semibold transition">
                                {{ $d['name'] }}
                            </button>
                        @endforeach
                    </div>
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

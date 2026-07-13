{{-- Section 8: Bangladesh Map — divisions + active-district coverage --}}
@php
    // forHomepage() is cached forever; any Division/District save (including
    // the bulk district-toggle endpoint) busts the cache.
    [
        'divisionInfo'      => $divisionInfo,
        'districts'         => $districts,
        'divisions_covered' => $mapDivisionsCovered,
        'districts_covered' => $mapDistrictsCovered,
    ] = \App\Models\Division::forHomepage();

    $mapStats = [
        ['label' => 'Divisions covered',  'value' => $mapDivisionsCovered,               'suffix' => '',  'tone' => 'red',    'icon' => 'M9 4 3 7v13l6-3 6 3 6-3V4l-6 3-6-3Zm0 0v13M15 7v13'],
        ['label' => 'Districts covered',  'value' => $mapDistrictsCovered,               'suffix' => '',  'tone' => 'green',  'icon' => 'M12 2a7 7 0 0 0-7 7c0 5.5 7 13 7 13s7-7.5 7-13a7 7 0 0 0-7-7Zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z'],
        ['label' => 'Upazilas covered',   'value' => (int) setting('map.upazila_count',    0), 'suffix' => '',  'tone' => 'orange', 'icon' => 'M4 4h16v16H4zM4 10h16M10 4v16'],
        ['label' => 'Unions covered',     'value' => (int) setting('map.union_count',      0), 'suffix' => '+', 'tone' => 'red',    'icon' => 'M9 12a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm6 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3 21a6 6 0 0 1 12 0M9 21a6 6 0 0 1 12 0'],
        ['label' => 'Population reached', 'value' => (int) setting('map.population_count', 0), 'suffix' => '+', 'tone' => 'green',  'icon' => 'M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-8 9a8 8 0 1 1 16 0H4Z'],
    ];

    $toneClasses = [
        'red'    => ['bg' => 'bg-brand-red-100',    'text' => 'text-brand-red-500'],
        'green'  => ['bg' => 'bg-brand-green-100',  'text' => 'text-brand-green-600'],
        'orange' => ['bg' => 'bg-brand-orange-100', 'text' => 'text-brand-orange-500'],
    ];
@endphp

<section id="map" class="bg-blueprint py-24"
         x-data="{
            active: 'dhaka',
            divisions: @js($divisionInfo),
            current() { return this.divisions[this.active]; },
            zoom: 1, panX: 0, panY: 0,
            dragging: false, lastX: 0, lastY: 0,
            isFullscreen: false,
            zoomIn()    { this.zoom = Math.min(+(this.zoom + 0.4).toFixed(2), 3); },
            zoomOut()   { this.zoom = Math.max(+(this.zoom - 0.4).toFixed(2), 1); if (this.zoom === 1) { this.panX = 0; this.panY = 0; } },
            zoomReset() { this.zoom = 1; this.panX = 0; this.panY = 0; },
            toggleFullscreen() {
                this.isFullscreen = ! this.isFullscreen;
                document.body.style.overflow = this.isFullscreen ? 'hidden' : '';
                this.zoomReset();
            },
            wheelZoom(e) {
                // Only intercept the wheel when the user is clearly trying to
                // zoom (Ctrl/Cmd+wheel, i.e. trackpad pinch). Otherwise let
                // normal page scrolling pass through.
                if (! e.ctrlKey && ! e.metaKey) return;
                e.preventDefault();
                const dir = e.deltaY > 0 ? -0.2 : 0.2;
                this.zoom = Math.min(Math.max(+(this.zoom + dir).toFixed(2), 1), 3);
                if (this.zoom === 1) { this.panX = 0; this.panY = 0; }
            },
            startDrag(e) {
                if (this.zoom <= 1) return;
                this.dragging = true; this.lastX = e.clientX; this.lastY = e.clientY;
            },
            drag(e) {
                if (! this.dragging) return;
                this.panX += (e.clientX - this.lastX) / this.zoom;
                this.panY += (e.clientY - this.lastY) / this.zoom;
                this.lastX = e.clientX; this.lastY = e.clientY;
            },
            endDrag() { this.dragging = false; }
         }"
         @keydown.escape.window="if (isFullscreen) toggleFullscreen()"
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

            {{-- Map (3 of 5 cols). When isFullscreen, the card becomes a
                 viewport-filling overlay; otherwise it lives in the grid. --}}
            <div class="lg:col-span-3">
                <div :class="isFullscreen
                        ? 'fixed inset-0 z-[60] flex flex-col rounded-none bg-white p-4 sm:p-6'
                        : 'relative rounded-[2rem] bg-white p-4 sm:p-6 shadow-card ring-1 ring-black/5'"
                     class="transition-all">

                    {{-- Zoom controls (top-right of map card) --}}
                    <div class="absolute right-7 top-7 z-20 flex flex-col gap-1 rounded-2xl bg-white/95 p-1 shadow-card ring-1 ring-black/5 backdrop-blur">
                        <button type="button" @click="zoomIn()" aria-label="Zoom in"
                                :disabled="zoom >= 3"
                                class="grid h-9 w-9 place-items-center rounded-xl text-slate-700 transition hover:bg-brand-red-50 hover:text-brand-red-500 disabled:cursor-not-allowed disabled:opacity-30">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M10 4a1 1 0 0 1 1 1v4h4a1 1 0 1 1 0 2h-4v4a1 1 0 1 1-2 0v-4H5a1 1 0 1 1 0-2h4V5a1 1 0 0 1 1-1Z"/></svg>
                        </button>
                        <div class="grid h-7 place-items-center text-[10px] font-bold tabular-nums text-slate-500" x-text="Math.round(zoom * 100) + '%'"></div>
                        <button type="button" @click="zoomOut()" aria-label="Zoom out"
                                :disabled="zoom <= 1"
                                class="grid h-9 w-9 place-items-center rounded-xl text-slate-700 transition hover:bg-brand-red-50 hover:text-brand-red-500 disabled:cursor-not-allowed disabled:opacity-30">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M5 9a1 1 0 1 0 0 2h10a1 1 0 1 0 0-2H5Z"/></svg>
                        </button>
                        <button type="button" @click="zoomReset()" aria-label="Reset zoom"
                                class="grid h-9 w-9 place-items-center rounded-xl text-slate-700 transition hover:bg-brand-red-50 hover:text-brand-red-500">
                            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                <path d="M4 4h4M4 4v4M16 4h-4M16 4v4M4 16h4M4 16v-4M16 16h-4M16 16v-4"/>
                            </svg>
                        </button>
                        <button type="button" @click="toggleFullscreen()" :aria-label="isFullscreen ? 'Exit fullscreen' : 'View fullscreen'"
                                class="grid h-9 w-9 place-items-center rounded-xl text-slate-700 transition hover:bg-brand-red-50 hover:text-brand-red-500">
                            <svg x-show="!isFullscreen" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                <path d="M3 7V3h4M17 7V3h-4M3 13v4h4M17 13v4h-4"/>
                            </svg>
                            <svg x-show="isFullscreen" x-cloak viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                <path d="M7 3v4H3M13 3v4h4M7 17v-4H3M13 17v-4h4"/>
                            </svg>
                        </button>
                    </div>

                    <div :class="isFullscreen ? 'bd-map bd-map-fs relative flex-1 overflow-hidden rounded-2xl' : 'bd-map relative overflow-hidden rounded-2xl'"
                         x-ref="map"
                         @mousedown="startDrag($event)"
                         @mousemove.window="drag($event)"
                         @mouseup.window="endDrag()"
                         @wheel="wheelZoom($event)"
                         :style="dragging ? 'cursor: grabbing' : (zoom > 1 ? 'cursor: grab' : '')">
                        <div class="bd-map-inner"
                             :style="`transform: scale(${zoom}) translate(${panX}px, ${panY}px); transition: ${dragging ? 'none' : 'transform 0.25s cubic-bezier(0.16, 1, 0.3, 1)'};`">
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
                                        <text x="{{ $d['x'] + 28 }}" y="{{ $d['y'] + 14 }}"
                                              class="district-label-halo">{{ $d['name'] }}</text>
                                        <text x="{{ $d['x'] + 28 }}" y="{{ $d['y'] + 14 }}"
                                              class="district-label">{{ $d['name'] }}</text>
                                        <title>{{ $d['name'] }} — Active programme</title>
                                    </g>
                                @endforeach
                            </svg>
                        </div>
                    </div>

                    <p class="mt-3 text-center text-[11px] text-brand-muted">
                        <span x-show="zoom <= 1">Hover or tap a division</span>
                        <span x-show="zoom > 1" x-cloak>Drag to pan · scroll/+/− to zoom</span>
                    </p>

                    {{-- Legend --}}
                    <div class="mt-4 flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-xs text-brand-muted">
                        <div class="flex items-center gap-2">
                            <span class="grid h-4 w-4 place-items-center rounded-full bg-brand-red-500 ring-2 ring-white"></span>
                            Active programme district
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar (2 of 5 cols): five coverage stats, revealed one by one --}}
            <div class="lg:col-span-2">
                <div class="rounded-[2rem] bg-white p-8 shadow-card ring-1 ring-black/5">
                    <div class="text-xs font-semibold uppercase tracking-[0.18em] text-brand-green-600">Our reach</div>
                    <h3 class="mt-2 font-display text-2xl font-bold text-brand-ink">Coverage at a glance</h3>
                    <p class="mt-2 text-sm text-brand-muted">
                        A snapshot of where our programmes are active across Bangladesh.
                    </p>

                    <ul class="mt-6 space-y-3">
                        @foreach ($mapStats as $i => $stat)
                            @php
                                $tone       = $toneClasses[$stat['tone']] ?? $toneClasses['red'];
                                $delayClass = 'reveal-delay-'.min(500, ($i + 1) * 100);
                            @endphp
                            <li class="reveal {{ $delayClass }} flex items-center gap-4 rounded-2xl border border-slate-100 bg-white/60 p-4 transition hover:border-slate-200 hover:bg-white hover:shadow-sm">
                                <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full {{ $tone['bg'] }} {{ $tone['text'] }}">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                        <path d="{{ $stat['icon'] }}"/>
                                    </svg>
                                </span>
                                <div class="min-w-0 flex-1">
                                    <div class="font-display text-2xl font-bold {{ $tone['text'] }}"
                                         data-counter="{{ $stat['value'] }}"
                                         data-counter-suffix="{{ $stat['suffix'] }}">0{{ $stat['suffix'] }}</div>
                                    <div class="text-xs uppercase tracking-wider text-brand-muted">{{ $stat['label'] }}</div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .bd-map { transform-origin: center; }
    .bd-map-inner { position: relative; transform-origin: center; will-change: transform; height: 100%; }
    .bd-map-inner svg { width: 100%; height: auto; max-height: 640px; display: block; }
    .bd-map-inner .district-overlay { position: absolute; inset: 0; pointer-events: none; z-index: 2; }

    /* Fullscreen variant: let the SVG fill available height. */
    .bd-map-fs { display: flex; align-items: center; justify-content: center; }
    .bd-map-fs .bd-map-inner { display: flex; align-items: center; justify-content: center; height: 100%; }
    .bd-map-fs .bd-map-inner svg { max-height: none; height: 100%; width: auto; max-width: 100%; }

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

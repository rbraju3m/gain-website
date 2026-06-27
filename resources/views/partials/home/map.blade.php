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
            current() { return this.divisions[this.active]; },
            zoom: 1, panX: 0, panY: 0,
            dragging: false, lastX: 0, lastY: 0,
            zoomIn()    { this.zoom = Math.min(+(this.zoom + 0.4).toFixed(2), 3); },
            zoomOut()   { this.zoom = Math.max(+(this.zoom - 0.4).toFixed(2), 1); if (this.zoom === 1) { this.panX = 0; this.panY = 0; } },
            zoomReset() { this.zoom = 1; this.panX = 0; this.panY = 0; },
            wheelZoom(e) {
                if (! e.ctrlKey && Math.abs(e.deltaY) < 30) return;
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
                        <button type="button" @click="zoomReset()" aria-label="Reset view"
                                class="grid h-9 w-9 place-items-center rounded-xl text-slate-700 transition hover:bg-brand-red-50 hover:text-brand-red-500">
                            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                <path d="M4 4h4M4 4v4M16 4h-4M16 4v4M4 16h4M4 16v-4M16 16h-4M16 16v-4"/>
                            </svg>
                        </button>
                    </div>

                    <div class="bd-map relative overflow-hidden rounded-2xl"
                         x-ref="map"
                         @mousedown="startDrag($event)"
                         @mousemove.window="drag($event)"
                         @mouseup.window="endDrag()"
                         @wheel.passive="wheelZoom($event)"
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
    .bd-map { transform-origin: center; }
    .bd-map-inner { position: relative; transform-origin: center; will-change: transform; }
    .bd-map-inner svg { width: 100%; height: auto; max-height: 640px; display: block; }
    .bd-map-inner .district-overlay { position: absolute; inset: 0; pointer-events: none; z-index: 2; }

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

@php
    // Two pinned external programmes at the top of the Programmes dropdown.
    // Open in a new tab; replace the placeholder URLs when the real ones are known.
    $pinnedProgrammes = [
        ['label' => 'At a Glance', 'url' => 'https://example.com/at-a-glance'],
        ['label' => 'Swapno',      'url' => 'https://cqi.workforcenutritionbd.org/'],
    ];

    // Live Programmes dropdown — pulls from the same dataset that drives the
    // homepage card grid. Detail links use the public /programmes/{slug} route.
    $navProgrammes = \App\Models\Programme::published()->ordered()->get(['id', 'title', 'slug', 'category']);
    $navServices   = \App\Models\Service::published()->ordered()->get(['id', 'title', 'slug', 'category']);
@endphp

<header
    x-data="{ scrolled: false, mobileOpen: false }"
    x-init="scrolled = window.scrollY > 8;
            window.addEventListener('scroll', () => scrolled = window.scrollY > 8)"
    :class="scrolled ? 'bg-white/95 shadow-sm ring-1 ring-black/5 backdrop-blur' : 'bg-transparent'"
    class="sticky top-0 z-50 transition-all duration-200"
    @keydown.escape.window="mobileOpen = false"
>
    <nav class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-6 py-3 lg:px-10 lg:py-4">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="block shrink-0" aria-label="{{ config('app.name') }} home">
            <img src="{{ asset('images/logo-gain.svg') }}" alt="GAIN" class="h-10 w-auto lg:h-11">
        </a>

        {{-- Desktop menu --}}
        <ul class="hidden items-center gap-1 text-sm font-medium text-brand-ink lg:flex">
            @php
                $links = [
                    ['label' => 'About',    'href' => url('/#about')],
                ];
                $afterProgrammes = [
                    ['label' => 'Impact',   'href' => url('/#impact')],
                    ['label' => 'Stories',  'href' => url('/#stories')],
                    ['label' => 'Partners', 'href' => url('/#partners')],
                    ['label' => 'Gallery',  'href' => route('gallery.index')],
                    ['label' => 'News',     'href' => route('news.index')],
                    ['label' => 'Contact',  'href' => url('/#contact')],
                ];
            @endphp

            @foreach ($links as $item)
                <li>
                    <a href="{{ $item['href'] }}" class="nav-link">{{ $item['label'] }}</a>
                </li>
            @endforeach

            {{-- Programmes dropdown — hover-friendly: button + panel share one mouseleave region --}}
            <li
                x-data="{ open: false }"
                @mouseenter="open = true"
                @mouseleave="open = false"
                class="relative"
            >
                <button
                    type="button"
                    @click="open = !open"
                    @focus="open = true"
                    class="nav-link flex items-center gap-1"
                    :aria-expanded="open"
                >
                    Programmes
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 transition" :class="open ? 'rotate-180' : ''">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.06l3.71-3.83a.75.75 0 1 1 1.08 1.04l-4.25 4.39a.75.75 0 0 1-1.08 0L5.21 8.27a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd"/>
                    </svg>
                </button>

                {{-- Panel sits flush against the button (top-full + pt-3 inside) so hover never crosses an empty gap. --}}
                <div
                    x-show="open"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    x-cloak
                    class="absolute left-1/2 top-full w-80 -translate-x-1/2 pt-3"
                >
                    <div class="overflow-hidden rounded-2xl bg-white shadow-card ring-1 ring-black/5">

                        {{-- Pinned external entries (At a Glance, Swapno) --}}
                        <div class="px-4 pb-1 pt-4 text-[10px] font-semibold uppercase tracking-[0.18em] text-brand-red-500">At a Glance</div>
                        <div class="px-2 pt-2">
                            @foreach ($pinnedProgrammes as $pin)
                                <a href="{{ $pin['url'] }}" target="_blank" rel="noopener noreferrer"
                                   class="group/pin flex items-center justify-between rounded-xl px-3 py-2 text-sm font-medium text-brand-ink transition hover:bg-brand-red-50 hover:text-brand-red-500">
                                    {{ $pin['label'] }}
                                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5 opacity-50 group-hover/pin:opacity-100">
                                        <path d="M11 3a1 1 0 1 0 0 2h2.586l-6.293 6.293a1 1 0 1 0 1.414 1.414L15 6.414V9a1 1 0 1 0 2 0V4a1 1 0 0 0-1-1h-5Z"/>
                                        <path d="M5 5a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-3a1 1 0 1 0-2 0v3H5V7h3a1 1 0 0 0 0-2H5Z"/>
                                    </svg>
                                </a>
                            @endforeach
                        </div>

                        <div class="mx-4 my-2 border-t border-brand-red-100"></div>

                        <div class="px-4 pb-1 pt-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-brand-red-500">Our Programmes</div>

                        <div class="px-2 py-2">
                            @forelse ($navProgrammes as $p)
                                <a
                                    href="{{ route('programmes.show', $p) }}"
                                    class="group/dd flex items-start gap-3 rounded-xl px-3 py-2.5 text-sm text-brand-ink transition hover:bg-brand-red-50"
                                >
                                    <span class="mt-0.5 grid h-7 w-7 shrink-0 place-items-center rounded-full bg-brand-red-100 text-brand-red-500 transition group-hover/dd:bg-brand-red-500 group-hover/dd:text-white">
                                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.7-9.3a1 1 0 0 0-1.4-1.4l-3.3 3.3-1.3-1.3a1 1 0 0 0-1.4 1.4l2 2c.4.4 1 .4 1.4 0l4-4Z" clip-rule="evenodd"/>
                                        </svg>
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block font-semibold leading-tight text-brand-ink group-hover/dd:text-brand-red-500">{{ $p->title }}</span>
                                        @if ($p->category)
                                            <span class="mt-0.5 block text-xs text-brand-muted">{{ $p->category }}</span>
                                        @endif
                                    </span>
                                </a>
                            @empty
                                <div class="px-3 py-4 text-sm text-brand-muted">No programmes published yet.</div>
                            @endforelse
                        </div>

                        <a href="{{ route('programmes.index') }}"
                           class="flex items-center justify-between border-t border-brand-cream bg-brand-cream/50 px-4 py-3 text-xs font-semibold uppercase tracking-wider text-brand-red-500 transition hover:bg-brand-cream">
                            See all programmes
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </li>

            {{-- Services dropdown --}}
            <li
                x-data="{ open: false }"
                @mouseenter="open = true"
                @mouseleave="open = false"
                class="relative"
            >
                <button
                    type="button"
                    @click="open = !open"
                    @focus="open = true"
                    class="nav-link flex items-center gap-1"
                    :aria-expanded="open"
                >
                    Services
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 transition" :class="open ? 'rotate-180' : ''">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.06l3.71-3.83a.75.75 0 1 1 1.08 1.04l-4.25 4.39a.75.75 0 0 1-1.08 0L5.21 8.27a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd"/>
                    </svg>
                </button>

                <div
                    x-show="open"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    x-cloak
                    class="absolute left-1/2 top-full w-80 -translate-x-1/2 pt-3"
                >
                    <div class="overflow-hidden rounded-2xl bg-white shadow-card ring-1 ring-black/5">

                        <div class="px-4 pb-1 pt-4 text-[10px] font-semibold uppercase tracking-[0.18em] text-brand-red-500">Our Services</div>

                        <div class="px-2 py-2">
                            @forelse ($navServices as $s)
                                <a
                                    href="{{ route('services.show', $s) }}"
                                    class="group/dd flex items-start gap-3 rounded-xl px-3 py-2.5 text-sm text-brand-ink transition hover:bg-brand-red-50"
                                >
                                    <span class="mt-0.5 grid h-7 w-7 shrink-0 place-items-center rounded-full bg-brand-red-100 text-brand-red-500 transition group-hover/dd:bg-brand-red-500 group-hover/dd:text-white">
                                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                                            <path d="M4 4h12v3H4zM4 9h8v7H4zM14 9h2v7h-2z"/>
                                        </svg>
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block font-semibold leading-tight text-brand-ink group-hover/dd:text-brand-red-500">{{ $s->title }}</span>
                                        @if ($s->category)
                                            <span class="mt-0.5 block text-xs text-brand-muted">{{ $s->category }}</span>
                                        @endif
                                    </span>
                                </a>
                            @empty
                                <div class="px-3 py-4 text-sm text-brand-muted">No services published yet.</div>
                            @endforelse
                        </div>

                        <a href="{{ route('services.index') }}"
                           class="flex items-center justify-between border-t border-brand-cream bg-brand-cream/50 px-4 py-3 text-xs font-semibold uppercase tracking-wider text-brand-red-500 transition hover:bg-brand-cream">
                            See all services
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </li>

            @foreach ($afterProgrammes as $item)
                <li>
                    <a href="{{ $item['href'] }}" class="nav-link">{{ $item['label'] }}</a>
                </li>
            @endforeach
        </ul>

        {{-- Right cluster: CTA (desktop) + mobile toggle --}}
        <div class="flex items-center gap-3">
            <a href="https://cqi.workforcenutritionbd.org/" target="_blank" rel="noopener noreferrer"
               class="btn-shimmer hidden items-center gap-2 rounded-full bg-brand-red-500 px-5 py-2.5 text-sm font-semibold text-white shadow-pill transition hover:bg-brand-red-600 lg:inline-flex">
                <span class="inline-flex items-center gap-2">
                    Get Involved
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                        <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
                    </svg>
                </span>
            </a>

            <button
                @click="mobileOpen = !mobileOpen"
                class="rounded-md p-2 text-brand-ink hover:bg-brand-red-50 lg:hidden"
                :aria-expanded="mobileOpen"
                aria-label="Open menu"
            >
                <svg x-show="!mobileOpen" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                    <path fill-rule="evenodd" d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm.75 4.5a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5H3.75Z" clip-rule="evenodd"/>
                </svg>
                <svg x-show="mobileOpen" x-cloak viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                    <path fill-rule="evenodd" d="M6.3 5.3a1 1 0 0 1 1.4 0L12 9.6l4.3-4.3a1 1 0 1 1 1.4 1.4L13.4 11l4.3 4.3a1 1 0 0 1-1.4 1.4L12 12.4l-4.3 4.3a1 1 0 0 1-1.4-1.4L10.6 11 6.3 6.7a1 1 0 0 1 0-1.4Z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
    </nav>

    {{-- Mobile menu panel --}}
    <div
        x-show="mobileOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        x-cloak
        @click.outside="mobileOpen = false"
        class="border-t border-brand-cream bg-white shadow-card lg:hidden"
    >
        <div class="mx-auto max-w-7xl px-6 py-4">
            <ul class="space-y-1 text-sm font-medium text-brand-ink">
                <li><a href="{{ url('/#about') }}"    @click="mobileOpen = false" class="block rounded-lg px-3 py-2.5 hover:bg-brand-red-50 hover:text-brand-red-500">About</a></li>
                <li>
                    <details class="group">
                        <summary class="flex cursor-pointer items-center justify-between rounded-lg px-3 py-2.5 hover:bg-brand-red-50 hover:text-brand-red-500">
                            Programmes
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 transition group-open:rotate-180">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.06l3.71-3.83a.75.75 0 1 1 1.08 1.04l-4.25 4.39a.75.75 0 0 1-1.08 0L5.21 8.27a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd"/>
                            </svg>
                        </summary>
                        <div class="ml-3 mt-1 space-y-0.5 border-l border-brand-cream pl-3">
                            @foreach ($pinnedProgrammes as $pin)
                                <a href="{{ $pin['url'] }}" target="_blank" rel="noopener noreferrer"
                                   @click="mobileOpen = false"
                                   class="flex items-center justify-between rounded-lg px-3 py-2 text-sm font-medium text-brand-ink/85 hover:bg-brand-red-50 hover:text-brand-red-500">
                                    {{ $pin['label'] }}
                                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5 opacity-50">
                                        <path d="M11 3a1 1 0 1 0 0 2h2.586l-6.293 6.293a1 1 0 1 0 1.414 1.414L15 6.414V9a1 1 0 1 0 2 0V4a1 1 0 0 0-1-1h-5Z"/>
                                        <path d="M5 5a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-3a1 1 0 1 0-2 0v3H5V7h3a1 1 0 0 0 0-2H5Z"/>
                                    </svg>
                                </a>
                            @endforeach
                            <div class="my-1 border-t border-brand-cream"></div>
                            @forelse ($navProgrammes as $p)
                                <a href="{{ route('programmes.show', $p) }}" @click="mobileOpen = false" class="block rounded-lg px-3 py-2 text-sm text-brand-ink/85 hover:bg-brand-red-50 hover:text-brand-red-500">
                                    {{ $p->title }}
                                </a>
                            @empty
                                <div class="px-3 py-2 text-sm text-brand-muted">No programmes yet.</div>
                            @endforelse
                            <a href="{{ route('programmes.index') }}" @click="mobileOpen = false" class="block rounded-lg px-3 py-2 text-sm font-semibold text-brand-red-500 hover:bg-brand-red-50">See all →</a>
                        </div>
                    </details>
                </li>
                <li>
                    <details class="group">
                        <summary class="flex cursor-pointer items-center justify-between rounded-lg px-3 py-2.5 hover:bg-brand-red-50 hover:text-brand-red-500">
                            Services
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 transition group-open:rotate-180">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.06l3.71-3.83a.75.75 0 1 1 1.08 1.04l-4.25 4.39a.75.75 0 0 1-1.08 0L5.21 8.27a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd"/>
                            </svg>
                        </summary>
                        <div class="ml-3 mt-1 space-y-0.5 border-l border-brand-cream pl-3">
                            @forelse ($navServices as $s)
                                <a href="{{ route('services.show', $s) }}" @click="mobileOpen = false" class="block rounded-lg px-3 py-2 text-sm text-brand-ink/85 hover:bg-brand-red-50 hover:text-brand-red-500">
                                    {{ $s->title }}
                                </a>
                            @empty
                                <div class="px-3 py-2 text-sm text-brand-muted">No services yet.</div>
                            @endforelse
                            <a href="{{ route('services.index') }}" @click="mobileOpen = false" class="block rounded-lg px-3 py-2 text-sm font-semibold text-brand-red-500 hover:bg-brand-red-50">See all →</a>
                        </div>
                    </details>
                </li>
                <li><a href="{{ url('/#impact') }}"    @click="mobileOpen = false" class="block rounded-lg px-3 py-2.5 hover:bg-brand-red-50 hover:text-brand-red-500">Impact</a></li>
                <li><a href="{{ url('/#stories') }}"   @click="mobileOpen = false" class="block rounded-lg px-3 py-2.5 hover:bg-brand-red-50 hover:text-brand-red-500">Stories</a></li>
                <li><a href="{{ url('/#partners') }}"  @click="mobileOpen = false" class="block rounded-lg px-3 py-2.5 hover:bg-brand-red-50 hover:text-brand-red-500">Partners</a></li>
                <li><a href="{{ route('gallery.index') }}" @click="mobileOpen = false" class="block rounded-lg px-3 py-2.5 hover:bg-brand-red-50 hover:text-brand-red-500">Gallery</a></li>
                <li><a href="{{ route('news.index') }}" @click="mobileOpen = false" class="block rounded-lg px-3 py-2.5 hover:bg-brand-red-50 hover:text-brand-red-500">News</a></li>
                <li><a href="{{ url('/#contact') }}"   @click="mobileOpen = false" class="block rounded-lg px-3 py-2.5 hover:bg-brand-red-50 hover:text-brand-red-500">Contact</a></li>
            </ul>

            <a href="https://cqi.workforcenutritionbd.org/" target="_blank" rel="noopener noreferrer" @click="mobileOpen = false"
               class="btn-shimmer mt-4 inline-flex w-full items-center justify-center gap-2 rounded-full bg-brand-red-500 px-5 py-3 text-sm font-semibold text-white shadow-pill hover:bg-brand-red-600">
                <span class="inline-flex items-center gap-2">
                    Get Involved
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                        <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
                </svg>
                </span>
            </a>
        </div>
    </div>
</header>

<style>[x-cloak]{display:none!important}</style>

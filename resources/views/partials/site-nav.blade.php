@php
    // Programmes dropdown. The first two items have fixed external URLs and open
    // in a new tab. Replace the href values when the real URLs are known.
    $featuredProgrammes = [
        ['label' => 'At a Glance', 'url' => 'https://example.com/at-a-glance'],
        ['label' => 'Swapno',      'url' => 'https://example.com/swapno'],
    ];
    $otherProgrammes = [
        ['label' => 'Nutrition Support',     'url' => '#'],
        ['label' => 'Agricultural Training', 'url' => '#'],
        ['label' => 'Community Outreach',    'url' => '#'],
    ];
@endphp

<header
    x-data="{ scrolled: false }"
    x-init="scrolled = window.scrollY > 8;
            window.addEventListener('scroll', () => scrolled = window.scrollY > 8)"
    :class="scrolled ? 'bg-white/95 backdrop-blur shadow-sm' : 'bg-transparent'"
    class="sticky top-0 z-50 transition-colors duration-200"
>
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-10">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="block" aria-label="{{ config('app.name') }} home">
            <img src="{{ asset('images/logo-gain.svg') }}" alt="GAIN" class="h-10 w-auto">
        </a>

        {{-- Desktop menu --}}
        <ul class="hidden items-center gap-8 text-sm font-medium text-brand-ink lg:flex">
            <li><a href="#about" class="hover:text-brand-red-500">About</a></li>

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
                    class="flex items-center gap-1 py-2 hover:text-brand-red-500"
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
                    x-transition.opacity
                    x-cloak
                    class="absolute left-1/2 top-full w-64 -translate-x-1/2 pt-3"
                >
                    <div class="rounded-2xl bg-white p-3 shadow-card ring-1 ring-black/5">
                        <div class="mb-2 px-2 pt-1 text-[10px] font-semibold uppercase tracking-wider text-brand-red-500">At a Glance</div>
                        @foreach ($featuredProgrammes as $item)
                            <a
                                href="{{ $item['url'] }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center justify-between rounded-xl px-3 py-2 text-sm font-medium text-brand-ink hover:bg-brand-red-50 hover:text-brand-red-500"
                            >
                                {{ $item['label'] }}
                                <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5 opacity-60">
                                    <path d="M11 3a1 1 0 1 0 0 2h2.586l-6.293 6.293a1 1 0 1 0 1.414 1.414L15 6.414V9a1 1 0 1 0 2 0V4a1 1 0 0 0-1-1h-5Z"/>
                                    <path d="M5 5a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-3a1 1 0 1 0-2 0v3H5V7h3a1 1 0 0 0 0-2H5Z"/>
                                </svg>
                            </a>
                        @endforeach

                        <div class="my-2 border-t border-brand-red-100"></div>

                        @foreach ($otherProgrammes as $item)
                            <a
                                href="{{ $item['url'] }}"
                                class="block rounded-xl px-3 py-2 text-sm text-brand-ink/80 hover:bg-brand-red-50 hover:text-brand-red-500"
                            >
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </li>

            <li><a href="#impact"   class="hover:text-brand-red-500">Impact</a></li>
            <li><a href="#stories"  class="hover:text-brand-red-500">Stories</a></li>
            <li><a href="#partners" class="hover:text-brand-red-500">Partners</a></li>
            <li><a href="#contact"  class="hover:text-brand-red-500">Contact</a></li>
        </ul>

        {{-- Mobile toggle --}}
        <button
            @click="$dispatch('toggle-mobile-nav')"
            class="lg:hidden rounded-md p-2 text-brand-ink"
            aria-label="Open menu"
        >
            <svg viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                <path fill-rule="evenodd" d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm.75 4.5a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5H3.75Z" clip-rule="evenodd"/>
            </svg>
        </button>
    </nav>
</header>

<style>[x-cloak]{display:none!important}</style>

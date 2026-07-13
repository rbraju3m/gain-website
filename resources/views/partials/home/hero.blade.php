{{-- Section 1: Hero (carousel-driven; admin manages slides at /admin/hero-slides) --}}
@php
    // Site-setting defaults. Each admin slide field falls back to the matching
    // default when left blank so we never render an empty span.
    $heroDefaults = [
        'image_url'           => setting('hero.image_path') ? asset('storage/' . setting('hero.image_path')) : asset('images/hero-cooking.jpg'),
        'image_alt'           => setting('hero.line1', 'Hero'),
        'badge'               => setting('hero.badge', 'Transforming Lives Through Nutrition'),
        'line1'               => setting('hero.line1', 'Nourishing'),
        'line2_prefix'        => setting('hero.line2_prefix', ''),
        'line2_accent'        => setting('hero.line2_accent', 'Communities'),
        'line2_suffix'        => setting('hero.line2_suffix', ','),
        'line3_prefix'        => setting('hero.line3_prefix', 'Building'),
        'line3_accent'        => setting('hero.line3_accent', 'Futures'),
        'subhead'             => setting('hero.subhead', ''),
        'cta_primary_label'   => setting('hero.cta_primary_label', 'Join Our Mission'),
        'cta_primary_url'     => setting('hero.cta_primary_url', '#mission'),
        'cta_secondary_label' => setting('hero.cta_secondary_label', 'Learn More'),
        'cta_secondary_url'   => setting('hero.cta_secondary_url', '#learn-more'),
    ];

    $heroSlides = \App\Models\HeroSlide::forHomepage();

    $heroSlidesData = $heroSlides->isEmpty()
        ? [$heroDefaults]
        : $heroSlides->map(fn ($s) => array_merge($heroDefaults, array_filter([
            'image_url'           => $s->imageUrl(),
            'image_alt'           => $s->image_alt,
            'badge'               => $s->badge,
            'line1'               => $s->line1,
            'line2_prefix'        => $s->line2_prefix,
            'line2_accent'        => $s->line2_accent,
            'line2_suffix'        => $s->line2_suffix,
            'line3_prefix'        => $s->line3_prefix,
            'line3_accent'        => $s->line3_accent,
            'subhead'             => $s->subhead,
            'cta_primary_label'   => $s->cta_primary_label,
            'cta_primary_url'     => $s->cta_primary_url,
            'cta_secondary_label' => $s->cta_secondary_label,
            'cta_secondary_url'   => $s->cta_secondary_url,
        ], fn ($v) => $v !== null && $v !== '')))->values()->all();

    $heroFirst = $heroSlidesData[0];
@endphp

<section class="relative -mt-[72px] overflow-hidden bg-hero-wash"
         x-data="{
            slides: {{ Illuminate\Support\Js::from($heroSlidesData) }},
            active: 0,
            timer: null,
            paused: false,
            get slide() { return this.slides[this.active]; },
            start() {
                if (this.slides.length < 2) return;
                this.stop();
                this.timer = setInterval(() => { if (! this.paused) this.next(); }, 6500);
            },
            stop() { if (this.timer) { clearInterval(this.timer); this.timer = null; } },
            go(i) {
                const n = this.slides.length;
                this.active = ((i % n) + n) % n;
            },
            next() { this.go(this.active + 1); },
            prev() { this.go(this.active - 1); },
         }"
         x-init="start()"
         @mouseenter="paused = true" @mouseleave="paused = false">
    <div class="blob-drift-a pointer-events-none absolute -top-32 -left-32 h-[480px] w-[480px] rounded-full bg-brand-red-100/60 blur-3xl"></div>
    <div class="blob-drift-b pointer-events-none absolute bottom-0 right-0 h-[420px] w-[420px] rounded-full bg-brand-green-100/70 blur-3xl"></div>

    <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-6 pb-24 pt-32 lg:grid-cols-2 lg:gap-16 lg:px-10 lg:pt-40">

        <div>
            <span class="reveal inline-flex items-center gap-2 rounded-full border border-brand-red-200 bg-white/80 px-4 py-1.5 text-xs font-medium text-brand-red-500">
                <span class="h-1.5 w-1.5 rounded-full bg-brand-red-500"></span>
                <span x-text="slide.badge">{{ $heroFirst['badge'] }}</span>
            </span>

            <h1 class="reveal reveal-delay-100 mt-6 font-display text-5xl font-semibold leading-[1.05] tracking-tight text-brand-ink sm:text-6xl lg:text-7xl">
                <span x-text="slide.line1">{{ $heroFirst['line1'] }}</span><br>
                <span x-text="slide.line2_prefix">{{ $heroFirst['line2_prefix'] }}</span><span class="draw-underline-green text-brand-green-500" x-text="slide.line2_accent">{{ $heroFirst['line2_accent'] }}</span><span x-text="slide.line2_suffix">{{ $heroFirst['line2_suffix'] }}</span><br>
                <span x-text="slide.line3_prefix">{{ $heroFirst['line3_prefix'] }}</span> <span class="draw-underline-red text-brand-red-500" x-text="slide.line3_accent">{{ $heroFirst['line3_accent'] }}</span>
            </h1>

            <p class="reveal reveal-delay-200 mt-6 max-w-xl text-base leading-relaxed text-brand-muted sm:text-lg"
               x-text="slide.subhead">{{ $heroFirst['subhead'] }}</p>

            <div class="reveal reveal-delay-300 mt-8 flex flex-wrap items-center gap-3">
                <a :href="slide.cta_primary_url" href="{{ $heroFirst['cta_primary_url'] }}"
                   class="btn-shimmer inline-flex items-center gap-2 rounded-full bg-brand-red-500 px-6 py-3 text-sm font-semibold text-white shadow-pill transition hover:bg-brand-red-600">
                    <span class="inline-flex items-center gap-2">
                        <span x-text="slide.cta_primary_label">{{ $heroFirst['cta_primary_label'] }}</span>
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                            <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                </a>
                <a :href="slide.cta_secondary_url" href="{{ $heroFirst['cta_secondary_url'] }}"
                   class="inline-flex items-center gap-2 rounded-full border border-brand-ink/15 bg-white px-6 py-3 text-sm font-semibold text-brand-ink transition hover:border-brand-ink/30 hover:bg-brand-red-50">
                    <span x-text="slide.cta_secondary_label">{{ $heroFirst['cta_secondary_label'] }}</span>
                </a>
            </div>

            {{--
            <dl class="mt-10 flex flex-wrap items-center gap-x-10 gap-y-4 text-sm text-brand-muted">
                @foreach ([
                    ['label' => 'Families',      'value' => '150+',  'icon' => 'M10 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-7 8a7 7 0 1 1 14 0H3Z'],
                    ['label' => 'Districts',     'value' => '30+',   'icon' => 'M10 2a6 6 0 0 0-6 6c0 4.5 6 10 6 10s6-5.5 6-10a6 6 0 0 0-6-6Zm0 8.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z'],
                    ['label' => 'Years Impact', 'value' => '10',    'icon' => 'M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .2.08.39.22.53l3 3a.75.75 0 1 0 1.06-1.06l-2.78-2.78V5Z'],
                ] as $stat)
                    <div class="flex items-center gap-2">
                        <span class="grid h-8 w-8 place-items-center rounded-full bg-brand-red-100 text-brand-red-500">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path fill-rule="evenodd" d="{{ $stat['icon'] }}" clip-rule="evenodd"/></svg>
                        </span>
                        <dd><span class="font-semibold text-brand-ink">{{ $stat['value'] }}</span> {{ $stat['label'] }}</dd>
                    </div>
                @endforeach
            </dl>
            --}}
        </div>

        <div class="reveal reveal-delay-200 group relative w-full hero-parallax" data-hero-parallax>
            {{-- Single aspect-ratio box. Images are absolutely stacked inside it.
                 We intentionally DO NOT use `.reveal-image` here — its `> *`
                 CSS rule forces children to `position: relative`, which would
                 collapse the absolutely-stacked slides into vertical flow. --}}
            <div class="relative aspect-[4/5] w-full overflow-hidden rounded-[2.5rem] shadow-card sm:aspect-[5/4] lg:aspect-[4/5]">
                <template x-for="(s, i) in slides" :key="i">
                    <img :src="s.image_url"
                         :alt="s.image_alt"
                         class="absolute inset-0 h-full w-full object-cover transition-opacity duration-[900ms] ease-out"
                         :class="i === active ? 'opacity-100 z-0' : 'opacity-0 z-0'"
                         onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?w=900&q=80'">
                </template>

                <div class="pointer-events-none absolute inset-x-0 bottom-0 z-10 h-1/3 bg-gradient-to-t from-black/35 via-black/10 to-transparent"></div>

                @if (count($heroSlidesData) > 1)
                    <button type="button" @click.stop="prev(); paused = true"
                            class="absolute left-3 top-1/2 z-20 grid h-10 w-10 -translate-y-1/2 place-items-center rounded-full bg-white/85 text-brand-ink shadow-md backdrop-blur transition hover:bg-white sm:left-4"
                            aria-label="Previous slide">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path fill-rule="evenodd" d="M12.7 4.3a1 1 0 0 1 0 1.4L8.4 10l4.3 4.3a1 1 0 1 1-1.4 1.4l-5-5a1 1 0 0 1 0-1.4l5-5a1 1 0 0 1 1.4 0Z" clip-rule="evenodd"/></svg>
                    </button>
                    <button type="button" @click.stop="next(); paused = true"
                            class="absolute right-3 top-1/2 z-20 grid h-10 w-10 -translate-y-1/2 place-items-center rounded-full bg-white/85 text-brand-ink shadow-md backdrop-blur transition hover:bg-white sm:right-4"
                            aria-label="Next slide">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path fill-rule="evenodd" d="M7.3 4.3a1 1 0 0 1 1.4 0l5 5a1 1 0 0 1 0 1.4l-5 5a1 1 0 1 1-1.4-1.4L11.6 10 7.3 5.7a1 1 0 0 1 0-1.4Z" clip-rule="evenodd"/></svg>
                    </button>

                    <div class="absolute inset-x-0 bottom-4 z-20 flex items-center justify-center gap-2">
                        <template x-for="(s, i) in slides" :key="'dot-'+i">
                            <button type="button" @click.stop="go(i); paused = true"
                                    :aria-label="'Go to slide ' + (i + 1)"
                                    class="h-2 rounded-full bg-white/70 shadow transition-all hover:bg-white"
                                    :class="i === active ? 'w-6 bg-white' : 'w-2'"></button>
                        </template>
                    </div>
                @endif
            </div>

            {{--
            <div class="absolute -bottom-6 left-6 flex items-center gap-3 rounded-2xl bg-white px-5 py-4 shadow-card ring-1 ring-black/5 sm:left-10">
                <span class="grid h-10 w-10 place-items-center rounded-full bg-brand-green-100 text-brand-green-600">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd" d="M16.7 5.3a1 1 0 0 1 0 1.4l-7.5 7.5a1 1 0 0 1-1.4 0L3.3 9.7a1 1 0 1 1 1.4-1.4l3.8 3.8 6.8-6.8a1 1 0 0 1 1.4 0Z" clip-rule="evenodd"/>
                    </svg>
                </span>
                <div>
                    <div class="text-lg font-bold leading-none text-brand-ink">{{ setting('hero.success_value', '98%') }}</div>
                    <div class="text-xs text-brand-muted">{{ setting('hero.success_label', 'Program Success Rate') }}</div>
                </div>
            </div>
            --}}
        </div>
    </div>

    {{-- Wave separator at bottom of hero --}}
    <svg viewBox="0 0 1440 80" class="block w-full text-brand-cream" preserveAspectRatio="none" aria-hidden="true">
        <path fill="currentColor" d="M0,32 C240,80 480,0 720,32 C960,64 1200,16 1440,48 L1440,80 L0,80 Z"/>
    </svg>
    {{-- Multi-color brand line --}}
    <div class="h-1 w-full bg-brand-line"></div>
</section>

{{-- Section 1: Hero --}}
<section class="relative -mt-[72px] overflow-hidden bg-hero-wash">
    <div class="pointer-events-none absolute -top-32 -left-32 h-[480px] w-[480px] rounded-full bg-brand-red-100/60 blur-3xl"></div>
    <div class="pointer-events-none absolute bottom-0 right-0 h-[420px] w-[420px] translate-x-1/3 translate-y-1/3 rounded-full bg-brand-green-100/70 blur-3xl"></div>

    <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-6 pb-24 pt-32 lg:grid-cols-2 lg:gap-16 lg:px-10 lg:pt-40">

        <div>
            <span class="reveal inline-flex items-center gap-2 rounded-full border border-brand-red-200 bg-white/80 px-4 py-1.5 text-xs font-medium text-brand-red-500">
                <span class="h-1.5 w-1.5 rounded-full bg-brand-red-500"></span>
                Transforming Lives Through Nutrition
            </span>

            <h1 class="reveal reveal-delay-100 mt-6 font-display text-5xl font-semibold leading-[1.05] tracking-tight text-brand-ink sm:text-6xl lg:text-7xl">
                Nourishing<br>
                <span class="text-brand-green-500">Communities</span>,<br>
                Building <span class="text-brand-red-500">Futures</span>
            </h1>

            <p class="reveal reveal-delay-200 mt-6 max-w-xl text-base leading-relaxed text-brand-muted sm:text-lg">
                Empowering communities across Bangladesh with sustainable nutrition
                programs, agricultural training, and community-driven solutions for
                lasting food security.
            </p>

            <div class="reveal reveal-delay-300 mt-8 flex flex-wrap items-center gap-3">
                <a href="#mission"
                   class="inline-flex items-center gap-2 rounded-full bg-brand-red-500 px-6 py-3 text-sm font-semibold text-white shadow-pill transition hover:bg-brand-red-600">
                    Join Our Mission
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                        <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
                    </svg>
                </a>
                <a href="#learn-more"
                   class="inline-flex items-center gap-2 rounded-full border border-brand-ink/15 bg-white px-6 py-3 text-sm font-semibold text-brand-ink transition hover:border-brand-ink/30 hover:bg-brand-red-50">
                    Learn More
                </a>
            </div>

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
        </div>

        <div class="reveal reveal-delay-200 group relative">
            <div class="img-zoom relative overflow-hidden rounded-[2.5rem] shadow-card">
                <img
                    src="{{ asset('images/hero-cooking.jpg') }}"
                    onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?w=900&q=80'"
                    alt="Community members sharing a meal"
                    class="aspect-[4/5] w-full object-cover sm:aspect-[5/4] lg:aspect-[4/5]"
                >
                {{-- bottom shading helps the floating "98%" card stand out --}}
                <div class="pointer-events-none absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-black/35 via-black/10 to-transparent"></div>
            </div>

            <div class="absolute -bottom-6 left-6 flex items-center gap-3 rounded-2xl bg-white px-5 py-4 shadow-card ring-1 ring-black/5 sm:left-10">
                <span class="grid h-10 w-10 place-items-center rounded-full bg-brand-green-100 text-brand-green-600">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd" d="M16.7 5.3a1 1 0 0 1 0 1.4l-7.5 7.5a1 1 0 0 1-1.4 0L3.3 9.7a1 1 0 1 1 1.4-1.4l3.8 3.8 6.8-6.8a1 1 0 0 1 1.4 0Z" clip-rule="evenodd"/>
                    </svg>
                </span>
                <div>
                    <div class="text-lg font-bold leading-none text-brand-ink">98%</div>
                    <div class="text-xs text-brand-muted">Program Success Rate</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Wave separator at bottom of hero --}}
    <svg viewBox="0 0 1440 80" class="block w-full text-brand-cream" preserveAspectRatio="none" aria-hidden="true">
        <path fill="currentColor" d="M0,32 C240,80 480,0 720,32 C960,64 1200,16 1440,48 L1440,80 L0,80 Z"/>
    </svg>
    {{-- Multi-color brand line --}}
    <div class="h-1 w-full bg-brand-line"></div>
</section>

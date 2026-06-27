{{-- Section 6: Our Programmes --}}
<section id="programmes" class="relative overflow-hidden bg-white py-24">
    {{-- Decorative gradient orbs --}}
    <div class="pointer-events-none absolute -top-32 left-1/4 h-[420px] w-[420px] rounded-full bg-brand-green-100/50 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-32 right-1/4 h-[420px] w-[420px] rounded-full bg-brand-red-100/50 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-10">

        <div class="text-center">
            <h2 class="reveal font-display text-4xl font-bold text-brand-ink sm:text-5xl">
                Our <span class="draw-underline-red text-brand-red-500">Programmes</span>
            </h2>
            <p class="reveal reveal-delay-100 mx-auto mt-4 max-w-2xl text-brand-muted">
                Comprehensive initiatives designed to create sustainable change in nutrition and food security.
            </p>
        </div>

        @php
            $programmes = \App\Models\Programme::forHomepage();
            // Photo fallbacks keyed by the seeded title — used until a media upload exists.
            $fallbacks = [
                'Community Nutrition Gardens'         => 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=900&q=80',
                'Maternal & Child Nutrition'          => 'https://images.unsplash.com/photo-1490818387583-1baba5e638af?w=900&q=80',
                'Farmer Training & Livelihood'        => 'https://images.unsplash.com/photo-1500076656116-558758c991c1?w=900&q=80',
                'Nutrition Education & Awareness'     => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=900&q=80',
            ];
            $delays = ['', 'reveal-delay-100', 'reveal-delay-200', 'reveal-delay-300'];
        @endphp

        <div class="mt-14 grid gap-8 md:grid-cols-2">
            @foreach ($programmes as $i => $card)
                @php
                    $imgSrc = $card->imageUrl() ?: ($fallbacks[$card->title] ?? null);
                @endphp
                <article class="card-hover reveal {{ $delays[$i % count($delays)] }} group overflow-hidden rounded-3xl bg-white shadow-card ring-1 ring-black/5 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-soft">
                    <div class="img-zoom relative">
                        @if ($imgSrc)
                            <img src="{{ $imgSrc }}" alt="{{ $card->title }}" class="aspect-[16/9] w-full object-cover">
                        @else
                            <div class="aspect-[16/9] w-full bg-gradient-to-br from-brand-red-100 to-brand-green-100"></div>
                        @endif
                        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-black/30 to-transparent"></div>
                        @if ($card->category)
                            <span class="absolute left-4 top-4 inline-flex items-center gap-1.5 rounded-full bg-brand-red-500 px-3 py-1 text-xs font-semibold text-white shadow-sm">
                                <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                                {{ $card->category }}
                            </span>
                        @endif
                    </div>
                    <div class="p-7">
                        <h3 class="font-display text-2xl font-bold text-brand-red-500">{{ $card->title }}</h3>
                        @if ($card->body)
                            <p class="mt-3 text-brand-muted">{{ $card->body }}</p>
                        @endif
                        <a href="{{ $card->url ?: '#' }}" class="group/btn mt-5 inline-flex items-center gap-1.5 rounded-full bg-brand-cream px-5 py-2 text-sm font-semibold text-brand-red-500 transition hover:bg-brand-red-100">
                            Learn More
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 transition-transform group-hover/btn:translate-x-1">
                                <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>

    {{-- Divider: white → burgundy (into Stories) --}}
    <svg viewBox="0 0 1440 90" class="relative block w-full text-[#9C2245]" preserveAspectRatio="none" aria-hidden="true">
        <path fill="currentColor" d="M0,30 C360,90 720,0 1080,40 C1260,60 1380,75 1440,55 L1440,90 L0,90 Z"/>
    </svg>
</section>

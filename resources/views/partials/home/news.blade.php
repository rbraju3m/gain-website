{{-- Section 9: Latest News & Events --}}
<section id="news" class="relative overflow-hidden bg-section-white py-24">
    <div class="relative mx-auto max-w-7xl px-6 lg:px-10">

        <div class="flex flex-wrap items-end justify-between gap-6">
            <div>
                <h2 class="reveal font-display text-4xl font-bold text-brand-ink sm:text-5xl">
                    Latest <span class="text-brand-red-500">News &amp; Events</span>
                </h2>
                <p class="reveal reveal-delay-100 mt-3 max-w-xl text-brand-muted">
                    Stay updated with our latest initiatives, success stories, and community impact.
                </p>
            </div>
            <a href="#" class="reveal reveal-delay-200 group inline-flex items-center gap-1.5 text-sm font-semibold text-brand-red-500 hover:text-brand-red-600">
                View All News
                <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 transition-transform group-hover:translate-x-1">
                    <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
                </svg>
            </a>
        </div>

        @php
            $articles = \App\Models\NewsArticle::forHomepage();
            // Photo fallbacks keyed by title for articles without a media upload yet.
            $fallbacks = [
                'New Community Garden Initiative Launches in Sylhet Division'  => 'https://images.unsplash.com/photo-1471193945509-9ad0617afabf?w=800&q=80',
                'Annual Report 2025: Record Impact Across All Divisions'       => 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?w=800&q=80',
                'Partnership Announcement: Expanding Maternal Health Services' => 'https://images.unsplash.com/photo-1593113598332-cd288d649433?w=800&q=80',
            ];
            $delays = ['', 'reveal-delay-100', 'reveal-delay-200'];
        @endphp

        <div class="mt-12 grid gap-8 md:grid-cols-3">
            @foreach ($articles as $i => $post)
                @php $imgSrc = $post->imageUrl() ?: ($fallbacks[$post->title] ?? null); @endphp
                <article class="reveal {{ $delays[$i % count($delays)] }} group overflow-hidden rounded-3xl bg-white shadow-card ring-1 ring-black/5 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-soft">
                    <div class="img-zoom relative">
                        @if ($imgSrc)
                            <img src="{{ $imgSrc }}" alt="{{ $post->title }}" class="aspect-[16/10] w-full object-cover">
                        @else
                            <div class="aspect-[16/10] w-full bg-gradient-to-br from-brand-red-100 to-brand-green-100"></div>
                        @endif
                        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-black/30 to-transparent"></div>
                        @if ($post->category)
                            <span class="absolute left-4 top-4 inline-flex items-center gap-1.5 rounded-full bg-brand-red-500 px-3 py-1 text-xs font-semibold text-white">
                                {{ $post->category }}
                            </span>
                        @endif
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 text-xs text-brand-muted">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                                <path d="M5.75 3a.75.75 0 0 1 .75.75V5h7V3.75a.75.75 0 0 1 1.5 0V5h.25A2.75 2.75 0 0 1 18 7.75v7.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-7.5A2.75 2.75 0 0 1 4.75 5H5V3.75A.75.75 0 0 1 5.75 3ZM4 9v6.25c0 .41.34.75.75.75h10.5c.41 0 .75-.34.75-.75V9H4Z"/>
                            </svg>
                            {{ $post->published_at?->format('M j, Y') }}
                        </div>
                        <h3 class="mt-3 text-lg font-bold leading-snug text-brand-ink">{{ $post->title }}</h3>
                        @if ($post->excerpt)
                            <p class="mt-2 text-sm text-brand-muted">{{ $post->excerpt }}</p>
                        @endif
                        <a href="#" class="group/btn mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-red-500 hover:text-brand-red-600">
                            Read More
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 transition-transform group-hover/btn:translate-x-1">
                                <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

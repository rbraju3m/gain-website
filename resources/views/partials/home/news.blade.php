{{-- Section 9: Latest News & Events --}}
<section id="news" class="bg-white py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">

        <div class="flex flex-wrap items-end justify-between gap-6">
            <div>
                <h2 class="font-display text-4xl font-bold text-brand-ink sm:text-5xl">
                    Latest <span class="text-brand-red-500">News &amp; Events</span>
                </h2>
                <p class="mt-3 max-w-xl text-brand-muted">
                    Stay updated with our latest initiatives, success stories, and community impact.
                </p>
            </div>
            <a href="#" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-red-500 hover:text-brand-red-600">
                View All News
                <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                    <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
                </svg>
            </a>
        </div>

        <div class="mt-12 grid gap-8 md:grid-cols-3">
            @foreach ([
                [
                    'category' => 'Initiative',
                    'date'     => 'May 15, 2026',
                    'title'    => 'New Community Garden Initiative Launches in Sylhet Division',
                    'body'     => '50 families receive training and resources to establish sustainable nutrition gardens in their communities.',
                    'img'      => 'images/news-garden.jpg',
                    'fallback' => 'https://images.unsplash.com/photo-1471193945509-9ad0617afabf?w=800&q=80',
                ],
                [
                    'category' => 'Report',
                    'date'     => 'May 10, 2026',
                    'title'    => 'Annual Report 2025: Record Impact Across All Divisions',
                    'body'     => 'Our comprehensive annual report showcases unprecedented growth and community impact achievements.',
                    'img'      => 'images/news-report.jpg',
                    'fallback' => 'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?w=800&q=80',
                ],
                [
                    'category' => 'Partnership',
                    'date'     => 'May 5, 2026',
                    'title'    => 'Partnership Announcement: Expanding Maternal Health Services',
                    'body'     => 'Collaborating with international partners to reach 5,000 more mothers with nutrition education.',
                    'img'      => 'images/news-partnership.jpg',
                    'fallback' => 'https://images.unsplash.com/photo-1593113598332-cd288d649433?w=800&q=80',
                ],
            ] as $post)
                <article class="overflow-hidden rounded-3xl bg-white shadow-card ring-1 ring-black/5 transition hover:-translate-y-1 hover:shadow-soft">
                    <div class="relative">
                        <img src="{{ asset($post['img']) }}"
                             onerror="this.onerror=null; this.src='{{ $post['fallback'] }}'"
                             alt="{{ $post['title'] }}"
                             class="aspect-[16/10] w-full object-cover">
                        <span class="absolute left-4 top-4 inline-flex items-center gap-1.5 rounded-full bg-brand-red-500 px-3 py-1 text-xs font-semibold text-white">
                            {{ $post['category'] }}
                        </span>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 text-xs text-brand-muted">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                                <path d="M5.75 3a.75.75 0 0 1 .75.75V5h7V3.75a.75.75 0 0 1 1.5 0V5h.25A2.75 2.75 0 0 1 18 7.75v7.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-7.5A2.75 2.75 0 0 1 4.75 5H5V3.75A.75.75 0 0 1 5.75 3ZM4 9v6.25c0 .41.34.75.75.75h10.5c.41 0 .75-.34.75-.75V9H4Z"/>
                            </svg>
                            {{ $post['date'] }}
                        </div>
                        <h3 class="mt-3 text-lg font-bold leading-snug text-brand-ink">{{ $post['title'] }}</h3>
                        <p class="mt-2 text-sm text-brand-muted">{{ $post['body'] }}</p>
                        <a href="#" class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-red-500 hover:text-brand-red-600">
                            Read More
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

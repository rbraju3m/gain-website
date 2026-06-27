@extends('layouts.site')

@section('title', $article->title . ' — ' . config('app.name'))

@section('content')
    {{-- Hero header --}}
    <section class="relative -mt-[72px] overflow-hidden bg-hero-wash">
        <div class="blob-drift-a pointer-events-none absolute -top-32 -left-32 h-[420px] w-[420px] rounded-full bg-brand-red-100/60 blur-3xl"></div>
        <div class="blob-drift-b pointer-events-none absolute bottom-0 right-0 h-[380px] w-[380px] rounded-full bg-brand-green-100/70 blur-3xl"></div>

        <div class="relative mx-auto max-w-5xl px-6 pb-16 pt-32 lg:px-10 lg:pt-40">

            <nav class="reveal text-sm text-brand-muted">
                <a href="{{ url('/') }}" class="hover:text-brand-red-500">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ url('/#news') }}" class="hover:text-brand-red-500">News &amp; Events</a>
                <span class="mx-2">/</span>
                <span class="text-brand-ink">{{ Str::limit($article->title, 60) }}</span>
            </nav>

            <div class="reveal reveal-delay-100 mt-6 flex flex-wrap items-center gap-3">
                @if ($article->category)
                    <span class="inline-flex items-center gap-2 rounded-full bg-brand-red-500 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-white">
                        <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                        {{ $article->category }}
                    </span>
                @endif
                <span class="inline-flex items-center gap-1.5 text-xs font-medium text-brand-muted">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                        <path d="M5.75 3a.75.75 0 0 1 .75.75V5h7V3.75a.75.75 0 0 1 1.5 0V5h.25A2.75 2.75 0 0 1 18 7.75v7.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-7.5A2.75 2.75 0 0 1 4.75 5H5V3.75A.75.75 0 0 1 5.75 3ZM4 9v6.25c0 .41.34.75.75.75h10.5c.41 0 .75-.34.75-.75V9H4Z"/>
                    </svg>
                    {{ $article->published_at?->format('F j, Y') }}
                </span>
            </div>

            <h1 class="reveal reveal-delay-100 mt-5 font-display text-4xl font-bold leading-tight text-brand-ink sm:text-5xl lg:text-6xl">
                {{ $article->title }}
            </h1>

            @if ($article->excerpt)
                <p class="reveal reveal-delay-200 mt-5 max-w-3xl text-lg text-brand-muted">{{ $article->excerpt }}</p>
            @endif
        </div>

        <svg viewBox="0 0 1440 80" class="block w-full text-white" preserveAspectRatio="none" aria-hidden="true">
            <path fill="currentColor" d="M0,32 C240,80 480,0 720,32 C960,64 1200,16 1440,48 L1440,80 L0,80 Z"/>
        </svg>
    </section>

    {{-- Article body --}}
    <section class="bg-white py-16">
        <div class="mx-auto max-w-5xl px-6 lg:px-10">

            @if ($article->imageUrl())
                <figure class="reveal img-zoom overflow-hidden rounded-3xl shadow-card ring-1 ring-black/5">
                    <img src="{{ $article->imageUrl() }}" alt="{{ $article->title }}"
                         class="aspect-[16/9] w-full object-cover">
                </figure>
            @endif

            <article class="reveal reveal-delay-100 mx-auto mt-12 max-w-3xl">
                @if ($article->body)
                    <div class="prose-content">{!! $article->body !!}</div>
                @else
                    <p class="italic text-brand-muted">Full article coming soon.</p>
                @endif

                <div class="mt-12 flex items-center justify-between border-t border-brand-cream pt-6 text-sm text-brand-muted">
                    <span>Published {{ $article->published_at?->diffForHumans() }}</span>
                    <a href="{{ url('/#news') }}" class="inline-flex items-center gap-1.5 font-semibold text-brand-red-500 hover:text-brand-red-600">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M17 10a.75.75 0 0 1-.75.75H5.6l4.18 3.96a.75.75 0 1 1-1.08 1.04l-5.5-5.75a.75.75 0 0 1 0-1.04l5.5-5.75a.75.75 0 1 1 1.08 1.04L5.6 9.25h10.65A.75.75 0 0 1 17 10Z"/></svg>
                        Back to news
                    </a>
                </div>
            </article>
        </div>
    </section>

    {{-- Related --}}
    @if ($related->isNotEmpty())
        <section class="bg-section-cream py-20">
            <div class="mx-auto max-w-7xl px-6 lg:px-10">

                <div class="flex flex-wrap items-end justify-between gap-4">
                    <h2 class="reveal font-display text-3xl font-bold text-brand-ink sm:text-4xl">
                        More <span class="draw-underline-red text-brand-red-500">News &amp; Events</span>
                    </h2>
                    <a href="{{ url('/#news') }}" class="reveal reveal-delay-100 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-red-500 hover:text-brand-red-600">
                        See all
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                            <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-3">
                    @foreach ($related as $i => $other)
                        <a href="{{ route('news.show', $other) }}"
                           class="card-hover reveal reveal-delay-{{ ($i + 1) * 100 }} group overflow-hidden rounded-3xl bg-white shadow-card ring-1 ring-black/5 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-soft">
                            <div class="img-zoom relative">
                                @if ($other->imageUrl())
                                    <img src="{{ $other->imageUrl() }}" alt="{{ $other->title }}" class="aspect-[16/10] w-full object-cover">
                                @else
                                    <div class="aspect-[16/10] w-full bg-gradient-to-br from-brand-red-100 to-brand-green-100"></div>
                                @endif
                            </div>
                            <div class="p-6">
                                <div class="text-xs text-brand-muted">{{ $other->published_at?->format('M j, Y') }}</div>
                                <h3 class="mt-2 text-lg font-bold leading-snug text-brand-ink group-hover:text-brand-red-500">{{ $other->title }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

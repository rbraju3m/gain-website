@extends('layouts.site')

@section('title', $article->title . ' — ' . config('app.name'))

@php
    $bodyText = strip_tags($article->body ?? '');
    $words    = str_word_count($bodyText);
    $readTime = max(1, (int) ceil($words / 200));
    $shareUrl = route('news.show', $article);
@endphp

@section('content')

    {{-- Above-fold --}}
    <section class="relative bg-white pt-32 lg:pt-40">
        <div class="mx-auto max-w-3xl px-6 lg:px-10">

            <nav class="text-center text-sm text-brand-muted">
                <ol class="flex flex-wrap justify-center gap-1.5">
                    <li><a href="{{ url('/') }}" class="hover:text-brand-red-500">Home</a></li>
                    <li class="text-brand-muted/60">/</li>
                    <li><a href="{{ route('news.index') }}" class="hover:text-brand-red-500">News &amp; Events</a></li>
                </ol>
            </nav>

            @if ($article->category)
                <div class="mt-8 text-center">
                    <span class="reveal inline-flex items-center gap-2 rounded-full border border-brand-red-200 bg-white/80 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-brand-red-500">
                        <span class="h-1.5 w-1.5 rounded-full bg-brand-red-500"></span>
                        {{ $article->category }}
                    </span>
                </div>
            @endif

            <h1 class="reveal reveal-delay-100 mt-6 text-center font-display text-4xl font-bold leading-[1.05] text-brand-ink sm:text-5xl lg:text-6xl">
                {{ $article->title }}
            </h1>

            @if ($article->excerpt)
                <p class="reveal reveal-delay-200 mx-auto mt-6 max-w-2xl text-center font-display text-lg italic leading-relaxed text-brand-muted sm:text-xl">
                    {{ $article->excerpt }}
                </p>
            @endif

            <div class="reveal reveal-delay-200 mt-7 flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-sm text-brand-muted">
                <span class="inline-flex items-center gap-1.5">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                        <path d="M5.75 3a.75.75 0 0 1 .75.75V5h7V3.75a.75.75 0 0 1 1.5 0V5h.25A2.75 2.75 0 0 1 18 7.75v7.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-7.5A2.75 2.75 0 0 1 4.75 5H5V3.75A.75.75 0 0 1 5.75 3ZM4 9v6.25c0 .41.34.75.75.75h10.5c.41 0 .75-.34.75-.75V9H4Z"/>
                    </svg>
                    {{ $article->published_at?->format('F j, Y') }}
                </span>
                <span aria-hidden="true" class="hidden h-1 w-1 rounded-full bg-brand-muted/40 sm:block"></span>
                <span class="inline-flex items-center gap-1.5">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .2.08.39.22.53l3 3a.75.75 0 1 0 1.06-1.06l-2.78-2.78V5Z" clip-rule="evenodd"/></svg>
                    {{ $readTime }} min read
                </span>
            </div>

            <div class="reveal reveal-delay-300 mt-7 flex flex-wrap items-center justify-center gap-3">
                <span class="text-[10px] font-semibold uppercase tracking-[0.18em] text-brand-muted">Share</span>
                @include('partials.share-buttons', ['url' => $shareUrl, 'title' => $article->title])
            </div>
        </div>

        <div class="mx-auto mt-14 max-w-5xl px-6 lg:px-10">
            <div class="h-px w-full bg-gradient-to-r from-transparent via-brand-ink/15 to-transparent"></div>
        </div>
    </section>

    {{-- Feature image (wide) --}}
    @if ($article->imageUrl())
        <div class="bg-white pt-10">
            <div class="mx-auto max-w-6xl px-6 lg:px-10">
                <figure class="reveal img-zoom overflow-hidden rounded-[2rem] shadow-card ring-1 ring-black/5">
                    <img src="{{ $article->imageUrl() }}" alt="{{ $article->title }}"
                         class="aspect-[21/9] w-full object-cover">
                </figure>
            </div>
        </div>
    @endif

    {{-- Body --}}
    <section class="bg-white pb-24 pt-12 lg:pt-16">
        <div class="mx-auto max-w-3xl px-6 lg:px-10">

            <article class="reveal">
                @if ($article->body)
                    <div class="prose-content">{!! $article->body !!}</div>
                @else
                    <p class="italic text-brand-muted">Full article coming soon.</p>
                @endif
            </article>

            <div class="reveal mt-14 border-t border-brand-cream pt-8">
                <div class="flex flex-wrap items-center justify-between gap-6">
                    <div class="text-xs uppercase tracking-[0.18em] text-brand-muted">
                        Published {{ $article->published_at?->format('M j, Y') }}
                        @if ($article->category) · {{ $article->category }} @endif
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-[10px] font-semibold uppercase tracking-[0.18em] text-brand-muted">Share</span>
                        @include('partials.share-buttons', ['url' => $shareUrl, 'title' => $article->title])
                    </div>
                </div>
            </div>

            @include('partials.article-cta')
        </div>
    </section>

    {{-- Related --}}
    @if ($related->isNotEmpty())
        <section class="relative overflow-hidden bg-section-cream py-20">
            <div class="mx-auto max-w-7xl px-6 lg:px-10">

                <div class="flex flex-wrap items-end justify-between gap-4">
                    <h2 class="reveal font-display text-3xl font-bold text-brand-ink sm:text-4xl">
                        More <span class="draw-underline-red text-brand-red-500">News &amp; Events</span>
                    </h2>
                    <a href="{{ route('news.index') }}" class="reveal reveal-delay-100 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-red-500 hover:text-brand-red-600">
                        View all
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/></svg>
                    </a>
                </div>

                <div class="mt-10 grid gap-8 md:grid-cols-3">
                    @foreach ($related as $i => $other)
                        <a href="{{ route('news.show', $other) }}"
                           class="card-hover reveal {{ ['', 'reveal-delay-100', 'reveal-delay-200'][$i % 3] }} group flex flex-col overflow-hidden rounded-3xl bg-white shadow-card ring-1 ring-black/5 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-soft">
                            <div class="img-zoom relative">
                                @if ($other->imageUrl())
                                    <img src="{{ $other->imageUrl() }}" alt="{{ $other->title }}" class="aspect-[16/10] w-full object-cover">
                                @else
                                    <div class="aspect-[16/10] w-full bg-gradient-to-br from-brand-red-100 via-brand-cream to-brand-green-100"></div>
                                @endif
                            </div>
                            <div class="flex flex-1 flex-col p-6">
                                <div class="text-xs text-brand-muted">{{ $other->published_at?->format('M j, Y') }}</div>
                                <h3 class="mt-1 text-lg font-bold leading-snug text-brand-ink group-hover:text-brand-red-500">{{ $other->title }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

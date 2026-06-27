@extends('layouts.site')

@section('title', $programme->title . ' — ' . config('app.name'))

@php
    $bodyText  = strip_tags($programme->body ?? '');
    $words     = str_word_count($bodyText);
    $readTime  = max(1, (int) ceil($words / 200));
    $shareUrl  = route('programmes.show', $programme);
@endphp

@section('content')

    {{-- Hero --}}
    <section class="relative -mt-[72px] overflow-hidden bg-hero-wash pb-12">
        <div class="blob-drift-a pointer-events-none absolute -top-32 -left-32 h-[460px] w-[460px] rounded-full bg-brand-red-100/60 blur-3xl"></div>
        <div class="blob-drift-b pointer-events-none absolute bottom-0 right-0 h-[420px] w-[420px] rounded-full bg-brand-green-100/70 blur-3xl"></div>

        <div class="relative mx-auto max-w-4xl px-6 pt-32 lg:px-10 lg:pt-40">

            <nav class="reveal text-sm text-brand-muted">
                <ol class="flex flex-wrap items-center gap-1.5">
                    <li><a href="{{ url('/') }}" class="hover:text-brand-red-500">Home</a></li>
                    <li class="text-brand-muted/60">/</li>
                    <li><a href="{{ route('programmes.index') }}" class="hover:text-brand-red-500">Programmes</a></li>
                    <li class="text-brand-muted/60">/</li>
                    <li class="text-brand-ink">{{ Str::limit($programme->title, 60) }}</li>
                </ol>
            </nav>

            @if ($programme->category)
                <span class="reveal reveal-delay-100 mt-7 inline-flex items-center gap-2 rounded-full border border-brand-red-200 bg-white/80 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-brand-red-500">
                    <span class="h-1.5 w-1.5 rounded-full bg-brand-red-500"></span>
                    {{ $programme->category }}
                </span>
            @endif

            <h1 class="reveal reveal-delay-100 mt-5 font-display text-4xl font-bold leading-[1.1] text-brand-ink sm:text-5xl lg:text-6xl">
                {{ $programme->title }}
            </h1>

            <div class="reveal reveal-delay-200 mt-6 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-brand-muted">
                <span class="inline-flex items-center gap-1.5">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .2.08.39.22.53l3 3a.75.75 0 1 0 1.06-1.06l-2.78-2.78V5Z" clip-rule="evenodd"/></svg>
                    {{ $readTime }} min read
                </span>
                @if ($programme->url)
                    <a href="{{ $programme->url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 font-semibold text-brand-red-500 hover:text-brand-red-600">
                        Programme website
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5"><path d="M11 3a1 1 0 1 0 0 2h2.586l-6.293 6.293a1 1 0 1 0 1.414 1.414L15 6.414V9a1 1 0 1 0 2 0V4a1 1 0 0 0-1-1h-5Z"/><path d="M5 5a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-3a1 1 0 1 0-2 0v3H5V7h3a1 1 0 0 0 0-2H5Z"/></svg>
                    </a>
                @endif
            </div>
        </div>
    </section>

    {{-- Feature image — overlaps hero/body for editorial feel --}}
    @if ($programme->imageUrl())
        <div class="relative -mt-2 bg-gradient-to-b from-transparent via-white to-white">
            <div class="mx-auto max-w-5xl px-6 lg:px-10">
                <figure class="reveal img-zoom overflow-hidden rounded-[2rem] shadow-card ring-1 ring-black/5">
                    <img src="{{ $programme->imageUrl() }}" alt="{{ $programme->title }}"
                         class="aspect-[16/8] w-full object-cover">
                </figure>
            </div>
        </div>
    @endif

    {{-- Article body — 2-column on lg+ --}}
    <section class="bg-white pb-24 pt-16">
        <div class="mx-auto max-w-6xl px-6 lg:px-10">

            <div class="grid gap-12 lg:grid-cols-12">

                {{-- Sticky sidebar (3/12) --}}
                <aside class="lg:col-span-3">
                    <div class="lg:sticky lg:top-28">
                        <div class="rounded-2xl bg-brand-cream/60 p-5 ring-1 ring-black/5">
                            <div class="text-[10px] font-semibold uppercase tracking-[0.18em] text-brand-muted">Share this</div>
                            <div class="mt-3">
                                @include('partials.share-buttons', ['url' => $shareUrl, 'title' => $programme->title])
                            </div>
                        </div>

                        <a href="{{ route('programmes.index') }}" class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-red-500 hover:text-brand-red-600">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M17 10a.75.75 0 0 1-.75.75H5.6l4.18 3.96a.75.75 0 1 1-1.08 1.04l-5.5-5.75a.75.75 0 0 1 0-1.04l5.5-5.75a.75.75 0 1 1 1.08 1.04L5.6 9.25h10.65A.75.75 0 0 1 17 10Z"/></svg>
                            All programmes
                        </a>
                    </div>
                </aside>

                {{-- Main column (9/12) --}}
                <article class="reveal lg:col-span-9">
                    @if ($programme->body)
                        <div class="prose-content max-w-3xl">{!! $programme->body !!}</div>
                    @else
                        <p class="italic text-brand-muted">Full description coming soon.</p>
                    @endif

                    @if ($programme->url)
                        <div class="mt-12 rounded-2xl border border-brand-red-100 bg-brand-cream/40 p-6 sm:p-8">
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div>
                                    <div class="text-xs font-semibold uppercase tracking-wider text-brand-red-500">Learn more</div>
                                    <h3 class="mt-1 font-display text-xl font-bold text-brand-ink">Visit the programme site</h3>
                                </div>
                                <a href="{{ $programme->url }}" target="_blank" rel="noopener"
                                   class="btn-shimmer inline-flex items-center gap-2 rounded-full bg-brand-red-500 px-6 py-3 text-sm font-semibold text-white shadow-pill hover:bg-brand-red-600">
                                    <span class="inline-flex items-center gap-2">
                                        Open website
                                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M11 3a1 1 0 1 0 0 2h2.586l-6.293 6.293a1 1 0 1 0 1.414 1.414L15 6.414V9a1 1 0 1 0 2 0V4a1 1 0 0 0-1-1h-5Z"/><path d="M5 5a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-3a1 1 0 1 0-2 0v3H5V7h3a1 1 0 0 0 0-2H5Z"/></svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    @endif
                </article>
            </div>
        </div>
    </section>

    {{-- Related --}}
    @if ($related->isNotEmpty())
        <section class="relative overflow-hidden bg-section-cream py-20">
            <div class="mx-auto max-w-7xl px-6 lg:px-10">

                <div class="flex flex-wrap items-end justify-between gap-4">
                    <h2 class="reveal font-display text-3xl font-bold text-brand-ink sm:text-4xl">
                        Continue exploring <span class="draw-underline-red text-brand-red-500">programmes</span>
                    </h2>
                    <a href="{{ route('programmes.index') }}" class="reveal reveal-delay-100 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-red-500 hover:text-brand-red-600">
                        View all
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/></svg>
                    </a>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-3">
                    @foreach ($related as $i => $other)
                        <a href="{{ route('programmes.show', $other) }}"
                           class="card-hover reveal {{ ['', 'reveal-delay-100', 'reveal-delay-200'][$i % 3] }} group flex flex-col overflow-hidden rounded-3xl bg-white shadow-card ring-1 ring-black/5 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-soft">
                            <div class="img-zoom relative">
                                @if ($other->imageUrl())
                                    <img src="{{ $other->imageUrl() }}" alt="{{ $other->title }}" class="aspect-[16/10] w-full object-cover">
                                @else
                                    <div class="aspect-[16/10] w-full bg-gradient-to-br from-brand-red-100 via-brand-cream to-brand-green-100"></div>
                                @endif
                            </div>
                            <div class="flex flex-1 flex-col p-6">
                                @if ($other->category)
                                    <div class="text-xs font-semibold uppercase tracking-wider text-brand-red-500">{{ $other->category }}</div>
                                @endif
                                <h3 class="mt-2 font-display text-xl font-bold leading-snug text-brand-ink group-hover:text-brand-red-500">{{ $other->title }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

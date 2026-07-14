@extends('layouts.site')

@section('title', $service->title . ' — ' . config('app.name'))

@php
    $bodyText = strip_tags($service->body ?? '');
    $words    = str_word_count($bodyText);
    $readTime = max(1, (int) ceil($words / 200));
    $shareUrl = route('services.show', $service);
@endphp

@section('content')

    <section class="relative bg-white pt-32 lg:pt-40">
        <div class="mx-auto max-w-3xl px-6 lg:px-10">

            <nav class="text-center text-sm text-brand-muted">
                <ol class="flex flex-wrap justify-center gap-1.5">
                    <li><a href="{{ url('/') }}" class="hover:text-brand-red-500">Home</a></li>
                    <li class="text-brand-muted/60">/</li>
                    <li><a href="{{ route('services.index') }}" class="hover:text-brand-red-500">Services</a></li>
                </ol>
            </nav>

            @if ($service->category)
                <div class="mt-8 text-center">
                    <span class="reveal inline-flex items-center gap-2 rounded-full border border-brand-red-200 bg-white/80 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-brand-red-500">
                        <span class="h-1.5 w-1.5 rounded-full bg-brand-red-500"></span>
                        {{ $service->category }}
                    </span>
                </div>
            @endif

            <h1 class="reveal reveal-delay-100 mt-6 text-center font-display text-4xl font-bold leading-[1.05] text-brand-red-500 sm:text-5xl lg:text-6xl">
                {{ $service->title }}
            </h1>

            <div class="reveal reveal-delay-200 mt-7 flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-sm text-brand-muted">
                <span class="inline-flex items-center gap-1.5">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .2.08.39.22.53l3 3a.75.75 0 1 0 1.06-1.06l-2.78-2.78V5Z" clip-rule="evenodd"/></svg>
                    {{ $readTime }} min read
                </span>
                @if ($service->url)
                    <span aria-hidden="true" class="hidden h-1 w-1 rounded-full bg-brand-muted/40 sm:block"></span>
                    <a href="{{ $service->url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 font-semibold text-brand-red-500 hover:text-brand-red-600">
                        Visit resource
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5"><path d="M11 3a1 1 0 1 0 0 2h2.586l-6.293 6.293a1 1 0 1 0 1.414 1.414L15 6.414V9a1 1 0 1 0 2 0V4a1 1 0 0 0-1-1h-5Z"/><path d="M5 5a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-3a1 1 0 1 0-2 0v3H5V7h3a1 1 0 0 0 0-2H5Z"/></svg>
                    </a>
                @endif
            </div>

            <div class="reveal reveal-delay-300 mt-7 flex flex-wrap items-center justify-center gap-3">
                <span class="text-[10px] font-semibold uppercase tracking-[0.18em] text-brand-muted">Share</span>
                @include('partials.share-buttons', ['url' => $shareUrl, 'title' => $service->title])
            </div>
        </div>

        <div class="mx-auto mt-14 max-w-5xl px-6 lg:px-10">
            <div class="h-px w-full bg-gradient-to-r from-transparent via-brand-ink/15 to-transparent"></div>
        </div>
    </section>

    @if ($service->imageUrl())
        <div class="bg-white pt-10">
            <div class="mx-auto max-w-6xl px-6 lg:px-10">
                <figure class="reveal img-zoom overflow-hidden rounded-[2rem] shadow-card ring-1 ring-black/5">
                    <img src="{{ $service->imageUrl() }}" alt="{{ $service->title }}"
                         class="aspect-[21/9] w-full object-cover">
                </figure>
            </div>
        </div>
    @endif

    <section class="bg-white pb-24 pt-12 lg:pt-16">
        <div class="mx-auto max-w-3xl px-6 lg:px-10">

            <article class="reveal">
                @if ($service->body)
                    <div class="prose-content">{!! $service->body !!}</div>
                @elseif ($service->summary)
                    <p class="text-lg text-brand-ink">{{ $service->summary }}</p>
                @else
                    <p class="italic text-brand-muted">Full description coming soon.</p>
                @endif
            </article>

            <div class="reveal mt-14 border-t border-brand-cream pt-8">
                <div class="flex flex-wrap items-center justify-between gap-6">
                    <div class="text-xs uppercase tracking-[0.18em] text-brand-muted">
                        @if ($service->category) Service · {{ $service->category }} @else Service @endif
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-[10px] font-semibold uppercase tracking-[0.18em] text-brand-muted">Share</span>
                        @include('partials.share-buttons', ['url' => $shareUrl, 'title' => $service->title])
                    </div>
                </div>
            </div>

            @include('partials.article-cta')
        </div>
    </section>

    @if ($related->isNotEmpty())
        <section class="relative overflow-hidden bg-section-cream py-20">
            <div class="mx-auto max-w-7xl px-6 lg:px-10">

                <div class="flex flex-wrap items-end justify-between gap-4">
                    <h2 class="reveal font-display text-3xl font-bold text-brand-ink sm:text-4xl">
                        More <span class="draw-underline-red text-brand-red-500">services</span>
                    </h2>
                    <a href="{{ route('services.index') }}" class="reveal reveal-delay-100 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-red-500 hover:text-brand-red-600">
                        View all
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/></svg>
                    </a>
                </div>

                <div class="mt-10 grid gap-8 md:grid-cols-3">
                    @foreach ($related as $i => $other)
                        <a href="{{ route('services.show', $other) }}"
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

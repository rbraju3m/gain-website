@extends('layouts.site')

@section('title', $programme->title . ' — ' . config('app.name'))

@section('content')
    {{-- Hero header --}}
    <section class="relative -mt-[72px] overflow-hidden bg-hero-wash">
        <div class="blob-drift-a pointer-events-none absolute -top-32 -left-32 h-[420px] w-[420px] rounded-full bg-brand-red-100/60 blur-3xl"></div>
        <div class="blob-drift-b pointer-events-none absolute bottom-0 right-0 h-[380px] w-[380px] rounded-full bg-brand-green-100/70 blur-3xl"></div>

        <div class="relative mx-auto max-w-5xl px-6 pb-16 pt-32 lg:px-10 lg:pt-40">

            <nav class="reveal text-sm text-brand-muted">
                <a href="{{ url('/') }}" class="hover:text-brand-red-500">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ url('/#programmes') }}" class="hover:text-brand-red-500">Programmes</a>
                <span class="mx-2">/</span>
                <span class="text-brand-ink">{{ $programme->title }}</span>
            </nav>

            @if ($programme->category)
                <span class="reveal reveal-delay-100 mt-6 inline-flex items-center gap-2 rounded-full bg-brand-red-500 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-white">
                    <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                    {{ $programme->category }}
                </span>
            @endif

            <h1 class="reveal reveal-delay-100 mt-5 font-display text-4xl font-bold leading-tight text-brand-ink sm:text-5xl lg:text-6xl">
                {{ $programme->title }}
            </h1>
        </div>

        <svg viewBox="0 0 1440 80" class="block w-full text-white" preserveAspectRatio="none" aria-hidden="true">
            <path fill="currentColor" d="M0,32 C240,80 480,0 720,32 C960,64 1200,16 1440,48 L1440,80 L0,80 Z"/>
        </svg>
    </section>

    {{-- Article body --}}
    <section class="bg-white py-16">
        <div class="mx-auto max-w-5xl px-6 lg:px-10">

            @if ($programme->imageUrl())
                <figure class="reveal img-zoom overflow-hidden rounded-3xl shadow-card ring-1 ring-black/5">
                    <img src="{{ $programme->imageUrl() }}" alt="{{ $programme->title }}"
                         class="aspect-[16/9] w-full object-cover">
                </figure>
            @endif

            <article class="reveal reveal-delay-100 mx-auto mt-12 max-w-3xl">
                @if ($programme->body)
                    <div class="prose-content">{!! $programme->body !!}</div>
                @else
                    <p class="italic text-brand-muted">Full description coming soon.</p>
                @endif

                @if ($programme->url)
                    <div class="mt-10">
                        <a href="{{ $programme->url }}" target="_blank" rel="noopener"
                           class="btn-shimmer inline-flex items-center gap-2 rounded-full bg-brand-red-500 px-6 py-3 text-sm font-semibold text-white shadow-pill transition hover:bg-brand-red-600">
                            <span class="inline-flex items-center gap-2">
                                Visit programme page
                                <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                    <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                @endif
            </article>
        </div>
    </section>

    {{-- Related --}}
    @if ($related->isNotEmpty())
        <section class="bg-section-cream py-20">
            <div class="mx-auto max-w-7xl px-6 lg:px-10">

                <div class="flex flex-wrap items-end justify-between gap-4">
                    <h2 class="reveal font-display text-3xl font-bold text-brand-ink sm:text-4xl">
                        More <span class="draw-underline-red text-brand-red-500">Programmes</span>
                    </h2>
                    <a href="{{ url('/#programmes') }}" class="reveal reveal-delay-100 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-red-500 hover:text-brand-red-600">
                        See all
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                            <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-3">
                    @foreach ($related as $i => $other)
                        <a href="{{ route('programmes.show', $other) }}"
                           class="card-hover reveal reveal-delay-{{ ($i + 1) * 100 }} group overflow-hidden rounded-3xl bg-white shadow-card ring-1 ring-black/5 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-soft">
                            <div class="img-zoom relative">
                                @if ($other->imageUrl())
                                    <img src="{{ $other->imageUrl() }}" alt="{{ $other->title }}" class="aspect-[16/9] w-full object-cover">
                                @else
                                    <div class="aspect-[16/9] w-full bg-gradient-to-br from-brand-red-100 to-brand-green-100"></div>
                                @endif
                            </div>
                            <div class="p-6">
                                @if ($other->category)
                                    <div class="text-xs font-semibold uppercase tracking-wider text-brand-red-500">{{ $other->category }}</div>
                                @endif
                                <h3 class="mt-2 font-display text-xl font-bold text-brand-ink group-hover:text-brand-red-500">{{ $other->title }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

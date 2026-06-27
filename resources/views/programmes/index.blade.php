@extends('layouts.site')

@section('title', 'Programmes — ' . config('app.name'))

@section('content')

    @include('partials.page-hero', [
        'eyebrow'    => 'What We Do',
        'title'      => 'Our Programmes',
        'accentText' => 'Programmes',
        'accent'     => 'red',
        'intro'      => 'Sustainable initiatives across nutrition, food security, education, and livelihoods — built with the communities we serve.',
        'crumb'      => ['Home' => url('/'), 'Programmes' => null],
    ])

    <section class="bg-white pb-24 pt-12">
        <div class="mx-auto max-w-7xl px-6 lg:px-10">

            @if ($categories->isNotEmpty())
                <div class="reveal flex flex-wrap items-center justify-center gap-2">
                    <a href="{{ route('programmes.index') }}"
                       class="rounded-full px-4 py-1.5 text-xs font-semibold uppercase tracking-wider transition
                              {{ $active === '' ? 'bg-brand-red-500 text-white shadow-pill' : 'bg-brand-cream text-brand-muted hover:bg-brand-red-100 hover:text-brand-red-500' }}">
                        All
                    </a>
                    @foreach ($categories as $cat)
                        <a href="{{ route('programmes.index', ['category' => $cat]) }}"
                           class="rounded-full px-4 py-1.5 text-xs font-semibold uppercase tracking-wider transition
                                  {{ $active === $cat ? 'bg-brand-red-500 text-white shadow-pill' : 'bg-brand-cream text-brand-muted hover:bg-brand-red-100 hover:text-brand-red-500' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            @endif

            @if ($programmes->isEmpty())
                <div class="mt-16 rounded-3xl border border-brand-red-100 bg-brand-cream/50 px-8 py-16 text-center">
                    <div class="mx-auto grid h-14 w-14 place-items-center rounded-full bg-brand-red-100 text-brand-red-500">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6"><path d="M11 7h2v6h-2zM11 15h2v2h-2z"/><path fill-rule="evenodd" d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm0 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16Z" clip-rule="evenodd"/></svg>
                    </div>
                    <h2 class="mt-4 font-display text-2xl font-bold text-brand-ink">No programmes here yet</h2>
                    <p class="mt-2 text-brand-muted">{{ $active !== '' ? 'No programmes match this category.' : 'Check back soon — new initiatives launch through the year.' }}</p>
                </div>
            @else
                <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($programmes as $i => $p)
                        <a href="{{ route('programmes.show', $p) }}"
                           class="card-hover reveal {{ ['', 'reveal-delay-100', 'reveal-delay-200'][$i % 3] }} group flex h-full flex-col overflow-hidden rounded-3xl bg-white shadow-card ring-1 ring-black/5 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-soft">
                            <div class="img-zoom relative">
                                @if ($p->imageUrl())
                                    <img src="{{ $p->imageUrl() }}" alt="{{ $p->title }}" class="aspect-[16/10] w-full object-cover">
                                @else
                                    <div class="aspect-[16/10] w-full bg-gradient-to-br from-brand-red-100 via-brand-cream to-brand-green-100"></div>
                                @endif
                                <div class="pointer-events-none absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-black/30 to-transparent"></div>
                                @if ($p->category)
                                    <span class="absolute left-4 top-4 inline-flex items-center gap-1.5 rounded-full bg-brand-red-500 px-3 py-1 text-xs font-semibold text-white shadow-sm">
                                        <span class="h-1.5 w-1.5 rounded-full bg-white"></span>{{ $p->category }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex flex-1 flex-col p-7">
                                <h2 class="font-display text-2xl font-bold leading-tight text-brand-ink group-hover:text-brand-red-500">{{ $p->title }}</h2>
                                @if ($p->body)
                                    <p class="mt-3 line-clamp-3 text-brand-muted">{{ Str::limit(strip_tags($p->body), 180) }}</p>
                                @endif
                                <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-red-500">
                                    Read more
                                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 transition-transform group-hover:translate-x-1">
                                        <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-12">{{ $programmes->links() }}</div>
            @endif
        </div>
    </section>
@endsection

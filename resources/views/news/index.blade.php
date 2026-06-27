@extends('layouts.site')

@section('title', 'News & Events — ' . config('app.name'))

@section('content')

    @include('partials.page-hero', [
        'eyebrow'    => 'Latest Updates',
        'title'      => 'News & Events',
        'accentText' => 'Events',
        'accent'     => 'red',
        'intro'      => 'Initiatives, success stories, partnership announcements, and reports from across our work in Bangladesh.',
        'crumb'      => ['Home' => url('/'), 'News & Events' => null],
    ])

    <section class="bg-white pb-24 pt-12">
        <div class="mx-auto max-w-7xl px-6 lg:px-10">

            @if ($categories->isNotEmpty())
                <div class="reveal flex flex-wrap items-center justify-center gap-2">
                    <a href="{{ route('news.index') }}"
                       class="rounded-full px-4 py-1.5 text-xs font-semibold uppercase tracking-wider transition
                              {{ $active === '' ? 'bg-brand-red-500 text-white shadow-pill' : 'bg-brand-cream text-brand-muted hover:bg-brand-red-100 hover:text-brand-red-500' }}">
                        All
                    </a>
                    @foreach ($categories as $cat)
                        <a href="{{ route('news.index', ['category' => $cat]) }}"
                           class="rounded-full px-4 py-1.5 text-xs font-semibold uppercase tracking-wider transition
                                  {{ $active === $cat ? 'bg-brand-red-500 text-white shadow-pill' : 'bg-brand-cream text-brand-muted hover:bg-brand-red-100 hover:text-brand-red-500' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            @endif

            @if ($articles->isEmpty())
                <div class="mt-16 rounded-3xl border border-brand-red-100 bg-brand-cream/50 px-8 py-16 text-center">
                    <div class="mx-auto grid h-14 w-14 place-items-center rounded-full bg-brand-red-100 text-brand-red-500">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6"><path d="M11 7h2v6h-2zM11 15h2v2h-2z"/><path fill-rule="evenodd" d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Zm0 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16Z" clip-rule="evenodd"/></svg>
                    </div>
                    <h2 class="mt-4 font-display text-2xl font-bold text-brand-ink">Nothing to show yet</h2>
                    <p class="mt-2 text-brand-muted">{{ $active !== '' ? 'No articles match this category.' : 'New stories and updates will land here.' }}</p>
                </div>
            @else
                <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($articles as $i => $post)
                        <a href="{{ route('news.show', $post) }}"
                           class="card-hover reveal {{ ['', 'reveal-delay-100', 'reveal-delay-200'][$i % 3] }} group flex h-full flex-col overflow-hidden rounded-3xl bg-white shadow-card ring-1 ring-black/5 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-soft">
                            <div class="img-zoom relative">
                                @if ($post->imageUrl())
                                    <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="aspect-[16/10] w-full object-cover">
                                @else
                                    <div class="aspect-[16/10] w-full bg-gradient-to-br from-brand-red-100 via-brand-cream to-brand-green-100"></div>
                                @endif
                                <div class="pointer-events-none absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-black/30 to-transparent"></div>
                                @if ($post->category)
                                    <span class="absolute left-4 top-4 inline-flex items-center gap-1.5 rounded-full bg-brand-red-500 px-3 py-1 text-xs font-semibold text-white shadow-sm">
                                        <span class="h-1.5 w-1.5 rounded-full bg-white"></span>{{ $post->category }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex flex-1 flex-col p-7">
                                <div class="inline-flex items-center gap-1.5 text-xs font-medium text-brand-muted">
                                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                                        <path d="M5.75 3a.75.75 0 0 1 .75.75V5h7V3.75a.75.75 0 0 1 1.5 0V5h.25A2.75 2.75 0 0 1 18 7.75v7.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-7.5A2.75 2.75 0 0 1 4.75 5H5V3.75A.75.75 0 0 1 5.75 3ZM4 9v6.25c0 .41.34.75.75.75h10.5c.41 0 .75-.34.75-.75V9H4Z"/>
                                    </svg>
                                    {{ $post->published_at?->format('M j, Y') }}
                                </div>
                                <h2 class="mt-2 font-display text-xl font-bold leading-snug text-brand-ink group-hover:text-brand-red-500">{{ $post->title }}</h2>
                                @if ($post->excerpt)
                                    <p class="mt-3 line-clamp-3 text-sm text-brand-muted">{{ $post->excerpt }}</p>
                                @endif
                                <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-red-500">
                                    Read article
                                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 transition-transform group-hover:translate-x-1">
                                        <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-12">{{ $articles->links() }}</div>
            @endif
        </div>
    </section>
@endsection

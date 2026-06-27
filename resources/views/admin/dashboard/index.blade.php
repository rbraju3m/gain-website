@extends('admin.layouts.admin')

@section('title', 'Dashboard')
@section('breadcrumb', 'Overview')

@section('content')
<div class="space-y-6">

    {{-- Welcome banner --}}
    <div class="rounded-2xl bg-gradient-to-br from-brand-red-500 via-brand-red-600 to-brand-red-700 p-7 text-white shadow-card sm:p-9">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <div class="text-[10px] font-semibold uppercase tracking-[0.18em] text-white/70">{{ now()->format('l, F j') }}</div>
                <h2 class="mt-1 font-display text-3xl font-bold leading-tight sm:text-4xl">
                    Welcome back, {{ auth()->user()->name }}.
                </h2>
                <p class="mt-2 max-w-xl text-sm text-white/80">
                    Quick view of what's live on the public site and what's waiting for you in the inbox.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.programmes.create') }}"
                   class="inline-flex items-center gap-1.5 rounded-full bg-white px-4 py-2 text-sm font-semibold text-brand-red-500 shadow-pill hover:bg-brand-cream">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M10 4a1 1 0 0 1 1 1v4h4a1 1 0 1 1 0 2h-4v4a1 1 0 1 1-2 0v-4H5a1 1 0 1 1 0-2h4V5a1 1 0 0 1 1-1Z"/></svg>
                    New programme
                </a>
                <a href="{{ route('admin.news.create') }}"
                   class="inline-flex items-center gap-1.5 rounded-full border border-white/40 px-4 py-2 text-sm font-semibold text-white hover:bg-white/10">
                    New article
                </a>
            </div>
        </div>
    </div>

    {{-- KPI grid --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @php
            $tiles = [
                [
                    'label' => 'Programmes',
                    'value' => $stats['programmes'],
                    'sub'   => $stats['programmes_live'] . ' live on site',
                    'tone'  => 'red',
                    'href'  => route('admin.programmes.index'),
                    'icon'  => 'M4 4h16v4H4zM4 10h10v10H4zM16 10h4v10h-4z',
                ],
                [
                    'label' => 'News & Events',
                    'value' => $stats['news'],
                    'sub'   => $stats['news_published'] . ' published',
                    'tone'  => 'green',
                    'href'  => route('admin.news.index'),
                    'icon'  => 'M4 4h16v16H4zM4 8h16M8 12h8M8 16h6',
                ],
                [
                    'label' => 'Partners',
                    'value' => $stats['partners'],
                    'sub'   => $stats['testimonials'] . ' testimonials',
                    'tone'  => 'orange',
                    'href'  => route('admin.partners.index'),
                    'icon'  => 'M9 12a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm6 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3 21a6 6 0 0 1 12 0M9 21a6 6 0 0 1 12 0',
                ],
                [
                    'label' => 'Contact inbox',
                    'value' => $stats['contacts_unread'],
                    'sub'   => $stats['contacts_total'] . ' total',
                    'tone'  => 'red',
                    'href'  => route('admin.contact.index'),
                    'icon'  => 'M3 8l9 6 9-6M3 6h18v12H3z',
                    'pulse' => $stats['contacts_unread'] > 0,
                ],
            ];
            $tones = [
                'red'    => 'bg-brand-red-100 text-brand-red-500',
                'green'  => 'bg-brand-green-100 text-brand-green-600',
                'orange' => 'bg-brand-orange-100 text-brand-orange-500',
            ];
        @endphp

        @foreach ($tiles as $tile)
            <a href="{{ $tile['href'] }}"
               class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-card">
                <div class="flex items-start justify-between">
                    <span class="grid h-10 w-10 place-items-center rounded-xl {{ $tones[$tile['tone']] }} transition group-hover:scale-110">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="{{ $tile['icon'] }}"/></svg>
                    </span>
                    @if (! empty($tile['pulse']))
                        <span class="relative flex h-2 w-2">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-brand-red-500 opacity-60"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-brand-red-500"></span>
                        </span>
                    @endif
                </div>
                <div class="mt-4 text-xs font-semibold uppercase tracking-wider text-slate-400">{{ $tile['label'] }}</div>
                <div class="mt-1 font-display text-3xl font-bold text-slate-900">{{ $tile['value'] }}</div>
                <div class="mt-1 text-xs text-slate-500">{{ $tile['sub'] }}</div>
            </a>
        @endforeach
    </div>

    {{-- Two-column: messages + news --}}
    <div class="grid gap-6 lg:grid-cols-2">

        {{-- Recent contact messages --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                <div>
                    <h3 class="text-sm font-semibold text-slate-900">Recent messages</h3>
                    <p class="text-xs text-slate-500">Latest 5 from the public Contact form.</p>
                </div>
                <a href="{{ route('admin.contact.index') }}" class="text-xs font-semibold text-brand-red-500 hover:text-brand-red-600">Open inbox →</a>
            </div>
            @if ($recentMessages->isEmpty())
                <div class="px-5 py-10 text-center text-sm text-slate-500">No messages yet.</div>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach ($recentMessages as $msg)
                        <li>
                            <a href="{{ route('admin.contact.show', $msg) }}" class="flex items-start gap-3 px-5 py-3 transition hover:bg-slate-50">
                                <span class="mt-0.5 grid h-8 w-8 shrink-0 place-items-center rounded-full bg-brand-red-100 text-xs font-bold text-brand-red-500">{{ \Illuminate\Support\Str::of($msg->name)->substr(0, 1)->upper() }}</span>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="truncate text-sm font-semibold text-slate-900">{{ $msg->name }}</span>
                                        @if ($msg->isUnread())
                                            <span class="inline-flex items-center gap-1 rounded-full bg-brand-red-50 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-brand-red-600">New</span>
                                        @endif
                                    </div>
                                    <div class="truncate text-xs text-slate-500">{{ $msg->subject ?: $msg->email }}</div>
                                </div>
                                <div class="text-right text-[11px] text-slate-400">{{ $msg->created_at->diffForHumans(null, true, true) }}</div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Recent news --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                <div>
                    <h3 class="text-sm font-semibold text-slate-900">Recent articles</h3>
                    <p class="text-xs text-slate-500">Last 5 created or scheduled.</p>
                </div>
                <a href="{{ route('admin.news.index') }}" class="text-xs font-semibold text-brand-red-500 hover:text-brand-red-600">All news →</a>
            </div>
            @if ($recentNews->isEmpty())
                <div class="px-5 py-10 text-center text-sm text-slate-500">No articles yet.</div>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach ($recentNews as $article)
                        <li>
                            <a href="{{ route('admin.news.edit', $article) }}" class="flex items-start gap-3 px-5 py-3 transition hover:bg-slate-50">
                                @if ($article->imageUrl())
                                    <img src="{{ $article->imageUrl() }}" alt="" class="mt-0.5 h-10 w-14 shrink-0 rounded-md object-cover ring-1 ring-slate-200">
                                @else
                                    <div class="mt-0.5 grid h-10 w-14 shrink-0 place-items-center rounded-md bg-slate-100 text-[10px] text-slate-400">—</div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <div class="truncate text-sm font-semibold text-slate-900">{{ $article->title }}</div>
                                    <div class="mt-0.5 flex items-center gap-2 text-[11px] text-slate-500">
                                        @if (! $article->published_at)
                                            <span class="inline-flex rounded-full bg-slate-100 px-2 py-0.5 font-semibold uppercase tracking-wider text-slate-500">Draft</span>
                                        @elseif ($article->published_at->isFuture())
                                            <span class="inline-flex rounded-full bg-amber-50 px-2 py-0.5 font-semibold uppercase tracking-wider text-amber-600">Scheduled · {{ $article->published_at->format('M j') }}</span>
                                        @else
                                            <span class="inline-flex rounded-full bg-green-50 px-2 py-0.5 font-semibold uppercase tracking-wider text-green-600">Live · {{ $article->published_at->format('M j') }}</span>
                                        @endif
                                        @if ($article->category) · {{ $article->category }} @endif
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection

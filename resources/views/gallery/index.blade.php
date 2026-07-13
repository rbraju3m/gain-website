@extends('layouts.site')

@section('title', 'Gallery — ' . config('app.name'))

@php
    // Flat cross-year index so lightbox arrow-keys page across every image,
    // not just images within the current year.
    $lightboxItems = [];
    $indexByImageId = [];
    foreach ($years as $yr) {
        foreach ($yr->images as $img) {
            $url = $img->imageUrl();
            if (! $url) continue;
            $indexByImageId[$img->id] = count($lightboxItems);
            $lightboxItems[] = [
                'url'         => $url,
                'title'       => $img->title,
                'description' => $img->description ?: '',
                'year'        => (string) $yr->year,
            ];
        }
    }
@endphp

@section('content')

    @include('partials.page-hero', [
        'eyebrow'    => 'Moments From The Field',
        'title'      => 'Gallery',
        'accentText' => 'Gallery',
        'accent'     => 'green',
        'intro'      => 'A year-by-year look at our people, programmes and communities across Bangladesh.',
        'crumb'      => ['Home' => url('/'), 'Gallery' => null],
    ])

    <section class="bg-white pb-24 pt-12"
             x-data="{
                 items: {{ Illuminate\Support\Js::from($lightboxItems) }},
                 open: false,
                 index: 0,
                 swipeStartX: null,
                 get current() { return this.items[this.index] || { url: '', title: '', description: '', year: '' }; },
                 openAt(i) {
                     if (i < 0 || i >= this.items.length) return;
                     this.index = i;
                     this.open = true;
                     document.body.style.overflow = 'hidden';
                 },
                 close() { this.open = false; document.body.style.overflow = ''; },
                 next() { if (this.items.length) this.index = (this.index + 1) % this.items.length; },
                 prev() { if (this.items.length) this.index = (this.index - 1 + this.items.length) % this.items.length; },
             }"
             @keydown.escape.window="if (open) close()"
             @keydown.arrow-right.window="if (open) next()"
             @keydown.arrow-left.window="if (open) prev()">
        <div class="mx-auto max-w-7xl px-6 lg:px-10">

            @if ($years->isEmpty())
                <div class="mt-8 rounded-3xl border border-brand-green-200 bg-brand-cream/50 px-8 py-16 text-center">
                    <div class="mx-auto grid h-14 w-14 place-items-center rounded-full bg-brand-green-100 text-brand-green-600">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                            <path d="M4 4h16v16H4zM4 16l4-4 4 4 3-3 5 5"/>
                        </svg>
                    </div>
                    <h3 class="mt-4 font-display text-2xl font-semibold text-brand-ink">No photos yet</h3>
                    <p class="mt-2 text-brand-muted">The gallery will fill up as we publish photos from each year's work.</p>
                </div>
            @else
                {{-- Year quick-jump tabs --}}
                <div class="reveal mb-14 flex flex-wrap items-center justify-center gap-2">
                    @foreach ($years as $yr)
                        <a href="#year-{{ $yr->year }}"
                           class="rounded-full bg-brand-cream px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-brand-muted transition hover:bg-brand-red-100 hover:text-brand-red-500">
                            {{ $yr->year }}
                        </a>
                    @endforeach
                </div>

                @foreach ($years as $yr)
                    <section id="year-{{ $yr->year }}" class="mb-20 scroll-mt-28">
                        <div class="reveal mb-8 flex flex-col gap-2 border-l-4 border-brand-red-500 pl-5 sm:flex-row sm:items-end sm:justify-between sm:gap-6">
                            <div>
                                <div class="text-xs font-semibold uppercase tracking-[0.18em] text-brand-green-600">Year</div>
                                <h2 class="font-display text-5xl font-bold text-brand-ink sm:text-6xl">{{ $yr->year }}</h2>
                                @if ($yr->title)
                                    <p class="mt-1 font-display text-lg text-brand-ink/80">{{ $yr->title }}</p>
                                @endif
                            </div>
                            @if ($yr->description)
                                <p class="max-w-md text-sm text-brand-muted sm:text-right">{{ $yr->description }}</p>
                            @endif
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                            @foreach ($yr->images as $img)
                                @php $url = $img->imageUrl(); @endphp
                                @continue(! $url)
                                @php $gi = $indexByImageId[$img->id]; @endphp
                                <button type="button" @click="openAt({{ $gi }})"
                                        class="reveal group relative overflow-hidden rounded-2xl bg-slate-100 text-left shadow-card ring-1 ring-black/5 transition hover:-translate-y-0.5 hover:shadow-soft">
                                    <div class="aspect-[4/3] overflow-hidden">
                                        <img src="{{ $url }}" alt="{{ $img->title }}" loading="lazy"
                                             class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                    </div>
                                    <div class="pointer-events-none absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent p-4 opacity-0 transition group-hover:opacity-100">
                                        <div class="text-sm font-semibold text-white">{{ $img->title }}</div>
                                        @if ($img->description)
                                            <div class="mt-0.5 line-clamp-2 text-xs text-white/85">{{ $img->description }}</div>
                                        @endif
                                    </div>
                                    <span class="pointer-events-none absolute right-2 top-2 grid h-8 w-8 place-items-center rounded-full bg-white/85 text-brand-red-500 opacity-0 shadow-md backdrop-blur transition group-hover:opacity-100">
                                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                            <path fill-rule="evenodd" d="M9 3a6 6 0 1 0 3.85 10.6l3.28 3.27a1 1 0 0 0 1.4-1.4l-3.27-3.28A6 6 0 0 0 9 3Zm-4 6a4 4 0 1 1 8 0 4 4 0 0 1-8 0Zm3-1v-1a1 1 0 1 1 2 0v1h1a1 1 0 1 1 0 2H10v1a1 1 0 1 1-2 0v-1H7a1 1 0 1 1 0-2h1Z" clip-rule="evenodd"/>
                                        </svg>
                                    </span>
                                </button>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            @endif

        </div>

        {{-- ─────────────── Lightbox overlay ─────────────── --}}
        <div x-show="open" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[70] flex items-center justify-center bg-black/90 p-3 backdrop-blur sm:p-6"
             @click.self="close()"
             @touchstart="swipeStartX = $event.touches[0].clientX"
             @touchend="
                if (swipeStartX === null) return;
                const dx = $event.changedTouches[0].clientX - swipeStartX;
                if (dx >  60) prev();
                if (dx < -60) next();
                swipeStartX = null;
             ">

            {{-- Top bar: counter + close --}}
            <div class="absolute inset-x-0 top-0 z-10 flex items-center justify-between px-4 py-3 text-white sm:px-6">
                <div class="rounded-full bg-white/10 px-3 py-1 text-xs font-semibold tabular-nums backdrop-blur">
                    <span x-text="index + 1"></span> / <span x-text="items.length"></span>
                    <span class="mx-2 opacity-40">·</span>
                    <span x-text="current.year"></span>
                </div>
                <button type="button" @click="close()" aria-label="Close"
                        class="grid h-10 w-10 place-items-center rounded-full bg-white/10 text-white transition hover:bg-white/25">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M6.3 5.3a1 1 0 0 1 1.4 0L10 7.6l2.3-2.3a1 1 0 1 1 1.4 1.4L11.4 9l2.3 2.3a1 1 0 0 1-1.4 1.4L10 10.4l-2.3 2.3a1 1 0 0 1-1.4-1.4L8.6 9 6.3 6.7a1 1 0 0 1 0-1.4Z"/></svg>
                </button>
            </div>

            {{-- Prev / next arrows (hidden if only one image) --}}
            <template x-if="items.length > 1">
                <div>
                    <button type="button" @click.stop="prev()" aria-label="Previous image"
                            class="absolute left-2 top-1/2 z-10 grid h-11 w-11 -translate-y-1/2 place-items-center rounded-full bg-white/10 text-white shadow-lg backdrop-blur transition hover:bg-white/25 sm:left-6 sm:h-12 sm:w-12">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5"><path fill-rule="evenodd" d="M12.7 4.3a1 1 0 0 1 0 1.4L8.4 10l4.3 4.3a1 1 0 1 1-1.4 1.4l-5-5a1 1 0 0 1 0-1.4l5-5a1 1 0 0 1 1.4 0Z" clip-rule="evenodd"/></svg>
                    </button>
                    <button type="button" @click.stop="next()" aria-label="Next image"
                            class="absolute right-2 top-1/2 z-10 grid h-11 w-11 -translate-y-1/2 place-items-center rounded-full bg-white/10 text-white shadow-lg backdrop-blur transition hover:bg-white/25 sm:right-6 sm:h-12 sm:w-12">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5"><path fill-rule="evenodd" d="M7.3 4.3a1 1 0 0 1 1.4 0l5 5a1 1 0 0 1 0 1.4l-5 5a1 1 0 1 1-1.4-1.4L11.6 10 7.3 5.7a1 1 0 0 1 0-1.4Z" clip-rule="evenodd"/></svg>
                    </button>
                </div>
            </template>

            {{-- Image + caption card. Keyed on index so Alpine re-mounts the
                 <img> on nav, retriggering the fade-in transition. --}}
            <template x-if="open" :key="index">
                <div class="relative flex max-h-full w-full max-w-6xl flex-col items-center gap-4"
                     @click.stop>
                    <div class="flex w-full flex-1 items-center justify-center overflow-hidden">
                        <img :src="current.url" :alt="current.title"
                             class="max-h-[72vh] w-auto max-w-full rounded-xl object-contain shadow-2xl"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100">
                    </div>
                    <div class="w-full rounded-2xl bg-white/95 p-5 shadow-xl backdrop-blur sm:p-6"
                         x-transition:enter="transition ease-out duration-300 delay-100"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="text-xs font-semibold uppercase tracking-[0.18em] text-brand-green-600" x-text="current.year"></div>
                        <h3 class="mt-1 font-display text-xl font-bold text-brand-ink sm:text-2xl" x-text="current.title"></h3>
                        <p x-show="current.description" x-cloak class="mt-2 text-sm text-brand-muted" x-text="current.description"></p>
                    </div>
                </div>
            </template>
        </div>
    </section>
@endsection

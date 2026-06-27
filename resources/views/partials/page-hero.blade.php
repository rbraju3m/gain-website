{{-- Reusable editorial page header for /programmes, /news and detail pages.
     Props (via @include data): $eyebrow, $title, $accent, $intro, $crumb (array of name => url). --}}
@php
    $accent ??= 'red';
    $intro ??= null;
    $eyebrow ??= null;
    $crumb ??= [];
    $accentClass = ['red' => 'draw-underline-red text-brand-red-500',
                    'green' => 'draw-underline-green text-brand-green-600',
                    'orange' => 'draw-underline-orange text-brand-orange-500'][$accent] ?? 'draw-underline-red text-brand-red-500';
@endphp

<section class="relative -mt-[72px] overflow-hidden bg-hero-wash">
    <div class="blob-drift-a pointer-events-none absolute -top-32 -left-32 h-[460px] w-[460px] rounded-full bg-brand-red-100/60 blur-3xl"></div>
    <div class="blob-drift-b pointer-events-none absolute bottom-0 right-0 h-[420px] w-[420px] rounded-full bg-brand-green-100/70 blur-3xl"></div>

    <div class="relative mx-auto max-w-5xl px-6 pb-16 pt-32 text-center lg:px-10 lg:pt-40">

        @if (!empty($crumb))
            <nav class="reveal flex justify-center text-sm text-brand-muted">
                <ol class="flex flex-wrap items-center gap-1.5">
                    @foreach ($crumb as $label => $href)
                        @if ($href)
                            <li><a href="{{ $href }}" class="hover:text-brand-red-500">{{ $label }}</a></li>
                        @else
                            <li class="text-brand-ink">{{ $label }}</li>
                        @endif
                        @if (!$loop->last)
                            <li aria-hidden="true" class="text-brand-muted/60">/</li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        @endif

        @if ($eyebrow)
            <span class="reveal reveal-delay-100 mt-6 inline-flex items-center gap-2 rounded-full border border-brand-red-200 bg-white/80 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-brand-red-500">
                <span class="h-1.5 w-1.5 rounded-full bg-brand-red-500"></span>
                {{ $eyebrow }}
            </span>
        @endif

        <h1 class="reveal reveal-delay-100 mt-5 font-display text-4xl font-bold leading-tight text-brand-ink sm:text-5xl lg:text-6xl">
            {!! str_replace($accentText ?? '', '<span class="'.$accentClass.'">'.($accentText ?? '').'</span>', $title) !!}
        </h1>

        @if ($intro)
            <p class="reveal reveal-delay-200 mx-auto mt-5 max-w-2xl text-lg text-brand-muted">{{ $intro }}</p>
        @endif
    </div>

    <svg viewBox="0 0 1440 80" class="absolute inset-x-0 bottom-0 block w-full text-white" preserveAspectRatio="none" aria-hidden="true">
        <path fill="currentColor" d="M0,32 C240,80 480,0 720,32 C960,64 1200,16 1440,48 L1440,80 L0,80 Z"/>
    </svg>
</section>

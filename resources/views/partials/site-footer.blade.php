@php
    // Live programmes for the "Our Programmes" footer column (top 5 by sort).
    $footerProgrammes = \App\Models\Programme::published()->ordered()->take(5)->get(['title', 'slug']);
@endphp

<footer class="relative overflow-hidden bg-brand-red-700 text-white">
    {{-- Ambient orbs, very faint, behind the content --}}
    <div class="blob-drift-a pointer-events-none absolute -top-32 -left-32 h-[420px] w-[420px] rounded-full bg-brand-orange-500/15 blur-3xl"></div>
    <div class="blob-drift-b pointer-events-none absolute bottom-0 right-0 h-[420px] w-[420px] rounded-full bg-brand-green-500/15 blur-3xl"></div>

    <div class="relative mx-auto grid max-w-7xl gap-10 px-6 py-16 sm:grid-cols-2 lg:grid-cols-12 lg:px-10">

        {{-- Brand column --}}
        <div class="lg:col-span-4">
            <a href="{{ url('/') }}" class="inline-block" aria-label="{{ config('app.name') }} home">
                <img src="{{ asset('images/logo-gain.svg') }}" alt="GAIN" class="h-12 w-auto"
                     style="filter: brightness(0) invert(1);">
            </a>
            <p class="mt-4 max-w-sm text-sm leading-relaxed text-white/75">{{ setting('footer.tagline') }}</p>

            <div class="mt-6 flex items-center gap-2">
                @foreach ([
                    ['label' => 'Facebook',  'key' => 'facebook', 'path' => 'M22 12a10 10 0 1 0-11.6 9.9v-7H8v-3h2.4V9.5C10.4 7 11.9 6 14 6c.9 0 1.8.2 1.8.2v2h-1c-1 0-1.3.6-1.3 1.3V12H16l-.4 3H13.5v7A10 10 0 0 0 22 12Z'],
                    ['label' => 'Twitter',   'key' => 'twitter',  'path' => 'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24h-6.66l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231Zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77Z'],
                    ['label' => 'LinkedIn',  'key' => 'linkedin', 'path' => 'M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2ZM8.4 18H5.6V10h2.8v8ZM7 8.7a1.6 1.6 0 1 1 0-3.3 1.6 1.6 0 0 1 0 3.3ZM18.4 18h-2.8v-4.1c0-1-.4-1.6-1.3-1.6-.8 0-1.2.5-1.4 1.1V18h-2.8v-8h2.7v1.2a3 3 0 0 1 2.6-1.4c1.9 0 3 1.3 3 3.7V18Z'],
                ] as $s)
                    <a href="{{ setting('footer.social.'.$s['key'], '#') }}" aria-label="{{ $s['label'] }}"
                       class="grid h-9 w-9 place-items-center rounded-full bg-white/10 ring-1 ring-white/15 transition hover:-translate-y-0.5 hover:bg-white/20 hover:ring-white/40">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><path d="{{ $s['path'] }}"/></svg>
                    </a>
                @endforeach
            </div>

            <a href="{{ url('/#contact') }}"
               class="mt-7 inline-flex items-center gap-1.5 rounded-full border border-white/30 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-white transition hover:bg-white/10">
                Get Involved
                <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                    <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
                </svg>
            </a>
        </div>

        {{-- Explore --}}
        <div class="lg:col-span-2">
            <h4 class="text-xs font-semibold uppercase tracking-[0.18em] text-brand-orange-300">Explore</h4>
            <ul class="mt-5 space-y-2.5 text-sm text-white/75">
                <li><a href="{{ url('/#about') }}"            class="footer-link">About</a></li>
                <li><a href="{{ route('programmes.index') }}" class="footer-link">Programmes</a></li>
                <li><a href="{{ url('/#impact') }}"           class="footer-link">Impact</a></li>
                <li><a href="{{ url('/#stories') }}"          class="footer-link">Stories</a></li>
                <li><a href="{{ route('news.index') }}"       class="footer-link">News &amp; Events</a></li>
                <li><a href="{{ url('/#partners') }}"         class="footer-link">Partners</a></li>
            </ul>
        </div>

        {{-- Programmes (dynamic) --}}
        <div class="lg:col-span-3">
            <h4 class="text-xs font-semibold uppercase tracking-[0.18em] text-brand-orange-300">Our Programmes</h4>
            <ul class="mt-5 space-y-2.5 text-sm text-white/75">
                @forelse ($footerProgrammes as $p)
                    <li><a href="{{ route('programmes.show', $p) }}" class="footer-link">{{ $p->title }}</a></li>
                @empty
                    <li class="text-white/50 italic">Coming soon.</li>
                @endforelse
                @if ($footerProgrammes->count() >= 5)
                    <li class="pt-1"><a href="{{ route('programmes.index') }}" class="text-xs font-semibold uppercase tracking-wider text-brand-orange-300 hover:text-white">See all →</a></li>
                @endif
            </ul>
        </div>

        {{-- Contact --}}
        <div class="lg:col-span-3">
            <h4 class="text-xs font-semibold uppercase tracking-[0.18em] text-brand-orange-300">Contact Us</h4>
            <ul class="mt-5 space-y-4 text-sm text-white/75">
                @if ($address = setting('footer.address'))
                    <li class="flex items-start gap-3">
                        <span class="mt-0.5 grid h-7 w-7 shrink-0 place-items-center rounded-full bg-white/10 text-brand-orange-300">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                                <path d="M10 2a6 6 0 0 0-6 6c0 4.5 6 10 6 10s6-5.5 6-10a6 6 0 0 0-6-6Zm0 8.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
                            </svg>
                        </span>
                        <span class="leading-relaxed">{!! nl2br(e($address)) !!}</span>
                    </li>
                @endif
                @if ($phone = setting('footer.phone'))
                    <li class="flex items-center gap-3">
                        <span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-white/10 text-brand-orange-300">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                                <path d="M2 4.75A2.75 2.75 0 0 1 4.75 2h1.5c.41 0 .77.28.86.68l1 4a.9.9 0 0 1-.27.9l-1.7 1.4a14.2 14.2 0 0 0 5.9 5.9l1.4-1.7a.9.9 0 0 1 .9-.27l4 1c.4.1.68.45.68.86v1.5A2.75 2.75 0 0 1 15.25 18h-.5C7.7 18 2 12.3 2 5.25v-.5Z"/>
                            </svg>
                        </span>
                        <a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}" class="footer-link">{{ $phone }}</a>
                    </li>
                @endif
                @if ($email = setting('footer.email'))
                    <li class="flex items-center gap-3">
                        <span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-white/10 text-brand-orange-300">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                                <path d="M3 4a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H3Zm0 2 7 4 7-4v8H3V6Z"/>
                            </svg>
                        </span>
                        <a href="mailto:{{ $email }}" class="footer-link break-all">{{ $email }}</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="relative border-t border-white/10 bg-brand-red-800/40">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-6 py-5 text-xs text-white/60 lg:px-10">
            <p>© {{ date('Y') }} {{ setting('footer.copyright', 'Gain Foundation Bangladesh. All rights reserved.') }}</p>
            <div class="flex items-center gap-5">
                <a href="#" class="hover:text-white">Privacy Policy</a>
                <a href="#" class="hover:text-white">Terms of Service</a>
                <a href="#" class="hover:text-white">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>

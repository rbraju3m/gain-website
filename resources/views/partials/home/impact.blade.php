{{-- Section 2: Our Impact Across Bangladesh --}}
<section id="impact" class="relative overflow-hidden bg-section-white py-24">
    {{-- soft trailing wash from the hero --}}
    <div class="pointer-events-none absolute -top-32 left-1/2 h-[420px] w-[820px] -translate-x-1/2 rounded-full bg-brand-red-100/40 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-10">
        <h2 class="reveal text-center font-display text-4xl font-bold text-brand-red-500 sm:text-5xl">Our Impact Across Bangladesh</h2>
        <p class="reveal reveal-delay-100 mx-auto mt-4 max-w-2xl text-center text-brand-muted">Real numbers, real change. See how we're making a difference in communities nationwide.</p>

        @php
            $stats  = \App\Models\ImpactStat::forHomepage();
            $delays = ['', 'reveal-delay-100', 'reveal-delay-200', 'reveal-delay-300'];
            $bgPalette = [
                'red'    => 'bg-brand-red-100 text-brand-red-500',
                'green'  => 'bg-brand-green-100 text-brand-green-600',
                'orange' => 'bg-brand-orange-100 text-brand-orange-500',
            ];
            $textPalette = [
                'red'    => 'text-brand-red-500',
                'green'  => 'text-brand-green-500',
                'orange' => 'text-brand-orange-500',
            ];
        @endphp

        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($stats as $i => $card)
                <div class="reveal {{ $delays[$i % count($delays)] }} rounded-3xl bg-white p-8 text-center shadow-card ring-1 ring-black/5 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-soft">
                    @if ($svg = $card->iconSvg())
                        <span class="mx-auto grid h-14 w-14 place-items-center rounded-full {{ $bgPalette[$card->tone] ?? $bgPalette['red'] }}">
                            <svg viewBox="0 0 24 24" class="h-7 w-7">{!! $svg !!}</svg>
                        </span>
                    @endif
                    <div class="mt-5 font-display text-4xl font-bold {{ $textPalette[$card->tone] ?? $textPalette['red'] }}"
                         data-counter="{{ $card->counter }}"
                         data-counter-suffix="{{ $card->suffix }}">0{{ $card->suffix }}</div>
                    <div class="mt-2 text-sm font-medium text-brand-muted">{{ $card->label }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

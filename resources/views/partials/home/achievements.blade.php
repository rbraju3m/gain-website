{{-- Section 5: Our Achievements --}}
<section class="relative overflow-hidden bg-section-cream-alt py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">

        <div class="flex flex-col items-center text-center">
            <span class="reveal inline-flex items-center gap-2 rounded-full border border-brand-red-200 bg-white/80 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-brand-red-500">
                <span class="h-1.5 w-1.5 rounded-full bg-brand-red-500"></span>
                Measuring Success
            </span>
            <h2 class="reveal reveal-delay-100 mt-5 font-display text-4xl font-bold text-brand-ink sm:text-5xl">Our Achievements</h2>
            <p class="reveal reveal-delay-200 mt-4 max-w-2xl text-brand-muted">Transforming lives through evidence-based nutrition interventions.</p>
        </div>

        @php
            $achievements = \App\Models\Achievement::published()->ordered()->get();
            $delays = ['', 'reveal-delay-100', 'reveal-delay-200', 'reveal-delay-300'];
            $rowToneColor = [
                'red'    => 'text-brand-red-500',
                'green'  => 'text-brand-green-600',
                'orange' => 'text-brand-orange-500',
            ];
        @endphp

        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($achievements as $i => $card)
                <div class="reveal {{ $delays[$i % count($delays)] }} group rounded-3xl bg-white p-7 shadow-card ring-1 ring-black/5 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-soft">
                    @if ($svg = $card->iconSvg())
                        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-brand-red-100 text-brand-red-500 transition-transform duration-500 group-hover:scale-110 group-hover:rotate-3">
                            <svg viewBox="0 0 24 24" class="h-6 w-6">{!! $svg !!}</svg>
                        </span>
                    @endif
                    <h3 class="mt-5 text-lg font-bold text-brand-ink">{{ $card->title }}</h3>

                    @if ($card->visibleRows())
                        <dl class="mt-5 space-y-3 border-t border-brand-cream pt-4">
                            @foreach ($card->visibleRows() as $row)
                                <div class="flex items-center justify-between text-sm">
                                    <dt class="text-brand-muted">{{ $row['label'] }}</dt>
                                    <dd class="font-bold {{ $rowToneColor[$row['tone'] ?? 'red'] ?? $rowToneColor['red'] }}">{{ $row['value'] ?: '—' }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Section 5: Our Achievements --}}
<section class="bg-brand-cream py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">

        <div class="flex flex-col items-center text-center">
            <span class="inline-flex items-center gap-2 rounded-full border border-brand-red-200 bg-white/80 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-brand-red-500">
                <span class="h-1.5 w-1.5 rounded-full bg-brand-red-500"></span>
                Measuring Success
            </span>
            <h2 class="mt-5 font-display text-4xl font-bold text-brand-ink sm:text-5xl">Our Achievements</h2>
            <p class="mt-4 max-w-2xl text-brand-muted">Transforming lives through evidence-based nutrition interventions.</p>
        </div>

        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                [
                    'title' => 'Workers Empowered',
                    'icon'  => '<path d="M7 8a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm-4 9a4 4 0 0 1 8 0v1H3v-1Zm10 0a4 4 0 0 1 8 0v1h-8v-1Zm3-9a3 3 0 1 1 6 0 3 3 0 0 1-6 0Z"/>',
                    'rows'  => [
                        ['Total Reached',         '71,000+', 'red'],
                        ['Actively Participating','45,000+', 'green'],
                    ],
                ],
                [
                    'title' => 'Programme Components',
                    'icon'  => '<path d="M4 4h6v16H4zM14 4h6v8h-6zM14 14h6v6h-6z"/>',
                    'rows'  => [
                        ['TVET Education',  '400', 'red'],
                        ['IEC Courses',     '10',  'green'],
                        ['Fair Price Shops','12',  'orange'],
                    ],
                ],
                [
                    'title' => 'Factory Partnerships',
                    'icon'  => '<path d="M3 21V8l5 3V8l5 3V8l5 3v10H3Zm4-3h2v-3H7v3Zm5 0h2v-3h-2v3Zm5 0h2v-3h-2v3Z"/>',
                    'rows'  => [
                        ['On-Boarded',  '5',  'red'],
                        ['Surveyed',    '0',  'green'],
                        ['Target 2025', '13', 'orange'],
                    ],
                ],
                [
                    'title' => 'Impact Metrics',
                    'icon'  => '<path d="M3 17 9 11l4 4 8-8M14 7h7v7"/>',
                    'rows'  => [
                        ['Productivity Increased', '15%', 'red'],
                        ['Health Improvement',     '—',   'green'],
                        ['Income Increase',        '—',   'orange'],
                    ],
                ],
            ] as $card)
                <div class="rounded-3xl bg-white p-7 shadow-card ring-1 ring-black/5">
                    <span class="grid h-12 w-12 place-items-center rounded-2xl bg-brand-red-100 text-brand-red-500">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">{!! $card['icon'] !!}</svg>
                    </span>
                    <h3 class="mt-5 text-lg font-bold text-brand-ink">{{ $card['title'] }}</h3>

                    <dl class="mt-5 space-y-3 border-t border-brand-cream pt-4">
                        @foreach ($card['rows'] as [$label, $value, $tone])
                            @php
                                $valColor = [
                                    'red'    => 'text-brand-red-500',
                                    'green'  => 'text-brand-green-600',
                                    'orange' => 'text-brand-orange-500',
                                ][$tone];
                            @endphp
                            <div class="flex items-center justify-between text-sm">
                                <dt class="text-brand-muted">{{ $label }}</dt>
                                <dd class="font-bold {{ $valColor }}">{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            @endforeach
        </div>
    </div>
</section>

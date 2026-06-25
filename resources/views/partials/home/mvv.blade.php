{{-- Section 4: Mission / Vision / Values --}}
<section class="bg-section-cream pb-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        <div class="grid gap-6 md:grid-cols-3">
            @foreach ([
                [
                    'title' => 'Our Mission',
                    'tone'  => 'red',
                    'body'  => 'To eliminate malnutrition and ensure food security for all Bangladeshi families through sustainable, community-driven solutions.',
                    'icon'  => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="5" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="1.6" fill="currentColor"/>',
                ],
                [
                    'title' => 'Our Vision',
                    'tone'  => 'green',
                    'body'  => 'A Bangladesh where every family has access to nutritious food and the knowledge to maintain a healthy, sustainable lifestyle.',
                    'icon'  => '<path d="M1.5 12s4-7 10.5-7 10.5 7 10.5 7-4 7-10.5 7S1.5 12 1.5 12Z" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" fill="currentColor"/>',
                ],
                [
                    'title' => 'Our Values',
                    'tone'  => 'orange',
                    'body'  => 'Integrity, compassion, sustainability, innovation, and community empowerment guide everything we do.',
                    'icon'  => '<path d="M12 2 14 8h6l-5 4 2 7-7-4-7 4 2-7-5-4h6z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>',
                ],
            ] as $i => $card)
                @php $delays = ['', 'reveal-delay-100', 'reveal-delay-200']; @endphp
                @php
                    $iconBg = [
                        'red'    => 'bg-brand-red-100 text-brand-red-500',
                        'green'  => 'bg-brand-green-100 text-brand-green-600',
                        'orange' => 'bg-brand-orange-100 text-brand-orange-500',
                    ][$card['tone']];
                    $title = [
                        'red'    => 'text-brand-red-500',
                        'green'  => 'text-brand-green-600',
                        'orange' => 'text-brand-orange-500',
                    ][$card['tone']];
                @endphp
                <div class="reveal {{ $delays[$i] ?? '' }} group rounded-3xl bg-white p-8 shadow-card ring-1 ring-black/5 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-soft">
                    <span class="grid h-14 w-14 place-items-center rounded-2xl {{ $iconBg }} transition-transform duration-500 group-hover:scale-110 group-hover:rotate-3">
                        <svg viewBox="0 0 24 24" class="h-7 w-7">{!! $card['icon'] !!}</svg>
                    </span>
                    <h3 class="mt-6 font-display text-2xl font-bold {{ $title }}">{{ $card['title'] }}</h3>
                    <p class="mt-3 text-brand-muted">{{ $card['body'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

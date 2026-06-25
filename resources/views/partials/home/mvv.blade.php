{{-- Section 4: Mission / Vision / Values --}}
@php
    $mvvCards = \App\Models\MvvCard::forHomepage();
    $delays   = ['', 'reveal-delay-100', 'reveal-delay-200', 'reveal-delay-300'];
    $iconBgs  = [
        'red'    => 'bg-brand-red-100 text-brand-red-500',
        'green'  => 'bg-brand-green-100 text-brand-green-600',
        'orange' => 'bg-brand-orange-100 text-brand-orange-500',
    ];
    $titles   = [
        'red'    => 'text-brand-red-500',
        'green'  => 'text-brand-green-600',
        'orange' => 'text-brand-orange-500',
    ];
@endphp

<section class="bg-section-cream pb-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        <div class="grid gap-6 md:grid-cols-3">
            @foreach ($mvvCards as $i => $card)
                <div class="reveal {{ $delays[$i % count($delays)] }} group rounded-3xl bg-white p-8 shadow-card ring-1 ring-black/5 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-soft">
                    @if ($svg = $card->iconSvg())
                        <span class="grid h-14 w-14 place-items-center rounded-2xl {{ $iconBgs[$card->tone] ?? $iconBgs['red'] }} transition-transform duration-500 group-hover:scale-110 group-hover:rotate-3">
                            <svg viewBox="0 0 24 24" class="h-7 w-7">{!! $svg !!}</svg>
                        </span>
                    @endif
                    <h3 class="mt-6 font-display text-2xl font-bold {{ $titles[$card->tone] ?? $titles['red'] }}">{{ $card->title }}</h3>
                    @if ($card->body)
                        <p class="mt-3 text-brand-muted">{{ $card->body }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Section 2: Our Impact Across Bangladesh --}}
<section id="impact" class="bg-white py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">
        <h2 class="text-center font-display text-4xl font-bold text-brand-red-500 sm:text-5xl">Our Impact Across Bangladesh</h2>
        <p class="mx-auto mt-4 max-w-2xl text-center text-brand-muted">Real numbers, real change. See how we're making a difference in communities nationwide.</p>

        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['label' => 'Families Served',     'value' => '15,000+', 'color' => 'red',    'icon' => '<path d="M7 8a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm-4 9a4 4 0 0 1 8 0v1H3v-1Zm10 0a4 4 0 0 1 8 0v1h-8v-1Zm3-9a3 3 0 1 1 6 0 3 3 0 0 1-6 0Z"/>'],
                ['label' => 'Nutrition Programs', 'value' => '250+',    'color' => 'green',  'icon' => '<path d="M11 2a1 1 0 1 0-2 0v7H7V3a1 1 0 0 0-2 0v6.27A3 3 0 0 0 4 12v9a1 1 0 1 0 2 0v-7h2v7a1 1 0 1 0 2 0V12c0-.85-.4-1.62-1-2.12V2Zm6 0a1 1 0 0 0-1 1v10a3 3 0 0 0 2 2.83V21a1 1 0 1 0 2 0V3a1 1 0 0 0-3 0Z"/>'],
                ['label' => 'Districts Covered',  'value' => '52',      'color' => 'orange', 'icon' => '<path d="M12 2a7 7 0 0 0-7 7c0 5.5 7 13 7 13s7-7.5 7-13a7 7 0 0 0-7-7Zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>'],
                ['label' => 'Success Rate',       'value' => '98%',     'color' => 'red',    'icon' => '<path d="M12 2 4 6v6c0 5 3.5 9.74 8 10 4.5-.26 8-5 8-10V6l-8-4Zm-1 14-4-4 1.4-1.4L11 13.2l4.6-4.6L17 10l-6 6Z"/>'],
            ] as $card)
                @php
                    $bg = [
                        'red'    => 'bg-brand-red-100 text-brand-red-500',
                        'green'  => 'bg-brand-green-100 text-brand-green-600',
                        'orange' => 'bg-brand-orange-100 text-brand-orange-500',
                    ][$card['color']];
                    $text = [
                        'red'    => 'text-brand-red-500',
                        'green'  => 'text-brand-green-500',
                        'orange' => 'text-brand-orange-500',
                    ][$card['color']];
                @endphp
                <div class="rounded-3xl bg-white p-8 text-center shadow-card ring-1 ring-black/5 transition hover:-translate-y-1 hover:shadow-soft">
                    <span class="mx-auto grid h-14 w-14 place-items-center rounded-full {{ $bg }}">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-7 w-7">{!! $card['icon'] !!}</svg>
                    </span>
                    <div class="mt-5 font-display text-4xl font-bold {{ $text }}">{{ $card['value'] }}</div>
                    <div class="mt-2 text-sm font-medium text-brand-muted">{{ $card['label'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

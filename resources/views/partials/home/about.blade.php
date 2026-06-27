{{-- Section 3: Building a Healthier Bangladesh --}}
<section id="about" class="relative overflow-hidden bg-section-cream py-24">
    <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-6 lg:grid-cols-2 lg:gap-16 lg:px-10">

        <div class="reveal group relative">
            @php
                $aboutImg = setting('about.image_path')
                    ? asset('storage/' . setting('about.image_path'))
                    : asset('images/about-farming.jpg');
            @endphp
            <div class="img-zoom overflow-hidden rounded-[2rem] shadow-card">
                <img
                    src="{{ $aboutImg }}"
                    onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=900&q=80'"
                    alt="{{ setting('about.tagline', 'About') }}"
                    class="aspect-[4/3] w-full object-cover"
                >
            </div>
            <div class="absolute -bottom-6 right-6 rounded-2xl bg-white px-6 py-4 text-center shadow-card ring-1 ring-black/5 sm:right-10">
                @php
                    // Counter expects a numeric digit prefix in the value; extract.
                    $badgeRaw    = setting('about.years_badge_value', '10+');
                    $badgeDigits = preg_replace('/\D/', '', $badgeRaw) ?: '10';
                    $badgeSuffix = trim(preg_replace('/\d/', '', $badgeRaw)) ?: '+';
                @endphp
                <div class="font-display text-3xl font-bold text-brand-red-500"
                     data-counter="{{ $badgeDigits }}" data-counter-suffix="{{ $badgeSuffix }}">0{{ $badgeSuffix }}</div>
                <div class="text-xs text-brand-muted">{{ setting('about.years_badge_label', 'Years of Impact') }}</div>
            </div>
        </div>

        <div class="reveal reveal-delay-200">
            <span class="text-xs font-semibold uppercase tracking-[0.18em] text-brand-green-600">{{ setting('about.tagline', 'About Our Organization') }}</span>
            <h2 class="mt-3 font-display text-4xl font-bold leading-tight text-brand-ink sm:text-5xl">
                {{ setting('about.line1', 'Building a') }} <span class="text-brand-red-500">{{ setting('about.line1_accent', 'Healthier') }}</span><br>
                <span class="draw-underline-red text-brand-red-500">{{ setting('about.line2_accent', 'Bangladesh') }}</span> {{ setting('about.line2_suffix', 'Together') }}
            </h2>
            <p class="mt-5 text-brand-muted">{{ setting('about.paragraph_1') }}</p>
            <p class="mt-4 text-brand-muted">{{ setting('about.paragraph_2') }}</p>

            <dl class="mt-8 grid grid-cols-2 gap-x-8 gap-y-6">
                @foreach ([
                    ['label' => 'Families Impacted', 'counter' => 15000, 'suffix' => '+', 'tone' => 'red'],
                    ['label' => 'Districts Reached', 'counter' => 52,    'suffix' => '',  'tone' => 'green'],
                    ['label' => 'Active Programmes', 'counter' => 250,   'suffix' => '+', 'tone' => 'red'],
                    ['label' => 'Success Rate',      'counter' => 98,    'suffix' => '%', 'tone' => 'green'],
                ] as $stat)
                    <div>
                        <dd class="font-display text-3xl font-bold {{ $stat['tone'] === 'red' ? 'text-brand-red-500' : 'text-brand-green-600' }}"
                            data-counter="{{ $stat['counter'] }}"
                            data-counter-suffix="{{ $stat['suffix'] }}">0{{ $stat['suffix'] }}</dd>
                        <dt class="mt-1 text-sm text-brand-muted">{{ $stat['label'] }}</dt>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>
</section>

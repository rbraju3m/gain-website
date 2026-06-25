{{-- Section 3: Building a Healthier Bangladesh --}}
<section id="about" class="bg-brand-cream py-24">
    <div class="mx-auto grid max-w-7xl items-center gap-12 px-6 lg:grid-cols-2 lg:gap-16 lg:px-10">

        <div class="relative">
            <div class="overflow-hidden rounded-[2rem] shadow-card">
                <img
                    src="{{ asset('images/about-farming.jpg') }}"
                    onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=900&q=80'"
                    alt="Workers tending rice paddies"
                    class="aspect-[4/3] w-full object-cover"
                >
            </div>
            <div class="absolute -bottom-6 right-6 rounded-2xl bg-white px-6 py-4 text-center shadow-card ring-1 ring-black/5 sm:right-10">
                <div class="font-display text-3xl font-bold text-brand-red-500">10+</div>
                <div class="text-xs text-brand-muted">Years of Impact</div>
            </div>
        </div>

        <div>
            <span class="text-xs font-semibold uppercase tracking-[0.18em] text-brand-green-600">About Our Organization</span>
            <h2 class="mt-3 font-display text-4xl font-bold leading-tight text-brand-ink sm:text-5xl">
                Building a <span class="text-brand-red-500">Healthier</span><br>
                <span class="text-brand-red-500">Bangladesh</span> Together
            </h2>
            <p class="mt-5 text-brand-muted">
                Founded in 2014, we are a leading non-profit organization dedicated to
                transforming nutrition and food security across Bangladesh. Through innovative
                programmes, community partnerships, and evidence-based interventions, we
                empower families to achieve sustainable food security.
            </p>
            <p class="mt-4 text-brand-muted">
                Our holistic approach combines agricultural training, nutrition education, maternal
                and child health support, and policy advocacy to create lasting change at every
                level of society.
            </p>

            <dl class="mt-8 grid grid-cols-2 gap-x-8 gap-y-6">
                @foreach ([
                    ['label' => 'Families Impacted',  'value' => '15,000+', 'tone' => 'red'],
                    ['label' => 'Districts Reached',  'value' => '52',      'tone' => 'green'],
                    ['label' => 'Active Programmes', 'value' => '250+',    'tone' => 'red'],
                    ['label' => 'Success Rate',       'value' => '98%',     'tone' => 'green'],
                ] as $stat)
                    <div>
                        <dd class="font-display text-3xl font-bold {{ $stat['tone'] === 'red' ? 'text-brand-red-500' : 'text-brand-green-600' }}">{{ $stat['value'] }}</dd>
                        <dt class="mt-1 text-sm text-brand-muted">{{ $stat['label'] }}</dt>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>
</section>

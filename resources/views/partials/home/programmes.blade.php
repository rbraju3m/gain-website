{{-- Section 6: Our Programmes --}}
<section id="programmes" class="bg-white py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-10">

        <div class="text-center">
            <h2 class="font-display text-4xl font-bold text-brand-ink sm:text-5xl">
                Our <span class="text-brand-red-500">Programmes</span>
            </h2>
            <p class="mx-auto mt-4 max-w-2xl text-brand-muted">
                Comprehensive initiatives designed to create sustainable change in nutrition and food security.
            </p>
        </div>

        <div class="mt-14 grid gap-8 md:grid-cols-2">
            @foreach ([
                [
                    'category' => 'Agriculture',
                    'title'    => 'Community Nutrition Gardens',
                    'body'     => 'Empowering families to grow their own fresh, nutritious vegetables through sustainable agriculture training.',
                    'img'      => 'images/programme-gardens.jpg',
                    'fallback' => 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=900&q=80',
                ],
                [
                    'category' => 'Healthcare',
                    'title'    => 'Maternal & Child Nutrition',
                    'body'     => 'Supporting mothers and children with essential nutrition education, supplements, and healthcare services.',
                    'img'      => 'images/programme-maternal.jpg',
                    'fallback' => 'https://images.unsplash.com/photo-1490818387583-1baba5e638af?w=900&q=80',
                ],
                [
                    'category' => 'Education',
                    'title'    => 'Farmer Training & Livelihood',
                    'body'     => 'Hands-on training in modern, climate-smart farming techniques to boost yield, income, and food security.',
                    'img'      => 'images/programme-farmer.jpg',
                    'fallback' => 'https://images.unsplash.com/photo-1500076656116-558758c991c1?w=900&q=80',
                ],
                [
                    'category' => 'Outreach',
                    'title'    => 'Nutrition Education & Awareness',
                    'body'     => 'Community workshops on balanced diets, hygiene, and child nutrition reaching tens of thousands of households.',
                    'img'      => 'images/programme-education.jpg',
                    'fallback' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=900&q=80',
                ],
            ] as $card)
                <article class="overflow-hidden rounded-3xl bg-white shadow-card ring-1 ring-black/5 transition hover:-translate-y-1 hover:shadow-soft">
                    <div class="relative">
                        <img src="{{ asset($card['img']) }}"
                             onerror="this.onerror=null; this.src='{{ $card['fallback'] }}'"
                             alt="{{ $card['title'] }}"
                             class="aspect-[16/9] w-full object-cover">
                        <span class="absolute left-4 top-4 inline-flex items-center gap-1.5 rounded-full bg-brand-red-500 px-3 py-1 text-xs font-semibold text-white shadow-sm">
                            <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                            {{ $card['category'] }}
                        </span>
                    </div>
                    <div class="p-7">
                        <h3 class="font-display text-2xl font-bold text-brand-red-500">{{ $card['title'] }}</h3>
                        <p class="mt-3 text-brand-muted">{{ $card['body'] }}</p>
                        <a href="#" class="mt-5 inline-flex items-center gap-1.5 rounded-full bg-brand-cream px-5 py-2 text-sm font-semibold text-brand-red-500 hover:bg-brand-red-100">
                            Learn More
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

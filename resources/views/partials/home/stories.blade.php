{{-- Section 7: Stories of Hope & Change --}}
<section id="stories" class="relative overflow-hidden bg-cta-burgundy py-24 text-white">
    <div class="pointer-events-none absolute -top-32 left-1/3 h-[420px] w-[420px] rounded-full bg-brand-orange-500/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-32 right-0 h-[380px] w-[380px] rounded-full bg-brand-green-500/15 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-10">
        <div class="text-center">
            <h2 class="reveal font-display text-4xl font-bold sm:text-5xl">
                Stories of <span class="text-brand-orange-300">Hope &amp; Change</span>
            </h2>
            <p class="reveal reveal-delay-100 mx-auto mt-4 max-w-2xl text-white/70">Real voices from the communities we serve across Bangladesh.</p>
        </div>

        <div class="mt-14 grid gap-6 md:grid-cols-2">
            @foreach ([
                [
                    'quote'   => 'This program transformed our family\'s life. Now we grow our own vegetables and my children are healthier than ever. The training we received gave us hope and a sustainable future.',
                    'name'    => 'Amina Rahman',
                    'role'    => 'Programme Participant, Dhaka Division',
                    'photo'   => 'https://i.pravatar.cc/120?img=47',
                ],
                [
                    'quote'   => 'The agricultural training helped me improve crop yields by 60%. I can now support my family better and contribute to our community\'s food security. Thank you for believing in us.',
                    'name'    => 'Karim Ahmed',
                    'role'    => 'Farmer, Chittagong Division',
                    'photo'   => 'https://i.pravatar.cc/120?img=68',
                ],
            ] as $i => $story)
                @php $delays = ['', 'reveal-delay-100']; @endphp
                <figure class="reveal {{ $delays[$i] ?? '' }} group rounded-3xl bg-white/10 p-8 backdrop-blur-sm ring-1 ring-white/15 transition-all duration-300 hover:-translate-y-1 hover:bg-white/15">
                    <svg viewBox="0 0 24 24" fill="currentColor" class="h-8 w-8 text-brand-orange-300">
                        <path d="M7 7h4v4H8c0 2 1 3 3 4v3c-4-1-7-3-7-7V7Zm9 0h4v4h-3c0 2 1 3 3 4v3c-4-1-7-3-7-7V7Z"/>
                    </svg>
                    <blockquote class="mt-5 text-lg leading-relaxed text-white/90">{{ $story['quote'] }}</blockquote>
                    <figcaption class="mt-6 flex items-center gap-4">
                        <img src="{{ $story['photo'] }}" alt="{{ $story['name'] }}" class="h-12 w-12 rounded-full object-cover ring-2 ring-white/30">
                        <div>
                            <div class="font-semibold">{{ $story['name'] }}</div>
                            <div class="text-sm text-white/60">{{ $story['role'] }}</div>
                        </div>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>

    {{-- Divider: burgundy → cream (into Map) --}}
    <svg viewBox="0 0 1440 90" class="relative mt-16 block w-full text-[#FAF1ED]" preserveAspectRatio="none" aria-hidden="true">
        <path fill="currentColor" d="M0,60 C360,10 720,80 1080,40 C1260,20 1380,30 1440,55 L1440,90 L0,90 Z"/>
    </svg>
</section>

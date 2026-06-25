{{-- Section 11 (top half): Donation CTA --}}
<section class="relative overflow-hidden bg-cta-burgundy py-20 text-white">
    <div class="pointer-events-none absolute -top-32 left-1/4 h-[480px] w-[480px] rounded-full bg-brand-green-500/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-32 right-0 h-[420px] w-[420px] rounded-full bg-brand-orange-500/20 blur-3xl"></div>

    <div class="relative mx-auto max-w-5xl px-6 text-center lg:px-10">
        <span class="reveal mx-auto grid h-14 w-14 place-items-center rounded-full bg-white/15 backdrop-blur">
            <svg viewBox="0 0 24 24" fill="currentColor" class="heartbeat h-7 w-7 text-white">
                <path d="M12 21s-7-4.5-9.5-9C1 9 2.5 5 6 5c2 0 3.5 1 4.5 2.5C11.5 6 13 5 15 5c3.5 0 5 4 3.5 7-2.5 4.5-9.5 9-9.5 9Z"/>
            </svg>
        </span>

        <h2 class="reveal reveal-delay-100 mt-6 font-display text-4xl font-bold leading-tight sm:text-5xl">
            Join Us in Creating Lasting<br>Change
        </h2>
        <p class="reveal reveal-delay-200 mx-auto mt-4 max-w-2xl text-white/80">
            Every contribution helps us reach more families, train more farmers, and build stronger,
            healthier communities across Bangladesh.
        </p>

        <div class="reveal reveal-delay-300 mt-8 flex flex-wrap items-center justify-center gap-3">
            <a href="#partner"
               class="group inline-flex items-center gap-2 rounded-full border border-white/40 bg-white/10 px-6 py-3 text-sm font-semibold text-white backdrop-blur transition hover:bg-white/20">
                Become a Partner
                <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 transition-transform group-hover:translate-x-1">
                    <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
                </svg>
            </a>
        </div>

        {{-- Donation tiers --}}
        <div class="mt-14 grid gap-6 sm:grid-cols-3">
            @foreach ([
                ['amount' => '$50',  'desc' => 'Feeds a family for a month',           'tone' => 'red'],
                ['amount' => '$200', 'desc' => 'Trains a farmer',                       'tone' => 'green'],
                ['amount' => '$500', 'desc' => 'Establishes a community garden',        'tone' => 'orange'],
            ] as $i => $tier)
                @php $delays = ['reveal-delay-100', 'reveal-delay-200', 'reveal-delay-300']; @endphp
                @php
                    $color = [
                        'red'    => 'text-brand-orange-300',
                        'green'  => 'text-brand-green-300',
                        'orange' => 'text-brand-orange-300',
                    ][$tier['tone']];
                @endphp
                <div class="reveal {{ $delays[$i] }} rounded-2xl bg-white/10 px-6 py-7 backdrop-blur-sm ring-1 ring-white/15 transition hover:-translate-y-1 hover:bg-white/15">
                    <div class="font-display text-3xl font-bold {{ $color }}">{{ $tier['amount'] }}</div>
                    <div class="mt-2 text-sm text-white/80">{{ $tier['desc'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

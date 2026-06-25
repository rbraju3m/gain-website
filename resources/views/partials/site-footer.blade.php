<footer class="bg-brand-red-700 text-white">
    <div class="mx-auto grid max-w-7xl gap-10 px-6 py-16 sm:grid-cols-2 lg:grid-cols-4 lg:px-10">

        <div>
            <a href="{{ url('/') }}" class="inline-block" aria-label="{{ config('app.name') }} home">
                {{-- brightness(0) invert(1) recolors the deep-red logo to pure white for the dark footer --}}
                <img src="{{ asset('images/logo-gain.svg') }}" alt="GAIN" class="h-12 w-auto"
                     style="filter: brightness(0) invert(1);">
            </a>
            <p class="mt-4 text-sm text-white/70">{{ setting('footer.tagline') }}</p>
            <div class="mt-6 flex items-center gap-3">
                @foreach ([
                    ['label' => 'Facebook',  'key' => 'facebook', 'path' => 'M22 12a10 10 0 1 0-11.6 9.9v-7H8v-3h2.4V9.5C10.4 7 11.9 6 14 6c.9 0 1.8.2 1.8.2v2h-1c-1 0-1.3.6-1.3 1.3V12H16l-.4 3H13.5v7A10 10 0 0 0 22 12Z'],
                    ['label' => 'Twitter',   'key' => 'twitter',  'path' => 'M22 5.8c-.7.3-1.5.5-2.4.6.9-.5 1.5-1.3 1.8-2.2-.8.5-1.7.8-2.6 1A4.1 4.1 0 0 0 12 9c0 .3 0 .6.1.9-3.4-.2-6.4-1.8-8.4-4.3-.4.6-.6 1.3-.6 2.1 0 1.5.7 2.7 1.8 3.5-.7 0-1.3-.2-1.9-.5v.1c0 2 1.4 3.6 3.3 4-.4.1-.7.2-1.1.2-.3 0-.5 0-.8-.1.5 1.7 2 2.9 3.8 2.9A8.2 8.2 0 0 1 2 19.6 11.6 11.6 0 0 0 8.3 21c7.6 0 11.7-6.3 11.7-11.7v-.5c.8-.6 1.5-1.3 2-2Z'],
                    ['label' => 'LinkedIn',  'key' => 'linkedin', 'path' => 'M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2ZM8.4 18H5.6V10h2.8v8ZM7 8.7a1.6 1.6 0 1 1 0-3.3 1.6 1.6 0 0 1 0 3.3ZM18.4 18h-2.8v-4.1c0-1-.4-1.6-1.3-1.6-.8 0-1.2.5-1.4 1.1V18h-2.8v-8h2.7v1.2a3 3 0 0 1 2.6-1.4c1.9 0 3 1.3 3 3.7V18Z'],
                ] as $s)
                    <a href="{{ setting('footer.social.'.$s['key'], '#') }}" aria-label="{{ $s['label'] }}" class="grid h-9 w-9 place-items-center rounded-full bg-white/10 transition hover:bg-white/20">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                            <path d="{{ $s['path'] }}"/>
                        </svg>
                    </a>
                @endforeach
            </div>
        </div>

        <div>
            <h4 class="text-sm font-semibold uppercase tracking-wider text-white/90">Quick Links</h4>
            <ul class="mt-4 space-y-2 text-sm text-white/70">
                <li><a href="#about"     class="hover:text-white">About Us</a></li>
                <li><a href="#programmes" class="hover:text-white">Our Programmes</a></li>
                <li><a href="#impact"    class="hover:text-white">Get Involved</a></li>
                <li><a href="#news"      class="hover:text-white">News & Events</a></li>
                <li><a href="#stories"   class="hover:text-white">Annual Reports</a></li>
            </ul>
        </div>

        <div>
            <h4 class="text-sm font-semibold uppercase tracking-wider text-white/90">Our Programmes</h4>
            <ul class="mt-4 space-y-2 text-sm text-white/70">
                <li><a href="#" class="hover:text-white">Community Gardens</a></li>
                <li><a href="#" class="hover:text-white">Maternal Health</a></li>
                <li><a href="#" class="hover:text-white">Farmer Training</a></li>
                <li><a href="#" class="hover:text-white">Nutrition Education</a></li>
                <li><a href="#" class="hover:text-white">Research & Advocacy</a></li>
            </ul>
        </div>

        <div>
            <h4 class="text-sm font-semibold uppercase tracking-wider text-white/90">Contact Us</h4>
            <ul class="mt-4 space-y-3 text-sm text-white/70">
                <li class="flex items-start gap-2">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="mt-0.5 h-4 w-4 shrink-0 text-brand-orange-300">
                        <path d="M10 2a6 6 0 0 0-6 6c0 4.5 6 10 6 10s6-5.5 6-10a6 6 0 0 0-6-6Zm0 8.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
                    </svg>
                    <span>{!! nl2br(e(setting('footer.address'))) !!}</span>
                </li>
                <li class="flex items-center gap-2">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 shrink-0 text-brand-orange-300">
                        <path d="M2 4.75A2.75 2.75 0 0 1 4.75 2h1.5c.41 0 .77.28.86.68l1 4a.9.9 0 0 1-.27.9l-1.7 1.4a14.2 14.2 0 0 0 5.9 5.9l1.4-1.7a.9.9 0 0 1 .9-.27l4 1c.4.1.68.45.68.86v1.5A2.75 2.75 0 0 1 15.25 18h-.5C7.7 18 2 12.3 2 5.25v-.5Z"/>
                    </svg>
                    <a href="tel:{{ preg_replace('/[^\d+]/', '', setting('footer.phone', '')) }}" class="hover:text-white">{{ setting('footer.phone') }}</a>
                </li>
                <li class="flex items-center gap-2">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 shrink-0 text-brand-orange-300">
                        <path d="M3 4a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H3Zm0 2 7 4 7-4v8H3V6Z"/>
                    </svg>
                    <a href="mailto:{{ setting('footer.email') }}" class="hover:text-white">{{ setting('footer.email') }}</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/10 bg-brand-red-800/30">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-6 py-5 text-xs text-white/60 lg:px-10">
            <p>© {{ date('Y') }} {{ setting('footer.copyright', 'Gain Foundation Bangladesh. All rights reserved.') }}</p>
            <div class="flex items-center gap-5">
                <a href="#" class="hover:text-white">Privacy Policy</a>
                <a href="#" class="hover:text-white">Terms of Service</a>
                <a href="#" class="hover:text-white">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>

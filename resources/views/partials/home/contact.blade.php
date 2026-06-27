{{-- Section: Contact — public form + reused footer contact info --}}
<section id="contact" class="relative overflow-hidden bg-section-cream-alt py-24">
    <div class="pointer-events-none absolute -top-32 left-1/4 h-[420px] w-[420px] rounded-full bg-brand-green-100/60 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-32 right-1/4 h-[420px] w-[420px] rounded-full bg-brand-orange-100/50 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-10">

        <div class="text-center">
            <span class="reveal inline-flex items-center gap-2 rounded-full border border-brand-red-200 bg-white/80 px-4 py-1.5 text-xs font-semibold uppercase tracking-wider text-brand-red-500">
                <span class="h-1.5 w-1.5 rounded-full bg-brand-red-500"></span>
                Get In Touch
            </span>
            <h2 class="reveal reveal-delay-100 mt-5 font-display text-4xl font-bold text-brand-ink sm:text-5xl">
                Let's Build a Healthier <span class="draw-underline-green text-brand-green-600">Bangladesh</span>
            </h2>
            <p class="reveal reveal-delay-200 mx-auto mt-4 max-w-2xl text-brand-muted">
                Have a question, partnership idea, or want to volunteer? Send us a note and we'll get back to you.
            </p>
        </div>

        <div class="mt-14 grid items-start gap-8 lg:grid-cols-5">

            {{-- Contact details (2 of 5 cols) --}}
            <aside class="reveal lg:col-span-2">
                <div class="card-hover rounded-3xl bg-white p-8 shadow-card ring-1 ring-black/5">
                    <h3 class="font-display text-2xl font-bold text-brand-red-500">Reach us</h3>
                    <p class="mt-2 text-sm text-brand-muted">We typically respond within two working days.</p>

                    <ul class="mt-7 space-y-5 text-sm">
                        @if ($address = setting('footer.address'))
                            <li class="flex items-start gap-3">
                                <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-brand-red-100 text-brand-red-500">
                                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                        <path d="M10 2a6 6 0 0 0-6 6c0 4.5 6 10 6 10s6-5.5 6-10a6 6 0 0 0-6-6Zm0 8.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
                                    </svg>
                                </span>
                                <div>
                                    <div class="text-xs uppercase tracking-wider text-brand-muted">Address</div>
                                    <div class="mt-1 leading-relaxed text-brand-ink">{!! nl2br(e($address)) !!}</div>
                                </div>
                            </li>
                        @endif

                        @if ($phone = setting('footer.phone'))
                            <li class="flex items-start gap-3">
                                <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-brand-green-100 text-brand-green-600">
                                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                        <path d="M2 4.75A2.75 2.75 0 0 1 4.75 2h1.5c.41 0 .77.28.86.68l1 4a.9.9 0 0 1-.27.9l-1.7 1.4a14.2 14.2 0 0 0 5.9 5.9l1.4-1.7a.9.9 0 0 1 .9-.27l4 1c.4.1.68.45.68.86v1.5A2.75 2.75 0 0 1 15.25 18h-.5C7.7 18 2 12.3 2 5.25v-.5Z"/>
                                    </svg>
                                </span>
                                <div>
                                    <div class="text-xs uppercase tracking-wider text-brand-muted">Phone</div>
                                    <a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}" class="mt-1 block font-semibold text-brand-ink hover:text-brand-red-500">{{ $phone }}</a>
                                </div>
                            </li>
                        @endif

                        @if ($email = setting('footer.email'))
                            <li class="flex items-start gap-3">
                                <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-brand-orange-100 text-brand-orange-500">
                                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                        <path d="M3 4a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H3Zm0 2 7 4 7-4v8H3V6Z"/>
                                    </svg>
                                </span>
                                <div>
                                    <div class="text-xs uppercase tracking-wider text-brand-muted">Email</div>
                                    <a href="mailto:{{ $email }}" class="mt-1 block font-semibold text-brand-ink hover:text-brand-red-500">{{ $email }}</a>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </aside>

            {{-- Form (3 of 5 cols) --}}
            <div class="reveal reveal-delay-100 lg:col-span-3">
                <div class="card-hover rounded-3xl bg-white p-8 shadow-card ring-1 ring-black/5 sm:p-10">

                    @if (session('contact_success'))
                        <div class="mb-6 rounded-2xl border border-brand-green-200 bg-brand-green-50 px-5 py-4 text-sm font-medium text-brand-green-700">
                            {{ session('contact_success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 rounded-2xl border border-brand-red-200 bg-brand-red-50 px-5 py-4 text-sm text-brand-red-700">
                            <strong>Please fix the following:</strong>
                            <ul class="ml-4 mt-1 list-disc">
                                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="contact-name" class="block text-xs font-semibold uppercase tracking-wider text-brand-muted">Your name</label>
                                <input id="contact-name" name="name" type="text" required maxlength="120"
                                    value="{{ old('name') }}"
                                    class="mt-2 w-full rounded-xl border border-brand-ink/10 bg-white px-4 py-3 text-sm text-brand-ink placeholder-brand-muted/60 transition focus:border-brand-red-300 focus:outline-none focus:ring-2 focus:ring-brand-red-200">
                            </div>
                            <div>
                                <label for="contact-email" class="block text-xs font-semibold uppercase tracking-wider text-brand-muted">Email</label>
                                <input id="contact-email" name="email" type="email" required maxlength="160"
                                    value="{{ old('email') }}"
                                    class="mt-2 w-full rounded-xl border border-brand-ink/10 bg-white px-4 py-3 text-sm text-brand-ink placeholder-brand-muted/60 transition focus:border-brand-red-300 focus:outline-none focus:ring-2 focus:ring-brand-red-200">
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="contact-phone" class="block text-xs font-semibold uppercase tracking-wider text-brand-muted">Phone <span class="font-normal normal-case text-brand-muted/70">(optional)</span></label>
                                <input id="contact-phone" name="phone" type="tel" maxlength="40"
                                    value="{{ old('phone') }}"
                                    class="mt-2 w-full rounded-xl border border-brand-ink/10 bg-white px-4 py-3 text-sm text-brand-ink placeholder-brand-muted/60 transition focus:border-brand-red-300 focus:outline-none focus:ring-2 focus:ring-brand-red-200">
                            </div>
                            <div>
                                <label for="contact-subject" class="block text-xs font-semibold uppercase tracking-wider text-brand-muted">Subject <span class="font-normal normal-case text-brand-muted/70">(optional)</span></label>
                                <input id="contact-subject" name="subject" type="text" maxlength="160"
                                    value="{{ old('subject') }}"
                                    class="mt-2 w-full rounded-xl border border-brand-ink/10 bg-white px-4 py-3 text-sm text-brand-ink placeholder-brand-muted/60 transition focus:border-brand-red-300 focus:outline-none focus:ring-2 focus:ring-brand-red-200">
                            </div>
                        </div>

                        <div>
                            <label for="contact-message" class="block text-xs font-semibold uppercase tracking-wider text-brand-muted">Message</label>
                            <textarea id="contact-message" name="message" rows="5" required minlength="10" maxlength="3000"
                                class="mt-2 w-full rounded-xl border border-brand-ink/10 bg-white px-4 py-3 text-sm text-brand-ink placeholder-brand-muted/60 transition focus:border-brand-red-300 focus:outline-none focus:ring-2 focus:ring-brand-red-200">{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="btn-shimmer inline-flex items-center gap-2 rounded-full bg-brand-red-500 px-7 py-3.5 text-sm font-semibold text-white shadow-pill transition hover:bg-brand-red-600">
                            <span class="inline-flex items-center gap-2">
                                Send message
                                <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                    <path d="M3.4 2.6a1 1 0 0 1 1.1-.2l14 6a1 1 0 0 1 0 1.8l-14 6a1 1 0 0 1-1.4-1.1L4.7 11H10a1 1 0 1 0 0-2H4.7L3.1 4a1 1 0 0 1 .3-1.4Z"/>
                                </svg>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Forgot password · {{ config('app.name') }}</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-gain.svg') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&family=fraunces:400,700,900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-cream font-sans text-brand-ink antialiased">

<div class="grid min-h-screen lg:grid-cols-2">

    <aside class="relative hidden overflow-hidden bg-cta-burgundy text-white lg:flex lg:flex-col">
        <div class="blob-drift-a pointer-events-none absolute -top-32 -left-32 h-[460px] w-[460px] rounded-full bg-brand-orange-500/30 blur-3xl"></div>
        <div class="blob-drift-b pointer-events-none absolute bottom-0 right-0 h-[420px] w-[420px] rounded-full bg-brand-green-500/25 blur-3xl"></div>

        <div class="relative flex flex-1 flex-col justify-between p-12">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2" aria-label="{{ config('app.name') }} home">
                <img src="{{ asset('images/logo-gain.svg') }}" alt="GAIN" class="h-10 w-auto" style="filter: brightness(0) invert(1);">
                <span class="text-xs font-semibold uppercase tracking-[0.18em] text-white/70">Admin</span>
            </a>

            <div class="max-w-md">
                <span class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-brand-orange-300 backdrop-blur">
                    <span class="h-1.5 w-1.5 rounded-full bg-brand-orange-300"></span>
                    Reset access
                </span>
                <h1 class="mt-6 font-display text-4xl font-bold leading-tight sm:text-5xl">
                    Lost your way?<br>
                    <span class="text-brand-orange-300">We'll send a link.</span>
                </h1>
                <p class="mt-5 text-white/70">
                    Enter the email you sign in with and we'll send you a one-time link to set a new password.
                </p>
            </div>

            <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-sm text-white/60 hover:text-white">
                <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M17 10a.75.75 0 0 1-.75.75H5.6l4.18 3.96a.75.75 0 1 1-1.08 1.04l-5.5-5.75a.75.75 0 0 1 0-1.04l5.5-5.75a.75.75 0 1 1 1.08 1.04L5.6 9.25h10.65A.75.75 0 0 1 17 10Z"/></svg>
                Back to sign in
            </a>
        </div>
    </aside>

    <main class="flex flex-col items-center justify-center px-6 py-12 sm:px-12 lg:px-16">

        <a href="{{ url('/') }}" class="mb-8 inline-flex items-center gap-2 lg:hidden" aria-label="{{ config('app.name') }} home">
            <img src="{{ asset('images/logo-gain.svg') }}" alt="GAIN" class="h-10 w-auto">
            <span class="text-xs font-semibold uppercase tracking-[0.18em] text-brand-muted">Admin</span>
        </a>

        <div class="w-full max-w-md">
            <h2 class="font-display text-3xl font-bold text-brand-ink sm:text-4xl">Forgot password?</h2>
            <p class="mt-2 text-brand-muted">No problem — tell us your email and we'll mail a reset link.</p>

            @if (session('status'))
                <div class="mt-6 rounded-2xl border border-brand-green-200 bg-brand-green-50 px-4 py-3 text-sm font-medium text-brand-green-700">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-6 rounded-2xl border border-brand-red-200 bg-brand-red-50 px-4 py-3 text-sm text-brand-red-600">
                    @foreach ($errors->all() as $error) <div>{{ $error }}</div> @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="mt-8 space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-[0.18em] text-brand-muted">Email</label>
                    <div class="relative mt-2">
                        <span class="pointer-events-none absolute inset-y-0 left-0 grid w-10 place-items-center text-brand-muted/70">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M3 4a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H3Zm0 2 7 4 7-4v8H3V6Z"/></svg>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               required autofocus
                               placeholder="you@example.org"
                               class="w-full rounded-xl border border-brand-ink/10 bg-white py-3 pl-10 pr-3 text-sm text-brand-ink placeholder-brand-muted/60 shadow-sm transition focus:border-brand-red-300 focus:outline-none focus:ring-2 focus:ring-brand-red-200">
                    </div>
                </div>

                <button type="submit"
                        class="btn-shimmer inline-flex w-full items-center justify-center gap-2 rounded-full bg-brand-red-500 px-5 py-3 text-sm font-semibold text-white shadow-pill transition hover:bg-brand-red-600">
                    <span class="inline-flex items-center gap-2">
                        Email reset link
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M3.4 2.6a1 1 0 0 1 1.1-.2l14 6a1 1 0 0 1 0 1.8l-14 6a1 1 0 0 1-1.4-1.1L4.7 11H10a1 1 0 1 0 0-2H4.7L3.1 4a1 1 0 0 1 .3-1.4Z"/></svg>
                    </span>
                </button>
            </form>

            <p class="mt-8 text-center text-xs text-brand-muted">
                Remembered it? <a href="{{ route('login') }}" class="font-semibold text-brand-red-500 hover:text-brand-red-600">Sign in</a>.
            </p>
        </div>
    </main>
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sign in · {{ config('app.name') }}</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-gain.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&family=fraunces:400,700,900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-brand-cream font-sans text-brand-ink antialiased">

<div class="grid min-h-screen lg:grid-cols-2">

    {{-- LEFT: branded marketing panel (desktop only) --}}
    <aside class="relative hidden overflow-hidden bg-cta-burgundy text-white lg:flex lg:flex-col">
        <div class="blob-drift-a pointer-events-none absolute -top-32 -left-32 h-[460px] w-[460px] rounded-full bg-brand-orange-500/30 blur-3xl"></div>
        <div class="blob-drift-b pointer-events-none absolute bottom-0 right-0 h-[420px] w-[420px] rounded-full bg-brand-green-500/25 blur-3xl"></div>

        <div class="relative flex flex-1 flex-col justify-between p-12">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2" aria-label="{{ config('app.name') }} home">
                <img src="{{ asset('images/logo-gain.svg') }}" alt="GAIN"
                     class="h-10 w-auto" style="filter: brightness(0) invert(1);">
                <span class="text-xs font-semibold uppercase tracking-[0.18em] text-white/70">Admin</span>
            </a>

            <div class="max-w-md">
                <span class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-brand-orange-300 backdrop-blur">
                    <span class="h-1.5 w-1.5 rounded-full bg-brand-orange-300"></span>
                    Welcome back
                </span>
                <h1 class="mt-6 font-display text-4xl font-bold leading-tight sm:text-5xl">
                    Nourishing <span class="text-brand-orange-300">Communities</span>,<br>
                    Building <span class="text-brand-green-300">Futures</span>.
                </h1>
                <p class="mt-5 text-white/70">
                    Sign in to manage programmes, news, partners, the map, and the contact inbox for the public site.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-6 text-sm text-white/60">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 hover:text-white">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M17 10a.75.75 0 0 1-.75.75H5.6l4.18 3.96a.75.75 0 1 1-1.08 1.04l-5.5-5.75a.75.75 0 0 1 0-1.04l5.5-5.75a.75.75 0 1 1 1.08 1.04L5.6 9.25h10.65A.75.75 0 0 1 17 10Z"/></svg>
                    Back to public site
                </a>
                <span aria-hidden="true">·</span>
                <span>© {{ date('Y') }} {{ setting('footer.copyright', config('app.name')) }}</span>
            </div>
        </div>
    </aside>

    {{-- RIGHT: login form --}}
    <main class="flex flex-col items-center justify-center px-6 py-12 sm:px-12 lg:px-16">

        {{-- Mobile logo (the desktop panel is hidden below lg) --}}
        <a href="{{ url('/') }}" class="mb-8 inline-flex items-center gap-2 lg:hidden" aria-label="{{ config('app.name') }} home">
            <img src="{{ asset('images/logo-gain.svg') }}" alt="GAIN" class="h-10 w-auto">
            <span class="text-xs font-semibold uppercase tracking-[0.18em] text-brand-muted">Admin</span>
        </a>

        <div class="w-full max-w-md">
            <div class="reveal">
                <h2 class="font-display text-3xl font-bold text-brand-ink sm:text-4xl">
                    Sign in
                </h2>
                <p class="mt-2 text-brand-muted">
                    Use your admin credentials to manage the site.
                </p>
            </div>

            @if (session('status'))
                <div class="mt-6 rounded-2xl border border-brand-green-200 bg-brand-green-50 px-4 py-3 text-sm font-medium text-brand-green-700">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-6 rounded-2xl border border-brand-red-200 bg-brand-red-50 px-4 py-3 text-sm text-brand-red-600">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="reveal reveal-delay-100 mt-8 space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-[0.18em] text-brand-muted">Email</label>
                    <div class="relative mt-2">
                        <span class="pointer-events-none absolute inset-y-0 left-0 grid w-10 place-items-center text-brand-muted/70">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M3 4a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H3Zm0 2 7 4 7-4v8H3V6Z"/></svg>
                        </span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               required autofocus autocomplete="username"
                               placeholder="you@example.org"
                               class="w-full rounded-xl border border-brand-ink/10 bg-white py-3 pl-10 pr-3 text-sm text-brand-ink placeholder-brand-muted/60 shadow-sm transition focus:border-brand-red-300 focus:outline-none focus:ring-2 focus:ring-brand-red-200">
                    </div>
                </div>

                <div x-data="{ show: false }">
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-xs font-semibold uppercase tracking-[0.18em] text-brand-muted">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-semibold text-brand-red-500 hover:text-brand-red-600">Forgot?</a>
                        @endif
                    </div>
                    <div class="relative mt-2">
                        <span class="pointer-events-none absolute inset-y-0 left-0 grid w-10 place-items-center text-brand-muted/70">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path fill-rule="evenodd" d="M10 1a4 4 0 0 0-4 4v3H5a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2h-1V5a4 4 0 0 0-4-4Zm-2 7V5a2 2 0 1 1 4 0v3H8Z" clip-rule="evenodd"/></svg>
                        </span>
                        <input id="password" :type="show ? 'text' : 'password'" name="password"
                               required autocomplete="current-password"
                               placeholder="••••••••"
                               class="w-full rounded-xl border border-brand-ink/10 bg-white py-3 pl-10 pr-12 text-sm text-brand-ink placeholder-brand-muted/60 shadow-sm transition focus:border-brand-red-300 focus:outline-none focus:ring-2 focus:ring-brand-red-200">
                        <button type="button" @click="show = !show" :aria-label="show ? 'Hide password' : 'Show password'"
                                class="absolute inset-y-0 right-0 grid w-10 place-items-center text-brand-muted/70 hover:text-brand-red-500">
                            <svg x-show="!show" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M10 4a6 6 0 0 0-6 6 6 6 0 0 0 12 0 6 6 0 0 0-6-6Zm0 10a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm0-6a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/></svg>
                            <svg x-show="show" x-cloak viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M3.7 2.7a1 1 0 0 0-1.4 1.4l14 14a1 1 0 0 0 1.4-1.4l-2-2A8 8 0 0 0 18 10s-3-6-8-6c-1.4 0-2.7.4-3.8 1L3.7 2.7ZM10 6a4 4 0 0 1 4 4 4 4 0 0 1-.6 2L11.4 10 12 9a2 2 0 0 0-2-2c-.4 0-.8.1-1.1.3L7.5 5.8C8.3 5.3 9.2 5 10 5l-.0 1ZM2 10s3 6 8 6c1 0 2-.2 3-.6L10.6 12A2 2 0 0 1 8 9.4L5 6.5A8 8 0 0 0 2 10Z"/></svg>
                        </button>
                    </div>
                </div>

                <label for="remember_me" class="flex cursor-pointer items-center gap-2 text-sm text-brand-muted">
                    <input id="remember_me" type="checkbox" name="remember"
                           class="h-4 w-4 rounded border-brand-ink/20 text-brand-red-500 focus:ring-brand-red-200">
                    Remember me on this device
                </label>

                <button type="submit"
                        class="btn-shimmer mt-2 inline-flex w-full items-center justify-center gap-2 rounded-full bg-brand-red-500 px-5 py-3 text-sm font-semibold text-white shadow-pill transition hover:bg-brand-red-600">
                    <span class="inline-flex items-center gap-2">
                        Sign in
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.08-1.04l5.5 5.75a.75.75 0 0 1 0 1.04l-5.5 5.75a.75.75 0 0 1-1.08-1.04l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/></svg>
                    </span>
                </button>
            </form>

            <p class="reveal reveal-delay-200 mt-8 text-center text-xs text-brand-muted">
                Trouble signing in? Contact your site administrator.
            </p>
        </div>
    </main>
</div>

</body>
</html>

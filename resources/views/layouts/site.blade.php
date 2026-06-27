<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>

    {{-- Favicon (SVG for modern browsers, ICO/PNG fallbacks) --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-gain.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-brand-ink antialiased bg-brand-cream">
    {{-- Scroll progress (top, behind sticky nav). Width driven by JS via --scroll-progress. --}}
    <div class="scroll-progress" data-scroll-progress aria-hidden="true"></div>

    @include('partials.site-nav')

    <main>
        @yield('content')
    </main>

    @include('partials.site-footer')

    {{-- Back-to-top floating button: appears once user scrolls past ~600px --}}
    <button
        x-data="{ shown: false }"
        x-init="window.addEventListener('scroll', () => shown = window.scrollY > 600, { passive: true })"
        x-show="shown" x-cloak
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 translate-y-2"
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        aria-label="Back to top"
        class="fixed bottom-6 right-6 z-40 grid h-11 w-11 place-items-center rounded-full bg-brand-red-500 text-white shadow-pill ring-1 ring-black/10 transition hover:-translate-y-0.5 hover:bg-brand-red-600 lg:bottom-8 lg:right-8">
        <svg viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5"><path fill-rule="evenodd" d="M10 17a.75.75 0 0 1-.75-.75V5.81L5.55 9.55a.75.75 0 1 1-1.06-1.06l5-5a.75.75 0 0 1 1.06 0l5 5a.75.75 0 1 1-1.06 1.06l-3.7-3.74v10.44A.75.75 0 0 1 10 17Z" clip-rule="evenodd"/></svg>
    </button>
</body>
</html>

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
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') · {{ config('app.name') }}</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-gain.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased">

@php
    $nav = [
        ['label' => 'Dashboard',     'route' => 'admin.dashboard',    'icon' => 'M3 12 12 3l9 9-2 0v8a1 1 0 0 1-1 1h-4v-6h-4v6H6a1 1 0 0 1-1-1v-8H3Z'],
        ['label' => 'Site Settings', 'route' => 'admin.settings.edit','icon' => 'M12 3v2M21 12h-2M12 21v-2M3 12h2M5.6 5.6l1.4 1.4M18.4 5.6 17 7M18.4 18.4 17 17M5.6 18.4 7 17M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z'],
        ['label' => 'Programmes',    'route' => 'admin.programmes.index',  'icon' => 'M4 4h16v4H4zM4 10h10v10H4zM16 10h4v10h-4z'],
        ['label' => 'News',          'route' => 'admin.news.index',        'icon' => 'M4 4h16v16H4zM4 8h16M8 12h8M8 16h6'],
        ['label' => 'Partners',      'route' => 'admin.partners.index',    'icon' => 'M9 12a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm6 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3 21a6 6 0 0 1 12 0M9 21a6 6 0 0 1 12 0'],
        ['label' => 'Testimonials',  'route' => 'admin.testimonials.index','icon' => 'M21 11.5a8.4 8.4 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.4 8.4 0 0 1-3.8-.9L3 21l1.9-5.7a8.4 8.4 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.4 8.4 0 0 1 3.8-.9h.5a8.5 8.5 0 0 1 8 8v.5Z'],
        ['label' => 'Impact stats',  'route' => 'admin.impact.index',      'icon' => 'M3 17 9 11l4 4 8-8M14 7h7v7'],
        ['label' => 'Achievements',  'route' => 'admin.achievements.index','icon' => 'M6 9h12v3a6 6 0 0 1-12 0V9ZM4 4h16v4H4zM10 21h4v-3h-4v3Z'],
        ['label' => 'M / V / V',     'route' => 'admin.mvv.index',         'icon' => 'M12 2 4 6v6c0 5 3.5 9.74 8 10 4.5-.26 8-5 8-10V6l-8-4Z'],
        ['label' => 'Map · Divisions','route' => 'admin.divisions.index',   'icon' => 'M9 4 3 7v13l6-3 6 3 6-3V4l-6 3-6-3Zm0 0v13M15 7v13'],
        ['label' => 'Map · Districts','route' => 'admin.districts.index',   'icon' => 'M12 2a7 7 0 0 0-7 7c0 5.5 7 13 7 13s7-7.5 7-13a7 7 0 0 0-7-7Zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z'],
        ['label' => 'Contact inbox', 'route' => 'admin.contact.index',     'icon' => 'M3 8l9 6 9-6M3 6h18v12H3z'],
    ];
@endphp

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="hidden w-64 shrink-0 border-r border-slate-200 bg-white lg:block">
        <div class="flex h-16 items-center gap-2 border-b border-slate-200 px-6">
            <img src="{{ asset('images/logo-gain.svg') }}" alt="GAIN" class="h-8 w-auto">
            <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Admin</span>
        </div>

        <nav class="px-3 py-4">
            <ul class="space-y-1">
                @foreach ($nav as $item)
                    @php
                        $exists = \Route::has($item['route']);
                        $active = $exists && request()->routeIs(\Str::beforeLast($item['route'], '.').'.*');
                    @endphp
                    <li>
                        <a href="{{ $exists ? route($item['route']) : '#' }}"
                           class="group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition
                                  {{ $active ? 'bg-brand-red-50 text-brand-red-500' : 'text-slate-700 hover:bg-slate-100' }}
                                  {{ ! $exists ? 'pointer-events-none opacity-40' : '' }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                <path d="{{ $item['icon'] }}"/>
                            </svg>
                            {{ $item['label'] }}
                            @if (! $exists)
                                <span class="ml-auto text-[10px] font-semibold text-slate-400">soon</span>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </aside>

    {{-- Main pane --}}
    <div class="flex flex-1 flex-col">

        {{-- Top bar --}}
        <header class="flex h-16 items-center justify-between border-b border-slate-200 bg-white px-6">
            <div>
                <div class="text-xs uppercase tracking-wider text-slate-400">@yield('breadcrumb', 'Admin')</div>
                <h1 class="font-display text-lg font-semibold text-slate-900">@yield('title', 'Dashboard')</h1>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ url('/') }}" target="_blank" class="text-sm text-slate-500 hover:text-slate-800">
                    View site ↗
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-slate-500 hover:text-brand-red-500">Log out</button>
                </form>
            </div>
        </header>

        {{-- Flash messages --}}
        @if (session('status'))
            <div class="border-b border-green-200 bg-green-50 px-6 py-3 text-sm text-green-800">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="border-b border-red-200 bg-red-50 px-6 py-3 text-sm text-red-800">
                <strong>Please fix:</strong>
                <ul class="ml-4 mt-1 list-disc">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        {{-- Content --}}
        <main class="flex-1 p-6 lg:p-8">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>

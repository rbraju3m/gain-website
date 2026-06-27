<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') · {{ config('app.name') }}</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-gain.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}">

    {{-- Quill rich-text editor (admin only) --}}
    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.7/quill.snow.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased">

@php
    $unreadContacts = \App\Models\ContactMessage::unread()->count();

    // Sidebar nav, grouped. Each item: label / route / icon (24x24 stroke path).
    // Optional badge (int) shows as a red pill on the right.
    $navGroups = [
        'Overview' => [
            ['label' => 'Dashboard',     'route' => 'admin.dashboard',     'icon' => 'M3 12 12 3l9 9-2 0v8a1 1 0 0 1-1 1h-4v-6h-4v6H6a1 1 0 0 1-1-1v-8H3Z'],
            ['label' => 'Site Settings', 'route' => 'admin.settings.edit', 'icon' => 'M12 3v2M21 12h-2M12 21v-2M3 12h2M5.6 5.6l1.4 1.4M18.4 5.6 17 7M18.4 18.4 17 17M5.6 18.4 7 17M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z'],
            ['label' => 'Users',         'route' => 'admin.users.index',   'icon' => 'M9 12a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-6 9a6 6 0 0 1 12 0M16 11a3 3 0 1 0 0-6M21 21a6 6 0 0 0-3-5.2'],
        ],
        'Content' => [
            ['label' => 'Programmes',    'route' => 'admin.programmes.index',  'icon' => 'M4 4h16v4H4zM4 10h10v10H4zM16 10h4v10h-4z'],
            ['label' => 'News & Events', 'route' => 'admin.news.index',        'icon' => 'M4 4h16v16H4zM4 8h16M8 12h8M8 16h6'],
            ['label' => 'Partners',      'route' => 'admin.partners.index',    'icon' => 'M9 12a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm6 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3 21a6 6 0 0 1 12 0M9 21a6 6 0 0 1 12 0'],
            ['label' => 'Testimonials',  'route' => 'admin.testimonials.index','icon' => 'M21 11.5a8.4 8.4 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.4 8.4 0 0 1-3.8-.9L3 21l1.9-5.7a8.4 8.4 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.4 8.4 0 0 1 3.8-.9h.5a8.5 8.5 0 0 1 8 8v.5Z'],
        ],
        'Sections' => [
            ['label' => 'Impact stats',  'route' => 'admin.impact.index',      'icon' => 'M3 17 9 11l4 4 8-8M14 7h7v7'],
            ['label' => 'Achievements',  'route' => 'admin.achievements.index','icon' => 'M6 9h12v3a6 6 0 0 1-12 0V9ZM4 4h16v4H4zM10 21h4v-3h-4v3Z'],
            ['label' => 'M / V / V',     'route' => 'admin.mvv.index',         'icon' => 'M12 2 4 6v6c0 5 3.5 9.74 8 10 4.5-.26 8-5 8-10V6l-8-4Z'],
        ],
        'Map' => [
            ['label' => 'Divisions',     'route' => 'admin.divisions.index',   'icon' => 'M9 4 3 7v13l6-3 6 3 6-3V4l-6 3-6-3Zm0 0v13M15 7v13'],
            ['label' => 'Districts',     'route' => 'admin.districts.index',   'icon' => 'M12 2a7 7 0 0 0-7 7c0 5.5 7 13 7 13s7-7.5 7-13a7 7 0 0 0-7-7Zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z'],
        ],
        'Inbox' => [
            ['label' => 'Contact messages', 'route' => 'admin.contact.index', 'badge' => $unreadContacts ?: null,
             'icon' => 'M3 8l9 6 9-6M3 6h18v12H3z'],
        ],
    ];

    $userName = auth()->user()?->name ?? 'Admin';
    $userInitial = \Illuminate\Support\Str::of($userName)->substr(0, 1)->upper();
@endphp

<div class="flex min-h-screen" x-data="{ sidebarOpen: false }">

    {{-- Mobile backdrop --}}
    <div x-show="sidebarOpen" x-cloak
         @click="sidebarOpen = false"
         class="fixed inset-0 z-30 bg-slate-900/40 backdrop-blur-sm lg:hidden"
         x-transition.opacity></div>

    {{-- Sidebar --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed inset-y-0 left-0 z-40 flex w-64 shrink-0 flex-col border-r border-slate-200 bg-white transition-transform lg:sticky lg:top-0 lg:h-screen lg:translate-x-0">

        <div class="flex h-16 items-center justify-between gap-2 border-b border-slate-200 px-5">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo-gain.svg') }}" alt="GAIN" class="h-8 w-auto">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Admin</span>
            </a>
            <button @click="sidebarOpen = false" class="rounded-md p-1.5 text-slate-500 hover:bg-slate-100 lg:hidden" aria-label="Close menu">
                <svg viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5"><path fill-rule="evenodd" d="M6.3 5.3a1 1 0 0 1 1.4 0L10 7.6l2.3-2.3a1 1 0 1 1 1.4 1.4L11.4 9l2.3 2.3a1 1 0 0 1-1.4 1.4L10 10.4l-2.3 2.3a1 1 0 0 1-1.4-1.4L8.6 9 6.3 6.7a1 1 0 0 1 0-1.4Z" clip-rule="evenodd"/></svg>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto px-3 py-4">
            @foreach ($navGroups as $groupLabel => $items)
                <div class="mb-5">
                    <div class="mb-2 px-3 text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-400">{{ $groupLabel }}</div>
                    <ul class="space-y-0.5">
                        @foreach ($items as $item)
                            @php
                                $exists = \Route::has($item['route']);
                                $active = $exists && request()->routeIs(\Str::beforeLast($item['route'], '.').'.*');
                            @endphp
                            <li>
                                <a href="{{ $exists ? route($item['route']) : '#' }}"
                                   @click="sidebarOpen = false"
                                   class="group relative flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition
                                          {{ $active ? 'bg-brand-red-50 text-brand-red-500' : 'text-slate-700 hover:bg-slate-100' }}
                                          {{ ! $exists ? 'pointer-events-none opacity-40' : '' }}">
                                    @if ($active)
                                        <span class="absolute -left-3 top-1/2 h-6 w-1 -translate-y-1/2 rounded-r bg-brand-red-500"></span>
                                    @endif
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 shrink-0">
                                        <path d="{{ $item['icon'] }}"/>
                                    </svg>
                                    <span class="flex-1">{{ $item['label'] }}</span>
                                    @if (! empty($item['badge']))
                                        <span class="inline-flex h-5 min-w-[20px] items-center justify-center rounded-full bg-brand-red-500 px-1.5 text-[10px] font-bold text-white">{{ $item['badge'] }}</span>
                                    @elseif (! $exists)
                                        <span class="text-[10px] font-semibold text-slate-400">soon</span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </nav>

        {{-- Sidebar footer --}}
        <div class="border-t border-slate-200 px-3 py-3">
            <a href="{{ url('/') }}" target="_blank"
               class="flex items-center gap-2 rounded-lg px-3 py-2 text-xs font-medium text-slate-500 hover:bg-slate-100 hover:text-slate-800">
                <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                    <path d="M11 3a1 1 0 1 0 0 2h2.586l-6.293 6.293a1 1 0 1 0 1.414 1.414L15 6.414V9a1 1 0 1 0 2 0V4a1 1 0 0 0-1-1h-5Z"/>
                    <path d="M5 5a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-3a1 1 0 1 0-2 0v3H5V7h3a1 1 0 0 0 0-2H5Z"/>
                </svg>
                View public site
            </a>
        </div>
    </aside>

    {{-- Main pane --}}
    <div class="flex min-w-0 flex-1 flex-col">

        {{-- Top bar --}}
        <header class="sticky top-0 z-20 flex h-16 items-center justify-between gap-3 border-b border-slate-200 bg-white/95 px-5 backdrop-blur lg:px-8">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="rounded-md p-1.5 text-slate-600 hover:bg-slate-100 lg:hidden" aria-label="Open menu">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5"><path d="M3 5h14a1 1 0 1 1 0 2H3a1 1 0 1 1 0-2Zm0 4h14a1 1 0 1 1 0 2H3a1 1 0 1 1 0-2Zm0 4h14a1 1 0 1 1 0 2H3a1 1 0 1 1 0-2Z"/></svg>
                </button>
                <div>
                    <div class="text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-400">@yield('breadcrumb', 'Admin')</div>
                    <h1 class="font-display text-lg font-semibold text-slate-900">@yield('title', 'Dashboard')</h1>
                </div>
            </div>

            {{-- User dropdown --}}
            <div x-data="{ userOpen: false }" class="relative">
                <button @click="userOpen = !userOpen" @click.outside="userOpen = false"
                        class="flex items-center gap-2.5 rounded-full border border-slate-200 bg-white py-1 pl-1 pr-3 text-sm transition hover:border-slate-300 hover:shadow-sm"
                        :aria-expanded="userOpen">
                    <span class="grid h-8 w-8 place-items-center rounded-full bg-brand-red-500 text-xs font-bold text-white">{{ $userInitial }}</span>
                    <span class="hidden font-medium text-slate-700 sm:inline">{{ $userName }}</span>
                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5 text-slate-400 transition" :class="userOpen ? 'rotate-180' : ''">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.06l3.71-3.83a.75.75 0 1 1 1.08 1.04l-4.25 4.39a.75.75 0 0 1-1.08 0L5.21 8.27a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd"/>
                    </svg>
                </button>

                <div x-show="userOpen" x-cloak
                     x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute right-0 top-full mt-2 w-56 overflow-hidden rounded-xl bg-white shadow-card ring-1 ring-black/5">
                    <div class="border-b border-slate-100 px-4 py-3">
                        <div class="text-sm font-semibold text-slate-900">{{ $userName }}</div>
                        <div class="text-xs text-slate-500">{{ auth()->user()?->email }}</div>
                    </div>
                    <div class="py-1">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-red-500">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M10 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-7 8a7 7 0 1 1 14 0H3Z"/></svg>
                            Profile
                        </a>
                        <a href="{{ url('/') }}" target="_blank" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-red-500">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M11 3a1 1 0 1 0 0 2h2.586l-6.293 6.293a1 1 0 1 0 1.414 1.414L15 6.414V9a1 1 0 1 0 2 0V4a1 1 0 0 0-1-1h-5Z"/><path d="M5 5a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-3a1 1 0 1 0-2 0v3H5V7h3a1 1 0 0 0 0-2H5Z"/></svg>
                            View public site
                        </a>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="border-t border-slate-100">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm text-slate-700 hover:bg-red-50 hover:text-red-600">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M3 4a2 2 0 0 1 2-2h6a1 1 0 1 1 0 2H5v12h6a1 1 0 1 1 0 2H5a2 2 0 0 1-2-2V4Zm12.3 3.3a1 1 0 0 1 1.4 0l2 2c.4.4.4 1 0 1.4l-2 2a1 1 0 1 1-1.4-1.4l.3-.3H10a1 1 0 1 1 0-2h5.6l-.3-.3a1 1 0 0 1 0-1.4Z"/></svg>
                            Log out
                        </button>
                    </form>
                </div>
            </div>
        </header>

        {{-- Flash messages — toast-style, top-right, auto-dismiss --}}
        <div class="pointer-events-none fixed inset-x-4 top-20 z-50 flex flex-col items-end gap-2 sm:right-6 sm:left-auto sm:max-w-sm">
            @if (session('status'))
                <div x-data="{ shown: true }" x-init="setTimeout(() => shown = false, 4500)"
                     x-show="shown" x-cloak
                     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 translate-y-1"
                     class="pointer-events-auto flex w-full items-start gap-3 rounded-xl border border-green-200 bg-white px-4 py-3 shadow-card ring-1 ring-black/5">
                    <span class="mt-0.5 grid h-6 w-6 place-items-center rounded-full bg-green-100 text-green-600">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 0 1 0 1.4l-7.5 7.5a1 1 0 0 1-1.4 0L3.3 9.7a1 1 0 1 1 1.4-1.4l3.8 3.8 6.8-6.8a1 1 0 0 1 1.4 0Z" clip-rule="evenodd"/></svg>
                    </span>
                    <div class="flex-1 text-sm text-slate-700">{{ session('status') }}</div>
                    <button @click="shown = false" class="text-slate-400 hover:text-slate-700" aria-label="Dismiss">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M6.3 5.3a1 1 0 0 1 1.4 0L10 7.6l2.3-2.3a1 1 0 1 1 1.4 1.4L11.4 9l2.3 2.3a1 1 0 0 1-1.4 1.4L10 10.4l-2.3 2.3a1 1 0 0 1-1.4-1.4L8.6 9 6.3 6.7a1 1 0 0 1 0-1.4Z"/></svg>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div x-data="{ shown: true }" x-show="shown"
                     x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                     class="pointer-events-auto flex w-full items-start gap-3 rounded-xl border border-red-200 bg-white px-4 py-3 shadow-card ring-1 ring-black/5">
                    <span class="mt-0.5 grid h-6 w-6 place-items-center rounded-full bg-red-100 text-red-600">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM9 7a1 1 0 1 1 2 0v4a1 1 0 1 1-2 0V7Zm1 8a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" clip-rule="evenodd"/></svg>
                    </span>
                    <div class="flex-1 text-sm text-slate-700">
                        <strong class="font-semibold text-slate-900">Please fix the following:</strong>
                        <ul class="ml-3 mt-1 list-disc text-xs text-slate-600">
                            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                    <button @click="shown = false" class="text-slate-400 hover:text-slate-700" aria-label="Dismiss">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M6.3 5.3a1 1 0 0 1 1.4 0L10 7.6l2.3-2.3a1 1 0 1 1 1.4 1.4L11.4 9l2.3 2.3a1 1 0 0 1-1.4 1.4L10 10.4l-2.3 2.3a1 1 0 0 1-1.4-1.4L8.6 9 6.3 6.7a1 1 0 0 1 0-1.4Z"/></svg>
                    </button>
                </div>
            @endif
        </div>

        {{-- Content --}}
        <main class="flex-1 p-5 lg:p-8">
            @yield('content')
        </main>
    </div>
</div>

{{-- SortableJS: any <tbody data-sortable data-url="..."> with rows that have
     data-id becomes drag-and-drop reorderable. Each row needs a .drag-handle
     element. On drop, the new order is POSTed to data-url. --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('tbody[data-sortable]').forEach(function (tbody) {
            const url = tbody.dataset.url;
            if (! url) return;
            Sortable.create(tbody, {
                handle: '.drag-handle',
                animation: 180,
                ghostClass: 'drag-ghost',
                chosenClass: 'drag-chosen',
                onEnd: function () {
                    const order = Array.from(tbody.querySelectorAll('tr[data-id]')).map(tr => tr.dataset.id);
                    tbody.classList.add('drag-saving');
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ order: order }),
                    }).then(r => {
                        tbody.classList.remove('drag-saving');
                        if (! r.ok) console.warn('Sort save failed', r.status);
                    }).catch(e => {
                        tbody.classList.remove('drag-saving');
                        console.warn('Sort save error', e);
                    });
                },
            });
        });
    });
</script>

{{-- Quill init: every <textarea data-rte> becomes a rich-text editor. --}}
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('textarea[data-rte]').forEach(function (textarea) {
            const wrap = document.createElement('div');
            wrap.className = 'rte-wrap rounded-lg border border-slate-200 bg-white shadow-sm';
            const editor = document.createElement('div');
            editor.className = 'rte-editor';
            editor.style.minHeight = (textarea.rows ? (textarea.rows * 24) : 200) + 'px';
            editor.innerHTML = textarea.value || '';
            textarea.parentNode.insertBefore(wrap, textarea);
            wrap.appendChild(editor);
            textarea.style.display = 'none';

            const quill = new Quill(editor, {
                theme: 'snow',
                placeholder: textarea.placeholder || 'Write something …',
                modules: {
                    toolbar: [
                        [{ header: [2, 3, 4, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['blockquote', 'link'],
                        ['clean'],
                    ],
                },
            });

            const sync = function () {
                const html = quill.getText().trim().length ? quill.root.innerHTML : '';
                textarea.value = html;
            };
            quill.on('text-change', sync);
            textarea.form && textarea.form.addEventListener('submit', sync);
        });
    });
</script>
</body>
</html>

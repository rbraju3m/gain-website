@extends('admin.layouts.admin')

@section('title', 'Partners')
@section('breadcrumb', 'Content')

@section('content')
<div class="space-y-6">

    <div class="flex flex-wrap items-center justify-between gap-3">
        <x-admin.search-box placeholder="Search partners by name…" :value="$q" />
        <a href="{{ route('admin.partners.create') }}"
           class="inline-flex items-center gap-1.5 rounded-full bg-brand-red-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-red-600">
            + New partner
        </a>
    </div>

    @foreach ([
        ['title' => 'Strategic partners',     'subtitle' => 'Row 1 on the homepage — static 4-column grid.', 'rows' => $strategic],
        ['title' => 'Implementing partners',  'subtitle' => 'Row 2 on the homepage — horizontal scrolling marquee.', 'rows' => $implementing],
    ] as $section)
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="text-base font-semibold text-slate-900">{{ $section['title'] }}</h2>
                <p class="text-sm text-slate-500">{{ $section['subtitle'] }} — {{ $section['rows']->count() }} total @if (empty($q)) · <span class="text-slate-400">drag to reorder</span> @endif.</p>
            </div>

            @if ($section['rows']->isEmpty())
                <div class="px-6 py-10 text-center text-sm text-slate-500">
                    @if (filled($q))
                        No matches in this group for "<strong class="text-slate-700">{{ $q }}</strong>".
                    @else
                        No partners in this group yet.
                    @endif
                </div>
            @else
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            @if (empty($q))<th class="w-8 px-2 py-3"></th>@endif
                            <th class="px-6 py-3">Logo</th>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100"
                           @if (empty($q)) data-sortable data-url="{{ route('admin.partners.sort') }}" @endif>
                        @foreach ($section['rows'] as $p)
                            <tr class="hover:bg-slate-50" data-id="{{ $p->id }}">
                                @if (empty($q))
                                    <td class="drag-handle w-8 px-2 py-3" title="Drag to reorder">
                                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><circle cx="9" cy="6" r="1.5"/><circle cx="9" cy="12" r="1.5"/><circle cx="9" cy="18" r="1.5"/><circle cx="15" cy="6" r="1.5"/><circle cx="15" cy="12" r="1.5"/><circle cx="15" cy="18" r="1.5"/></svg>
                                    </td>
                                @endif
                                <td class="px-6 py-3">
                                    @if ($p->logoUrl())
                                        <img src="{{ $p->logoUrl() }}" alt="" class="h-10 w-24 object-contain">
                                    @else
                                        <div class="grid h-10 w-24 place-items-center rounded-lg bg-slate-100 text-xs text-slate-400">No logo</div>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    <a href="{{ route('admin.partners.edit', $p) }}" class="font-semibold text-slate-900 hover:text-brand-red-500">
                                        {{ $p->name }}
                                    </a>
                                    @if ($p->url)
                                        <div class="text-xs text-slate-500"><a href="{{ $p->url }}" target="_blank" rel="noopener" class="hover:underline">{{ Str::limit($p->url, 50) }}</a></div>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    @if ($p->is_published)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-semibold text-green-600">
                                            <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span> Published
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-500">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span> Hidden
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-right">
                                    <a href="{{ route('admin.partners.edit', $p) }}" class="text-sm font-semibold text-brand-red-500 hover:text-brand-red-600">Edit</a>
                                    <x-admin.confirm-delete :action="route('admin.partners.destroy', $p)"
                                                            title="Delete this partner?"
                                                            :message="'“' . $p->name . '” will be removed from the homepage Partners section.'"
                                                            class="ml-3 text-sm text-slate-500 hover:text-red-600" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    @endforeach
</div>
@endsection

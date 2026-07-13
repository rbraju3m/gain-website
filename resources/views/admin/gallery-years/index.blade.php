@extends('admin.layouts.admin')

@section('title', 'Gallery years')
@section('breadcrumb', 'Gallery')

@section('content')
<div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-6 py-4">
        <div>
            <h2 class="text-base font-semibold text-slate-900">Gallery years</h2>
            <p class="text-sm text-slate-500">
                Each year is a folder on the public gallery. {{ $years->total() }} total.
                @if (empty($q)) <span class="ml-1 text-slate-400">· drag to reorder</span> @endif
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <x-admin.search-box placeholder="Search years…" :value="$q" />
            <a href="{{ route('admin.gallery-images.index') }}"
               class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                Manage images
            </a>
            <a href="{{ route('admin.gallery-years.create') }}"
               class="inline-flex items-center gap-1.5 rounded-full bg-brand-red-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-red-600">
                + New year
            </a>
        </div>
    </div>

    @if ($years->isEmpty())
        <div class="px-6 py-12 text-center text-sm text-slate-500">
            @if (filled($q))
                No years match "<strong class="text-slate-700">{{ $q }}</strong>".
                <a href="{{ route('admin.gallery-years.index') }}" class="font-semibold text-brand-red-500">Clear search</a>.
            @else
                No gallery years yet. <a href="{{ route('admin.gallery-years.create') }}" class="font-semibold text-brand-red-500">Create the first one</a>.
            @endif
        </div>
    @else
        <table class="w-full text-left text-sm" data-sortable-table>
            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                <tr>
                    @if (empty($q))
                        <th class="w-8 px-2 py-3"></th>
                    @endif
                    <th class="px-6 py-3">Year</th>
                    <th class="px-6 py-3">Title</th>
                    <th class="px-6 py-3">Images</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100"
                   @if (empty($q)) data-sortable data-url="{{ route('admin.gallery-years.sort') }}" @endif>
                @foreach ($years as $year)
                    <tr class="hover:bg-slate-50" data-id="{{ $year->id }}">
                        @if (empty($q))
                            <td class="drag-handle w-8 px-2 py-3" title="Drag to reorder">
                                <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><circle cx="9" cy="6" r="1.5"/><circle cx="9" cy="12" r="1.5"/><circle cx="9" cy="18" r="1.5"/><circle cx="15" cy="6" r="1.5"/><circle cx="15" cy="12" r="1.5"/><circle cx="15" cy="18" r="1.5"/></svg>
                            </td>
                        @endif
                        <td class="px-6 py-3 font-display text-lg font-bold text-brand-red-500">{{ $year->year }}</td>
                        <td class="px-6 py-3">
                            <a href="{{ route('admin.gallery-years.edit', $year) }}" class="font-semibold text-slate-900 hover:text-brand-red-500">
                                {{ $year->title ?: '—' }}
                            </a>
                            @if ($year->description)
                                <div class="text-xs text-slate-500">{{ \Illuminate\Support\Str::limit($year->description, 80) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-3">
                            <a href="{{ route('admin.gallery-images.index', ['year_id' => $year->id]) }}"
                               class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-700 hover:bg-slate-200">
                                {{ $year->images_count }} image{{ $year->images_count === 1 ? '' : 's' }}
                            </a>
                        </td>
                        <td class="px-6 py-3">
                            @if ($year->is_published)
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
                            <a href="{{ route('admin.gallery-images.create', ['year_id' => $year->id]) }}"
                               class="text-sm font-semibold text-slate-500 hover:text-brand-red-500">+ Image</a>
                            <a href="{{ route('admin.gallery-years.edit', $year) }}" class="ml-3 text-sm font-semibold text-brand-red-500 hover:text-brand-red-600">Edit</a>
                            <x-admin.confirm-delete :action="route('admin.gallery-years.destroy', $year)"
                                                    title="Delete this year?"
                                                    :message="'Year ' . $year->year . ' and all its images will be permanently removed.'"
                                                    class="ml-3 text-sm text-slate-500 hover:text-red-600" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($years->hasPages())
            <div class="border-t border-slate-200 px-6 py-3">{{ $years->links() }}</div>
        @endif
    @endif
</div>
@endsection

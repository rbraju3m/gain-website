@extends('admin.layouts.admin')

@section('title', 'Programmes')
@section('breadcrumb', 'Content')

@section('content')
<div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-6 py-4">
        <div>
            <h2 class="text-base font-semibold text-slate-900">Programme cards</h2>
            <p class="text-sm text-slate-500">
                Shown in the "Our Programmes" section on the homepage. {{ $programmes->total() }} total.
                @if (empty($q)) <span class="ml-1 text-slate-400">· drag <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="inline h-3 w-3 -translate-y-0.5"><path d="M9 6h.01M9 12h.01M9 18h.01M15 6h.01M15 12h.01M15 18h.01"/></svg> to reorder</span> @endif
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <x-admin.search-box placeholder="Search programmes…" :value="$q" />
            <a href="{{ route('admin.programmes.create') }}"
               class="inline-flex items-center gap-1.5 rounded-full bg-brand-red-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-red-600">
                + New
            </a>
        </div>
    </div>

    @if ($programmes->isEmpty())
        <div class="px-6 py-12 text-center text-sm text-slate-500">
            @if (filled($q))
                No programmes match "<strong class="text-slate-700">{{ $q }}</strong>".
                <a href="{{ route('admin.programmes.index') }}" class="font-semibold text-brand-red-500">Clear search</a>.
            @else
                No programmes yet. <a href="{{ route('admin.programmes.create') }}" class="font-semibold text-brand-red-500">Create the first one</a>.
            @endif
        </div>
    @else
        <table class="w-full text-left text-sm" data-sortable-table>
            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                <tr>
                    @if (empty($q))
                        <th class="w-8 px-2 py-3"></th>
                    @endif
                    <th class="px-6 py-3">Image</th>
                    <th class="px-6 py-3">Title</th>
                    <th class="px-6 py-3">Category</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100"
                   @if (empty($q)) data-sortable data-url="{{ route('admin.programmes.sort') }}" @endif>
                @foreach ($programmes as $programme)
                    <tr class="hover:bg-slate-50" data-id="{{ $programme->id }}">
                        @if (empty($q))
                            <td class="drag-handle w-8 px-2 py-3" title="Drag to reorder">
                                <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><circle cx="9" cy="6" r="1.5"/><circle cx="9" cy="12" r="1.5"/><circle cx="9" cy="18" r="1.5"/><circle cx="15" cy="6" r="1.5"/><circle cx="15" cy="12" r="1.5"/><circle cx="15" cy="18" r="1.5"/></svg>
                            </td>
                        @endif
                        <td class="px-6 py-3">
                            @if ($programme->imageUrl())
                                <img src="{{ $programme->imageUrl() }}" alt="" class="h-12 w-16 rounded-lg object-cover ring-1 ring-slate-200">
                            @else
                                <div class="grid h-12 w-16 place-items-center rounded-lg bg-slate-100 text-xs text-slate-400">No image</div>
                            @endif
                        </td>
                        <td class="px-6 py-3">
                            <a href="{{ route('admin.programmes.edit', $programme) }}" class="font-semibold text-slate-900 hover:text-brand-red-500">
                                {{ $programme->title }}
                            </a>
                            <div class="text-xs text-slate-500">{{ Str::limit(strip_tags($programme->body), 80) }}</div>
                        </td>
                        <td class="px-6 py-3">
                            @if ($programme->category)
                                <span class="inline-flex rounded-full bg-brand-red-50 px-2.5 py-0.5 text-xs font-semibold text-brand-red-500">
                                    {{ $programme->category }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-3">
                            @if ($programme->is_published)
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
                            <a href="{{ route('admin.programmes.edit', $programme) }}" class="text-sm font-semibold text-brand-red-500 hover:text-brand-red-600">Edit</a>
                            <x-admin.confirm-delete :action="route('admin.programmes.destroy', $programme)"
                                                    title="Delete this programme?"
                                                    :message="'“' . $programme->title . '” will be permanently removed.'"
                                                    class="ml-3 text-sm text-slate-500 hover:text-red-600" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($programmes->hasPages())
            <div class="border-t border-slate-200 px-6 py-3">{{ $programmes->links() }}</div>
        @endif
    @endif
</div>
@endsection

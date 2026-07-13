@extends('admin.layouts.admin')

@section('title', 'Hero carousel')
@section('breadcrumb', 'Sections')

@section('content')
<div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-6 py-4">
        <div>
            <h2 class="text-base font-semibold text-slate-900">Hero slides</h2>
            <p class="text-sm text-slate-500">
                Rotates in the hero on the homepage. {{ $slides->total() }} total.
                @if (empty($q)) <span class="ml-1 text-slate-400">· drag <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="inline h-3 w-3 -translate-y-0.5"><path d="M9 6h.01M9 12h.01M9 18h.01M15 6h.01M15 12h.01M15 18h.01"/></svg> to reorder</span> @endif
                <span class="ml-1 text-slate-400">· blank copy fields fall back to Site Settings → Hero.</span>
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <x-admin.search-box placeholder="Search slides…" :value="$q" />
            <a href="{{ route('admin.hero-slides.create') }}"
               class="inline-flex items-center gap-1.5 rounded-full bg-brand-red-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-red-600">
                + New
            </a>
        </div>
    </div>

    @if ($slides->isEmpty())
        <div class="px-6 py-12 text-center text-sm text-slate-500">
            @if (filled($q))
                No slides match "<strong class="text-slate-700">{{ $q }}</strong>".
                <a href="{{ route('admin.hero-slides.index') }}" class="font-semibold text-brand-red-500">Clear search</a>.
            @else
                No hero slides yet. The homepage will fall back to the single hero image from
                <a href="{{ route('admin.settings.edit') }}" class="font-semibold text-brand-red-500">Site Settings</a>
                until you <a href="{{ route('admin.hero-slides.create') }}" class="font-semibold text-brand-red-500">create the first slide</a>.
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
                    <th class="px-6 py-3">Headline</th>
                    <th class="px-6 py-3">Badge</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100"
                   @if (empty($q)) data-sortable data-url="{{ route('admin.hero-slides.sort') }}" @endif>
                @foreach ($slides as $slide)
                    <tr class="hover:bg-slate-50" data-id="{{ $slide->id }}">
                        @if (empty($q))
                            <td class="drag-handle w-8 px-2 py-3" title="Drag to reorder">
                                <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><circle cx="9" cy="6" r="1.5"/><circle cx="9" cy="12" r="1.5"/><circle cx="9" cy="18" r="1.5"/><circle cx="15" cy="6" r="1.5"/><circle cx="15" cy="12" r="1.5"/><circle cx="15" cy="18" r="1.5"/></svg>
                            </td>
                        @endif
                        <td class="px-6 py-3">
                            @if ($slide->imageUrl())
                                <img src="{{ $slide->imageUrl() }}" alt="" class="h-16 w-14 rounded-lg object-cover ring-1 ring-slate-200">
                            @else
                                <div class="grid h-16 w-14 place-items-center rounded-lg bg-slate-100 text-xs text-slate-400">No image</div>
                            @endif
                        </td>
                        <td class="px-6 py-3">
                            <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="font-semibold text-slate-900 hover:text-brand-red-500">
                                {{ $slide->line1 ?: setting('hero.line1', 'Nourishing') }}
                                {{ $slide->line2_accent ?: setting('hero.line2_accent', 'Communities') }}
                            </a>
                            @if ($slide->subhead)
                                <div class="text-xs text-slate-500">{{ \Illuminate\Support\Str::limit($slide->subhead, 80) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-xs text-slate-600">
                            {{ $slide->badge ?: '—' }}
                        </td>
                        <td class="px-6 py-3">
                            @if ($slide->is_published)
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
                            <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="text-sm font-semibold text-brand-red-500 hover:text-brand-red-600">Edit</a>
                            <x-admin.confirm-delete :action="route('admin.hero-slides.destroy', $slide)"
                                                    title="Delete this hero slide?"
                                                    message="This slide will be permanently removed from the hero carousel."
                                                    class="ml-3 text-sm text-slate-500 hover:text-red-600" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($slides->hasPages())
            <div class="border-t border-slate-200 px-6 py-3">{{ $slides->links() }}</div>
        @endif
    @endif
</div>
@endsection

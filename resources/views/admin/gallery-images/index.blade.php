@extends('admin.layouts.admin')

@section('title', 'Gallery images')
@section('breadcrumb', 'Gallery')

@section('content')
<div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-6 py-4">
        <div>
            <h2 class="text-base font-semibold text-slate-900">Gallery images</h2>
            <p class="text-sm text-slate-500">
                {{ $images->total() }} image{{ $images->total() === 1 ? '' : 's' }} across your gallery years.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <form method="GET" class="flex items-center gap-2">
                <select name="year_id" onchange="this.form.submit()"
                        class="rounded-full border border-slate-200 bg-white px-3 py-1.5 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                    <option value="">All years</option>
                    @foreach ($allYears as $y)
                        <option value="{{ $y->id }}" @selected($yearId == $y->id)>{{ $y->year }}@if ($y->title) — {{ $y->title }}@endif</option>
                    @endforeach
                </select>
                @if ($q)<input type="hidden" name="q" value="{{ $q }}">@endif
            </form>
            <x-admin.search-box placeholder="Search titles…" :value="$q" />
            <a href="{{ route('admin.gallery-years.index') }}"
               class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                Manage years
            </a>
            @if ($allYears->isNotEmpty())
                <a href="{{ route('admin.gallery-images.create', ['year_id' => $yearId]) }}"
                   class="inline-flex items-center gap-1.5 rounded-full bg-brand-red-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-red-600">
                    + New image
                </a>
            @endif
        </div>
    </div>

    @if ($allYears->isEmpty())
        <div class="px-6 py-12 text-center text-sm text-slate-500">
            You need at least one gallery year before adding images.
            <a href="{{ route('admin.gallery-years.create') }}" class="font-semibold text-brand-red-500">Create a year</a>.
        </div>
    @elseif ($images->isEmpty())
        <div class="px-6 py-12 text-center text-sm text-slate-500">
            No images yet. <a href="{{ route('admin.gallery-images.create', ['year_id' => $yearId]) }}" class="font-semibold text-brand-red-500">Add the first image</a>.
        </div>
    @else
        <div class="grid gap-4 p-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($images as $img)
                <div class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">
                    <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
                        @if ($img->imageUrl())
                            <img src="{{ $img->imageUrl() }}" alt="{{ $img->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        @else
                            <div class="grid h-full w-full place-items-center text-xs text-slate-400">No image</div>
                        @endif
                        <span class="absolute left-2 top-2 rounded-full bg-white/90 px-2 py-0.5 text-[10px] font-bold text-brand-red-500 shadow-sm">{{ $img->year->year ?? '—' }}</span>
                        @if (! $img->is_published)
                            <span class="absolute right-2 top-2 rounded-full bg-slate-800/85 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white">Hidden</span>
                        @endif
                    </div>
                    <div class="flex flex-1 flex-col p-3">
                        <div class="text-sm font-semibold text-slate-900">{{ $img->title }}</div>
                        @if ($img->description)
                            <div class="mt-1 text-xs text-slate-500">{{ \Illuminate\Support\Str::limit($img->description, 90) }}</div>
                        @endif
                        <div class="mt-3 flex items-center gap-3 border-t border-slate-100 pt-2">
                            <a href="{{ route('admin.gallery-images.edit', $img) }}" class="text-xs font-semibold text-brand-red-500 hover:text-brand-red-600">Edit</a>
                            <x-admin.confirm-delete :action="route('admin.gallery-images.destroy', $img)"
                                                    title="Delete this image?"
                                                    :message="'“' . $img->title . '” will be permanently removed.'"
                                                    class="text-xs text-slate-500 hover:text-red-600" />
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($images->hasPages())
            <div class="border-t border-slate-200 px-6 py-3">{{ $images->links() }}</div>
        @endif
    @endif
</div>
@endsection

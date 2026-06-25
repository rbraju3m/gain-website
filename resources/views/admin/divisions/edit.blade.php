@extends('admin.layouts.admin')

@section('title', 'Edit · ' . $division->name)
@section('breadcrumb', 'Map / Division stats')

@section('content')
<form method="POST" action="{{ route('admin.divisions.update', $division) }}" class="space-y-6">
    @csrf
    @method('PATCH')

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center gap-3">
            <span class="grid h-10 w-10 place-items-center rounded-full bg-brand-red-100 text-brand-red-500">
                <svg viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                    <path d="M12 2a7 7 0 0 0-7 7c0 5.5 7 13 7 13s7-7.5 7-13a7 7 0 0 0-7-7Zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z"/>
                </svg>
            </span>
            <div>
                <h2 class="text-lg font-semibold text-slate-900">{{ $division->name }}</h2>
                <p class="text-sm text-slate-500">
                    Stats shown in the map sidebar when this division is selected.
                    Division name + key are fixed (they must match the SVG region IDs).
                </p>
            </div>
        </div>

        <div class="mt-6 grid gap-5 md:grid-cols-2">
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Families served</label>
                <input type="text" name="families" value="{{ old('families', $division->families) }}"
                       placeholder="e.g. 4,200+"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Active programmes</label>
                <input type="number" name="programmes" min="0" max="9999" value="{{ old('programmes', $division->programmes) }}"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Success rate</label>
                <input type="text" name="success_rate" value="{{ old('success_rate', $division->success_rate) }}"
                       placeholder="e.g. 98%"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Sort order</label>
                <input type="number" name="sort_order" min="0" max="99" value="{{ old('sort_order', $division->sort_order) }}"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                <p class="mt-1 text-xs text-slate-400">Controls the order of division chips in the map sidebar.</p>
            </div>
        </div>

        <div class="mt-6 rounded-lg bg-slate-50 px-4 py-3 text-xs text-slate-500">
            <span class="font-semibold text-slate-700">Districts covered</span> is computed from the
            <a href="{{ route('admin.districts.index') }}" class="font-semibold text-brand-red-500 hover:underline">Districts</a>
            page (currently {{ $division->districts->where('is_active', true)->count() }} / {{ $division->districts->count() }} active in this division).
        </div>
    </div>

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.divisions.index') }}" class="text-sm text-slate-500 hover:text-slate-800">← Back</a>
        <button type="submit" class="rounded-full bg-brand-red-500 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-red-600">Save changes</button>
    </div>
</form>
@endsection

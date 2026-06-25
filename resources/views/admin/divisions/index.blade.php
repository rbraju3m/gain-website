@extends('admin.layouts.admin')

@section('title', 'Map · Division stats')
@section('breadcrumb', 'Map')

@section('content')
<div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-200 px-6 py-4">
        <h2 class="text-base font-semibold text-slate-900">Division stats</h2>
        <p class="text-sm text-slate-500">
            Numbers shown in the map sidebar when a visitor hovers/clicks a division.
            Districts toggle is in
            <a href="{{ route('admin.districts.index') }}" class="font-semibold text-brand-red-500">Map &middot; Districts</a>.
        </p>
    </div>

    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
            <tr>
                <th class="px-6 py-3">Division</th>
                <th class="px-6 py-3">Families served</th>
                <th class="px-6 py-3">Programmes</th>
                <th class="px-6 py-3">Districts covered</th>
                <th class="px-6 py-3">Success rate</th>
                <th class="px-6 py-3 text-right">Edit</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach ($divisions as $d)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-3 font-semibold text-slate-900">{{ $d->name }}</td>
                    <td class="px-6 py-3 font-mono text-slate-700">{{ $d->families ?: '—' }}</td>
                    <td class="px-6 py-3 font-mono text-slate-700">{{ $d->programmes }}</td>
                    <td class="px-6 py-3 font-mono text-slate-700">
                        {{ $d->active_districts_count }} / {{ $d->districts->count() }}
                    </td>
                    <td class="px-6 py-3 font-mono text-slate-700">{{ $d->success_rate ?: '—' }}</td>
                    <td class="px-6 py-3 text-right">
                        <a href="{{ route('admin.divisions.edit', $d) }}" class="text-sm font-semibold text-brand-red-500 hover:text-brand-red-600">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

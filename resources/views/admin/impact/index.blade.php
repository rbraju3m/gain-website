@extends('admin.layouts.admin')

@section('title', 'Impact stats')
@section('breadcrumb', 'Content')

@section('content')
<div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-6 py-4">
        <div>
            <h2 class="text-base font-semibold text-slate-900">Our Impact Across Bangladesh</h2>
            <p class="text-sm text-slate-500">Stat cards in section 2. {{ $stats->count() }} total · <span class="text-slate-400">drag to reorder</span>.</p>
        </div>
        <a href="{{ route('admin.impact.create') }}"
           class="inline-flex items-center gap-1.5 rounded-full bg-brand-red-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-red-600">
            + New stat
        </a>
    </div>

    @if ($stats->isEmpty())
        <div class="px-6 py-12 text-center text-sm text-slate-500">
            No stats yet. <a href="{{ route('admin.impact.create') }}" class="font-semibold text-brand-red-500">Add the first one</a>.
        </div>
    @else
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="w-8 px-2 py-3"></th>
                    <th class="px-6 py-3">Icon</th>
                    <th class="px-6 py-3">Label</th>
                    <th class="px-6 py-3">Value</th>
                    <th class="px-6 py-3">Tone</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100" data-sortable data-url="{{ route('admin.impact.sort') }}">
                @foreach ($stats as $s)
                    <tr class="hover:bg-slate-50" data-id="{{ $s->id }}">
                        <td class="drag-handle w-8 px-2 py-3" title="Drag to reorder">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><circle cx="9" cy="6" r="1.5"/><circle cx="9" cy="12" r="1.5"/><circle cx="9" cy="18" r="1.5"/><circle cx="15" cy="6" r="1.5"/><circle cx="15" cy="12" r="1.5"/><circle cx="15" cy="18" r="1.5"/></svg>
                        </td>
                        <td class="px-6 py-3">
                            @if ($svg = $s->iconSvg())
                                <span class="grid h-9 w-9 place-items-center rounded-lg bg-brand-red-50 text-brand-red-500">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5">{!! $svg !!}</svg>
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-3 font-semibold text-slate-900">{{ $s->label }}</td>
                        <td class="px-6 py-3 font-mono text-slate-700">{{ number_format($s->counter) }}{{ $s->suffix }}</td>
                        <td class="px-6 py-3">
                            <span class="inline-flex rounded-full bg-{{ $s->tone === 'red' ? 'red' : ($s->tone === 'green' ? 'green' : 'orange') }}-50 px-2.5 py-0.5 text-xs font-semibold text-{{ $s->tone === 'red' ? 'red' : ($s->tone === 'green' ? 'green' : 'orange') }}-600 capitalize">{{ $s->tone }}</span>
                        </td>
                        <td class="px-6 py-3">
                            @if ($s->is_published)
                                <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-semibold text-green-600"><span class="h-1.5 w-1.5 rounded-full bg-green-500"></span> Published</span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-500"><span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span> Hidden</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-right">
                            <a href="{{ route('admin.impact.edit', $s) }}" class="text-sm font-semibold text-brand-red-500 hover:text-brand-red-600">Edit</a>
                            <x-admin.confirm-delete :action="route('admin.impact.destroy', $s)"
                                                    title="Delete this stat?"
                                                    :message="'“' . $s->label . '” will be permanently removed.'"
                                                    class="ml-3 text-sm text-slate-500 hover:text-red-600" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

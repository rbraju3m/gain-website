@extends('admin.layouts.admin')

@section('title', 'Impact stats')
@section('breadcrumb', 'Content')

@section('content')
<div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-6 py-4">
        <div>
            <h2 class="text-base font-semibold text-slate-900">Our Impact Across Bangladesh</h2>
            <p class="text-sm text-slate-500">Stat cards in section 2. Numbers animate up from zero. {{ $stats->count() }} total.</p>
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
                    <th class="px-6 py-3">Icon</th>
                    <th class="px-6 py-3">Label</th>
                    <th class="px-6 py-3">Value</th>
                    <th class="px-6 py-3">Tone</th>
                    <th class="px-6 py-3">Order</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($stats as $s)
                    <tr class="hover:bg-slate-50">
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
                        <td class="px-6 py-3 text-slate-600">{{ $s->sort_order }}</td>
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

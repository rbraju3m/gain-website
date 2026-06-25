@extends('admin.layouts.admin')

@section('title', 'Mission · Vision · Values')
@section('breadcrumb', 'Content')

@section('content')
<div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-6 py-4">
        <div>
            <h2 class="text-base font-semibold text-slate-900">Mission · Vision · Values cards</h2>
            <p class="text-sm text-slate-500">3-card row under the About section. {{ $cards->count() }} total.</p>
        </div>
        <a href="{{ route('admin.mvv.create') }}"
           class="inline-flex items-center gap-1.5 rounded-full bg-brand-red-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-red-600">
            + New card
        </a>
    </div>

    @if ($cards->isEmpty())
        <div class="px-6 py-12 text-center text-sm text-slate-500">
            No cards yet. <a href="{{ route('admin.mvv.create') }}" class="font-semibold text-brand-red-500">Add the first one</a>.
        </div>
    @else
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-6 py-3">Icon</th>
                    <th class="px-6 py-3">Title</th>
                    <th class="px-6 py-3">Body</th>
                    <th class="px-6 py-3">Tone</th>
                    <th class="px-6 py-3">Order</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($cards as $c)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-3">
                            @if ($svg = $c->iconSvg())
                                <span class="grid h-9 w-9 place-items-center rounded-lg bg-brand-red-50 text-brand-red-500">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5">{!! $svg !!}</svg>
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-3 font-semibold text-slate-900">
                            <a href="{{ route('admin.mvv.edit', $c) }}" class="hover:text-brand-red-500">{{ $c->title }}</a>
                        </td>
                        <td class="px-6 py-3 text-sm text-slate-600">{{ Str::limit($c->body, 100) }}</td>
                        <td class="px-6 py-3">
                            <span class="inline-flex rounded-full bg-{{ $c->tone === 'red' ? 'red' : ($c->tone === 'green' ? 'green' : 'orange') }}-50 px-2.5 py-0.5 text-xs font-semibold text-{{ $c->tone === 'red' ? 'red' : ($c->tone === 'green' ? 'green' : 'orange') }}-600 capitalize">{{ $c->tone }}</span>
                        </td>
                        <td class="px-6 py-3 text-slate-600">{{ $c->sort_order }}</td>
                        <td class="px-6 py-3">
                            @if ($c->is_published)
                                <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-semibold text-green-600"><span class="h-1.5 w-1.5 rounded-full bg-green-500"></span> Published</span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-500"><span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span> Hidden</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-right">
                            <a href="{{ route('admin.mvv.edit', $c) }}" class="text-sm font-semibold text-brand-red-500 hover:text-brand-red-600">Edit</a>
                            <form method="POST" action="{{ route('admin.mvv.destroy', $c) }}" class="inline" onsubmit="return confirm('Delete this card?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="ml-3 text-sm text-slate-500 hover:text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

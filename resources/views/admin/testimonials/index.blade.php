@extends('admin.layouts.admin')

@section('title', 'Testimonials')
@section('breadcrumb', 'Content')

@section('content')
<div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-6 py-4">
        <div>
            <h2 class="text-base font-semibold text-slate-900">Stories of Hope &amp; Change</h2>
            <p class="text-sm text-slate-500">Testimonials shown on the dark burgundy section of the homepage. {{ $testimonials->count() }} total.</p>
        </div>
        <a href="{{ route('admin.testimonials.create') }}"
           class="inline-flex items-center gap-1.5 rounded-full bg-brand-red-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-red-600">
            + New testimonial
        </a>
    </div>

    @if ($testimonials->isEmpty())
        <div class="px-6 py-12 text-center text-sm text-slate-500">
            No testimonials yet. <a href="{{ route('admin.testimonials.create') }}" class="font-semibold text-brand-red-500">Add the first one</a>.
        </div>
    @else
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-6 py-3">Photo</th>
                    <th class="px-6 py-3">Author</th>
                    <th class="px-6 py-3">Quote</th>
                    <th class="px-6 py-3">Order</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($testimonials as $t)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-3">
                            @if ($t->photoUrl())
                                <img src="{{ $t->photoUrl() }}" alt="" class="h-12 w-12 rounded-full object-cover ring-1 ring-slate-200">
                            @else
                                <div class="grid h-12 w-12 place-items-center rounded-full bg-slate-100 text-xs font-semibold text-slate-400">
                                    {{ Str::of($t->author_name)->substr(0, 1)->upper() }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-3">
                            <a href="{{ route('admin.testimonials.edit', $t) }}" class="font-semibold text-slate-900 hover:text-brand-red-500">
                                {{ $t->author_name }}
                            </a>
                            @if ($t->author_role)
                                <div class="text-xs text-slate-500">{{ $t->author_role }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-sm text-slate-600">
                            <span class="text-slate-400">“</span>{{ Str::limit($t->quote, 100) }}<span class="text-slate-400">”</span>
                        </td>
                        <td class="px-6 py-3 text-slate-600">{{ $t->sort_order }}</td>
                        <td class="px-6 py-3">
                            @if ($t->is_published)
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
                            <a href="{{ route('admin.testimonials.edit', $t) }}" class="text-sm font-semibold text-brand-red-500 hover:text-brand-red-600">Edit</a>
                            <x-admin.confirm-delete :action="route('admin.testimonials.destroy', $t)"
                                                    title="Delete this testimonial?"
                                                    :message="'The story from ' . $t->author_name . ' will be permanently removed.'"
                                                    class="ml-3 text-sm text-slate-500 hover:text-red-600" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

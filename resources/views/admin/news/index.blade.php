@extends('admin.layouts.admin')

@section('title', 'News & events')
@section('breadcrumb', 'Content')

@section('content')
<div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-6 py-4">
        <div>
            <h2 class="text-base font-semibold text-slate-900">News &amp; events</h2>
            <p class="text-sm text-slate-500">Published articles ordered newest first; the homepage shows the latest 3. {{ $articles->total() }} total.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <x-admin.search-box placeholder="Search title or excerpt…" :value="$q" />
            <a href="{{ route('admin.news.create') }}"
               class="inline-flex items-center gap-1.5 rounded-full bg-brand-red-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-red-600">
                + New
            </a>
        </div>
    </div>

    @if ($articles->isEmpty())
        <div class="px-6 py-12 text-center text-sm text-slate-500">
            @if (filled($q))
                No articles match "<strong class="text-slate-700">{{ $q }}</strong>".
                <a href="{{ route('admin.news.index') }}" class="font-semibold text-brand-red-500">Clear search</a>.
            @else
                No articles yet. <a href="{{ route('admin.news.create') }}" class="font-semibold text-brand-red-500">Write the first one</a>.
            @endif
        </div>
    @else
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-6 py-3">Image</th>
                    <th class="px-6 py-3">Title</th>
                    <th class="px-6 py-3">Category</th>
                    <th class="px-6 py-3">Published</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($articles as $article)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-3">
                            @if ($article->imageUrl())
                                <img src="{{ $article->imageUrl() }}" alt="" class="h-12 w-16 rounded-lg object-cover ring-1 ring-slate-200">
                            @else
                                <div class="grid h-12 w-16 place-items-center rounded-lg bg-slate-100 text-xs text-slate-400">No image</div>
                            @endif
                        </td>
                        <td class="px-6 py-3">
                            <a href="{{ route('admin.news.edit', $article) }}" class="font-semibold text-slate-900 hover:text-brand-red-500">
                                {{ $article->title }}
                            </a>
                            <div class="text-xs text-slate-500">{{ Str::limit($article->excerpt, 90) }}</div>
                        </td>
                        <td class="px-6 py-3">
                            @if ($article->category)
                                <span class="inline-flex rounded-full bg-brand-red-50 px-2.5 py-0.5 text-xs font-semibold text-brand-red-500">
                                    {{ $article->category }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-3">
                            @if (! $article->published_at)
                                <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-500">
                                    Draft
                                </span>
                            @elseif ($article->published_at->isFuture())
                                <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700">
                                    Scheduled · {{ $article->published_at->format('M j, Y') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-semibold text-green-600">
                                    <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span> {{ $article->published_at->format('M j, Y') }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-right">
                            <a href="{{ route('admin.news.edit', $article) }}" class="text-sm font-semibold text-brand-red-500 hover:text-brand-red-600">Edit</a>
                            <x-admin.confirm-delete :action="route('admin.news.destroy', $article)"
                                                    title="Delete this article?"
                                                    :message="'“' . $article->title . '” will be permanently removed.'"
                                                    class="ml-3 text-sm text-slate-500 hover:text-red-600" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="border-t border-slate-200 px-6 py-3">
            {{ $articles->links() }}
        </div>
    @endif
</div>
@endsection

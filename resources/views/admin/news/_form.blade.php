@php $submitLabel = $submitLabel ?? 'Save'; @endphp
<form method="POST" action="{{ $article->exists ? route('admin.news.update', $article) : route('admin.news.store') }}"
      enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if ($article->exists)
        @method('PATCH')
    @endif

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-5 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Title</label>
                <input type="text" name="title" required value="{{ old('title', $article->title) }}"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                @if ($article->exists)
                    <p class="mt-1 text-xs text-slate-400">Slug: <code>{{ $article->slug }}</code> (regenerated when the title changes)</p>
                @endif
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Category</label>
                <input type="text" name="category" value="{{ old('category', $article->category) }}"
                       placeholder="Initiative / Report / Partnership …"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Publish date &amp; time</label>
                <input type="datetime-local" name="published_at"
                       value="{{ old('published_at', optional($article->published_at)->format('Y-m-d\TH:i')) }}"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                <p class="mt-1 text-xs text-slate-400">Leave blank for a draft. Future date schedules visibility.</p>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Excerpt</label>
                <textarea name="excerpt" rows="3"
                          class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">{{ old('excerpt', $article->excerpt) }}</textarea>
                <p class="mt-1 text-xs text-slate-400">Short summary shown on the homepage card. 1–2 sentences.</p>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Body</label>
                <div class="mt-2">
                    <textarea name="body" data-rte rows="12">{{ old('body', $article->body) }}</textarea>
                </div>
                <p class="mt-1 text-xs text-slate-400">Full article body. Rendered on the public news detail page.</p>
            </div>
        </div>

        <div class="mt-6">
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Cover image</label>
            @if ($article->imageUrl())
                <div class="mt-2 flex items-center gap-4">
                    <img src="{{ $article->imageUrl() }}" alt="" class="h-24 w-32 rounded-lg object-cover ring-1 ring-slate-200">
                    <label class="inline-flex items-center gap-2 text-sm">
                        <input type="checkbox" name="remove_image" value="1" class="h-4 w-4 rounded border-slate-300 text-brand-red-500 focus:ring-brand-red-500">
                        <span class="text-slate-700">Remove current image</span>
                    </label>
                </div>
            @endif
            <input type="file" name="image" accept="image/*"
                   class="mt-2 block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200">
            <p class="mt-1 text-xs text-slate-400">JPG/PNG/WebP, up to 5 MB. Recommended ratio 16:10.</p>
        </div>
    </div>

    <div class="sticky bottom-0 -mx-5 flex items-center justify-between border-t border-slate-200 bg-white/95 px-5 py-3 backdrop-blur lg:-mx-8 lg:px-8">
        <a href="{{ route('admin.news.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-slate-800">
            <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M17 10a.75.75 0 0 1-.75.75H5.6l4.18 3.96a.75.75 0 1 1-1.08 1.04l-5.5-5.75a.75.75 0 0 1 0-1.04l5.5-5.75a.75.75 0 1 1 1.08 1.04L5.6 9.25h10.65A.75.75 0 0 1 17 10Z"/></svg>
            Back
        </a>
        <button type="submit"
                class="inline-flex items-center gap-1.5 rounded-full bg-brand-red-500 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-red-600">
            <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path fill-rule="evenodd" d="M16.7 5.3a1 1 0 0 1 0 1.4l-7.5 7.5a1 1 0 0 1-1.4 0L3.3 9.7a1 1 0 1 1 1.4-1.4l3.8 3.8 6.8-6.8a1 1 0 0 1 1.4 0Z" clip-rule="evenodd"/></svg>
            {{ $submitLabel }}
        </button>
    </div>
</form>

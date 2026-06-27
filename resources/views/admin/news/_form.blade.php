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
            <x-admin.image-input
                label="Cover image"
                :current-url="$article->imageUrl()"
                help-text="JPG, PNG or WebP, up to 5 MB. Recommended ratio 16:10." />
        </div>
    </div>

    <x-admin.form-actions :back-to="route('admin.news.index')" :submit-label="$submitLabel" />
</form>

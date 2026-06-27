@php $submitLabel = $submitLabel ?? 'Save'; @endphp
<form method="POST" action="{{ $programme->exists ? route('admin.programmes.update', $programme) : route('admin.programmes.store') }}"
      enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if ($programme->exists)
        @method('PATCH')
    @endif

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-5 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Title</label>
                <input type="text" name="title" required value="{{ old('title', $programme->title) }}"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Category</label>
                <input type="text" name="category" value="{{ old('category', $programme->category) }}"
                       placeholder="Agriculture / Healthcare / …"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">"Learn more" URL</label>
                <input type="text" name="url" value="{{ old('url', $programme->url) }}" placeholder="https://… or #"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Body</label>
                <div class="mt-2">
                    <textarea name="body" data-rte rows="10">{{ old('body', $programme->body) }}</textarea>
                </div>
                <p class="mt-1 text-xs text-slate-400">Full programme body. Rendered on the public programme detail page.</p>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Sort order</label>
                <input type="number" name="sort_order" min="0" max="999" value="{{ old('sort_order', $programme->sort_order) }}"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                <p class="mt-1 text-xs text-slate-400">Lowest number first.</p>
            </div>

            <div class="flex items-end">
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $programme->is_published))
                           class="h-4 w-4 rounded border-slate-300 text-brand-red-500 focus:ring-brand-red-500">
                    <span class="font-semibold text-slate-700">Published (visible on homepage)</span>
                </label>
            </div>
        </div>

        <div class="mt-6">
            <x-admin.image-input
                label="Image"
                :current-url="$programme->imageUrl()"
                help-text="JPG, PNG or WebP, up to 5 MB. Recommended ratio 16:9." />
        </div>
    </div>

    <x-admin.form-actions :back-to="route('admin.programmes.index')" :submit-label="$submitLabel" />
</form>

@php $submitLabel = $submitLabel ?? 'Save'; @endphp
<form method="POST" action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}"
      enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if ($service->exists)
        @method('PATCH')
    @endif

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-5 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Title</label>
                <input type="text" name="title" required value="{{ old('title', $service->title) }}"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Category / Eyebrow</label>
                <input type="text" name="category" value="{{ old('category', $service->category) }}"
                       placeholder="Self-Assessment Scorecard / Guidebook Series / …"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                <p class="mt-1 text-xs text-slate-400">Small label shown above the title (e.g. "SELF-ASSESSMENT SCORECARD").</p>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">"Learn more" URL</label>
                <input type="text" name="url" value="{{ old('url', $service->url) }}" placeholder="https://… or #"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Summary</label>
                <textarea name="summary" rows="3"
                          class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">{{ old('summary', $service->summary) }}</textarea>
                <p class="mt-1 text-xs text-slate-400">One or two sentences shown on the services listing card.</p>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Body</label>
                <div class="mt-2">
                    <textarea name="body" data-rte rows="12">{{ old('body', $service->body) }}</textarea>
                </div>
                <p class="mt-1 text-xs text-slate-400">Full service body. Rendered on the public service detail page.</p>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Sort order</label>
                <input type="number" name="sort_order" min="0" max="999" value="{{ old('sort_order', $service->sort_order) }}"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                <p class="mt-1 text-xs text-slate-400">Lowest number first.</p>
            </div>

            <div class="flex items-end">
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $service->is_published))
                           class="h-4 w-4 rounded border-slate-300 text-brand-red-500 focus:ring-brand-red-500">
                    <span class="font-semibold text-slate-700">Published (visible on site)</span>
                </label>
            </div>
        </div>

        <div class="mt-6">
            <x-admin.image-input
                label="Image"
                :current-url="$service->imageUrl()"
                help-text="JPG, PNG or WebP, up to 5 MB. Recommended ratio 16:9." />
        </div>
    </div>

    <x-admin.form-actions :back-to="route('admin.services.index')" :submit-label="$submitLabel" />
</form>

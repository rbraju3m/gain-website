@php $submitLabel = $submitLabel ?? 'Save'; @endphp
<form method="POST" action="{{ $image->exists ? route('admin.gallery-images.update', $image) : route('admin.gallery-images.store') }}"
      enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if ($image->exists)
        @method('PATCH')
    @endif

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Year</label>
                <select name="gallery_year_id" required
                        class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                    @foreach ($allYears as $y)
                        <option value="{{ $y->id }}" @selected(old('gallery_year_id', $image->gallery_year_id) == $y->id)>
                            {{ $y->year }}@if ($y->title) — {{ $y->title }}@endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Title</label>
                <input type="text" name="title" required value="{{ old('title', $image->title) }}"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Description (optional)</label>
                <textarea name="description" rows="3"
                          class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">{{ old('description', $image->description) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Sort order</label>
                <input type="number" name="sort_order" min="0" max="999" value="{{ old('sort_order', $image->sort_order) }}"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            <div class="flex items-end">
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $image->is_published))
                           class="h-4 w-4 rounded border-slate-300 text-brand-red-500 focus:ring-brand-red-500">
                    <span class="font-semibold text-slate-700">Published (visible on public gallery)</span>
                </label>
            </div>
        </div>

        <div class="mt-6">
            <x-admin.image-input
                label="Image"
                :current-url="$image->imageUrl()"
                help-text="JPG, PNG or WebP, up to 5 MB." />
        </div>
    </div>

    <x-admin.form-actions :back-to="route('admin.gallery-images.index', ['year_id' => $image->gallery_year_id])" :submit-label="$submitLabel" />
</form>

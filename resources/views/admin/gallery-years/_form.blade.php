@php $submitLabel = $submitLabel ?? 'Save'; @endphp
<form method="POST" action="{{ $year->exists ? route('admin.gallery-years.update', $year) : route('admin.gallery-years.store') }}"
      class="space-y-6">
    @csrf
    @if ($year->exists)
        @method('PATCH')
    @endif

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Year</label>
                <input type="number" name="year" required min="1900" max="2100" value="{{ old('year', $year->year) }}"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                <p class="mt-1 text-xs text-slate-400">Must be unique across the gallery.</p>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Title (optional)</label>
                <input type="text" name="title" value="{{ old('title', $year->title) }}"
                       placeholder="E.g. Community Kitchens Rollout"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Description (optional)</label>
                <textarea name="description" rows="3"
                          class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">{{ old('description', $year->description) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Sort order</label>
                <input type="number" name="sort_order" min="0" max="999" value="{{ old('sort_order', $year->sort_order) }}"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                <p class="mt-1 text-xs text-slate-400">Lowest number first. Ties broken by newest year.</p>
            </div>

            <div class="flex items-end">
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $year->is_published))
                           class="h-4 w-4 rounded border-slate-300 text-brand-red-500 focus:ring-brand-red-500">
                    <span class="font-semibold text-slate-700">Published (visible on public gallery)</span>
                </label>
            </div>
        </div>
    </div>

    <x-admin.form-actions :back-to="route('admin.gallery-years.index')" :submit-label="$submitLabel" />
</form>

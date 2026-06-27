@php $submitLabel = $submitLabel ?? 'Save'; @endphp
<form method="POST" action="{{ $partner->exists ? route('admin.partners.update', $partner) : route('admin.partners.store') }}"
      enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if ($partner->exists)
        @method('PATCH')
    @endif

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-5 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Name</label>
                <input type="text" name="name" required value="{{ old('name', $partner->name) }}"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                @if ($partner->exists)
                    <p class="mt-1 text-xs text-slate-400">Slug: <code>{{ $partner->slug }}</code></p>
                @endif
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Group</label>
                <select name="group"
                        class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                    @foreach (\App\Models\Partner::GROUPS as $value => $label)
                        <option value="{{ $value }}" @selected(old('group', $partner->group) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-slate-400">Strategic = row 1 (static grid). Implementing = row 2 (marquee).</p>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Website URL</label>
                <input type="text" name="url" value="{{ old('url', $partner->url) }}" placeholder="https://…"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Sort order</label>
                <input type="number" name="sort_order" min="0" max="999" value="{{ old('sort_order', $partner->sort_order) }}"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            <div class="flex items-end">
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $partner->is_published))
                           class="h-4 w-4 rounded border-slate-300 text-brand-red-500 focus:ring-brand-red-500">
                    <span class="font-semibold text-slate-700">Published (visible on homepage)</span>
                </label>
            </div>
        </div>

        <div class="mt-6">
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Logo</label>
            @if ($partner->logoUrl())
                <div class="mt-2 flex items-center gap-4">
                    <div class="flex h-20 w-40 items-center justify-center rounded-lg bg-slate-50 ring-1 ring-slate-200">
                        <img src="{{ $partner->logoUrl() }}" alt="" class="max-h-16 max-w-32 object-contain">
                    </div>
                    @if ($partner->getFirstMedia('logo'))
                        <label class="inline-flex items-center gap-2 text-sm">
                            <input type="checkbox" name="remove_logo" value="1" class="h-4 w-4 rounded border-slate-300 text-brand-red-500 focus:ring-brand-red-500">
                            <span class="text-slate-700">Remove uploaded logo (fall back to demo SVG)</span>
                        </label>
                    @else
                        <span class="text-xs text-slate-500">Showing built-in demo SVG (no upload yet)</span>
                    @endif
                </div>
            @endif
            <input type="file" name="logo" accept="image/svg+xml,image/png,image/jpeg,image/webp"
                   class="mt-2 block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200">
            <p class="mt-1 text-xs text-slate-400">SVG (preferred), PNG, JPG or WebP. Up to 2 MB.</p>
        </div>
    </div>

    <x-admin.form-actions :back-to="route('admin.partners.index')" :submit-label="$submitLabel" />
</form>

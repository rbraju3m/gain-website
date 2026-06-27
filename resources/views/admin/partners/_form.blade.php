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
            <x-admin.image-input
                name="logo"
                remove-name="remove_logo"
                label="Logo"
                :current-url="$partner->getFirstMedia('logo') ? $partner->logoUrl() : null"
                accept="image/svg+xml,image/png,image/jpeg,image/webp"
                preview-class="h-24 w-40 bg-slate-50 p-3"
                fit="contain"
                help-text="SVG (preferred), PNG, JPG or WebP. Up to 2 MB." />
            @if (! $partner->getFirstMedia('logo') && $partner->logoUrl())
                <p class="mt-3 text-xs italic text-slate-500">Showing built-in demo SVG — upload a logo to replace it.</p>
            @endif
        </div>
    </div>

    <x-admin.form-actions :back-to="route('admin.partners.index')" :submit-label="$submitLabel" />
</form>

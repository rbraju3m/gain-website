@php $submitLabel = $submitLabel ?? 'Save'; @endphp
<form method="POST" action="{{ $slide->exists ? route('admin.hero-slides.update', $slide) : route('admin.hero-slides.store') }}"
      enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if ($slide->exists)
        @method('PATCH')
    @endif

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-sm font-semibold text-slate-900">Image</h3>
        <x-admin.image-input
            label="Slide image"
            :current-url="$slide->imageUrl()"
            help-text="JPG, PNG or WebP, up to 5 MB. Recommended ratio 4:5 (portrait)." />

        <div class="mt-5">
            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Image alt text</label>
            <input type="text" name="image_alt" value="{{ old('image_alt', $slide->image_alt) }}"
                   placeholder="Short description of the image (for accessibility)"
                   class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-4">
            <h3 class="text-sm font-semibold text-slate-900">Slide copy</h3>
            <p class="mt-1 text-xs text-slate-500">Leave a field blank to fall back to the value from <a href="{{ route('admin.settings.edit') }}" class="font-semibold text-brand-red-500 hover:underline">Site Settings → Hero</a>.</p>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Badge</label>
                <input type="text" name="badge" value="{{ old('badge', $slide->badge) }}"
                       placeholder="{{ setting('hero.badge', 'Transforming Lives Through Nutrition') }}"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Heading — line 1</label>
                <input type="text" name="line1" value="{{ old('line1', $slide->line1) }}"
                       placeholder="{{ setting('hero.line1', 'Nourishing') }}"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            <div class="grid grid-cols-3 gap-2">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Line 2 — prefix</label>
                    <input type="text" name="line2_prefix" value="{{ old('line2_prefix', $slide->line2_prefix) }}"
                           placeholder="{{ setting('hero.line2_prefix', '') }}"
                           class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Accent (green underline)</label>
                    <input type="text" name="line2_accent" value="{{ old('line2_accent', $slide->line2_accent) }}"
                           placeholder="{{ setting('hero.line2_accent', 'Communities') }}"
                           class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Line 2 — suffix</label>
                    <input type="text" name="line2_suffix" value="{{ old('line2_suffix', $slide->line2_suffix) }}"
                           placeholder="{{ setting('hero.line2_suffix', ',') }}"
                           class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2 md:col-span-2">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Line 3 — prefix</label>
                    <input type="text" name="line3_prefix" value="{{ old('line3_prefix', $slide->line3_prefix) }}"
                           placeholder="{{ setting('hero.line3_prefix', 'Building') }}"
                           class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Accent (red underline)</label>
                    <input type="text" name="line3_accent" value="{{ old('line3_accent', $slide->line3_accent) }}"
                           placeholder="{{ setting('hero.line3_accent', 'Futures') }}"
                           class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Sub-headline</label>
                <textarea name="subhead" rows="3"
                          placeholder="{{ setting('hero.subhead', '') }}"
                          class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">{{ old('subhead', $slide->subhead) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Primary CTA label</label>
                    <input type="text" name="cta_primary_label" value="{{ old('cta_primary_label', $slide->cta_primary_label) }}"
                           placeholder="{{ setting('hero.cta_primary_label', 'Join Our Mission') }}"
                           class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Primary CTA URL</label>
                    <input type="text" name="cta_primary_url" value="{{ old('cta_primary_url', $slide->cta_primary_url) }}"
                           placeholder="{{ setting('hero.cta_primary_url', '#mission') }}"
                           class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Secondary CTA label</label>
                    <input type="text" name="cta_secondary_label" value="{{ old('cta_secondary_label', $slide->cta_secondary_label) }}"
                           placeholder="{{ setting('hero.cta_secondary_label', 'Learn More') }}"
                           class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Secondary CTA URL</label>
                    <input type="text" name="cta_secondary_url" value="{{ old('cta_secondary_url', $slide->cta_secondary_url) }}"
                           placeholder="{{ setting('hero.cta_secondary_url', '#learn-more') }}"
                           class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                </div>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Sort order</label>
                <input type="number" name="sort_order" min="0" max="999" value="{{ old('sort_order', $slide->sort_order) }}"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                <p class="mt-1 text-xs text-slate-400">Lowest number first.</p>
            </div>

            <div class="flex items-end">
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $slide->is_published))
                           class="h-4 w-4 rounded border-slate-300 text-brand-red-500 focus:ring-brand-red-500">
                    <span class="font-semibold text-slate-700">Published (visible in the hero carousel)</span>
                </label>
            </div>
        </div>
    </div>

    <x-admin.form-actions :back-to="route('admin.hero-slides.index')" :submit-label="$submitLabel" />
</form>

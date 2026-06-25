@php $submitLabel = $submitLabel ?? 'Save'; @endphp
<form method="POST" action="{{ $stat->exists ? route('admin.impact.update', $stat) : route('admin.impact.store') }}" class="space-y-6">
    @csrf
    @if ($stat->exists) @method('PATCH') @endif

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-5 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Label</label>
                <input type="text" name="label" required value="{{ old('label', $stat->label) }}"
                       placeholder="e.g. Families Served"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Counter (numeric)</label>
                <input type="number" min="0" name="counter" required value="{{ old('counter', $stat->counter ?? 0) }}"
                       placeholder="e.g. 15000"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                <p class="mt-1 text-xs text-slate-400">The number animates up to this value on the homepage.</p>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Suffix</label>
                <input type="text" name="suffix" value="{{ old('suffix', $stat->suffix) }}"
                       placeholder="+, %, or blank"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Colour tone</label>
                <select name="tone" required
                        class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                    @foreach (\App\Models\ImpactStat::TONES as $tone)
                        <option value="{{ $tone }}" @selected(old('tone', $stat->tone) === $tone)>{{ ucfirst($tone) }}</option>
                    @endforeach
                </select>
            </div>

            @include('admin._partials.icon-select', ['name' => 'icon_key', 'selected' => $stat->icon_key, 'label' => 'Icon'])

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Sort order</label>
                <input type="number" name="sort_order" min="0" max="999" value="{{ old('sort_order', $stat->sort_order) }}"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            <div class="flex items-end">
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $stat->is_published))
                           class="h-4 w-4 rounded border-slate-300 text-brand-red-500 focus:ring-brand-red-500">
                    <span class="font-semibold text-slate-700">Published</span>
                </label>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.impact.index') }}" class="text-sm text-slate-500 hover:text-slate-800">← Back</a>
        <button type="submit" class="rounded-full bg-brand-red-500 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-red-600">{{ $submitLabel }}</button>
    </div>
</form>

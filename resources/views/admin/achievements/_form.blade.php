@php
    $submitLabel = $submitLabel ?? 'Save';
    $maxRows     = \App\Models\Achievement::MAX_ROWS;
    $existingRows = $achievement->rows ?? [];
@endphp
<form method="POST" action="{{ $achievement->exists ? route('admin.achievements.update', $achievement) : route('admin.achievements.store') }}" class="space-y-6">
    @csrf
    @if ($achievement->exists) @method('PATCH') @endif

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-5 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Card title</label>
                <input type="text" name="title" required value="{{ old('title', $achievement->title) }}"
                       placeholder="e.g. Workers Empowered"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            @include('admin._partials.icon-select', ['name' => 'icon_key', 'selected' => $achievement->icon_key, 'label' => 'Icon'])

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Sort order</label>
                <input type="number" name="sort_order" min="0" max="999" value="{{ old('sort_order', $achievement->sort_order) }}"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            <div class="flex items-end">
                <label class="inline-flex items-center gap-2 text-sm">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $achievement->is_published))
                           class="h-4 w-4 rounded border-slate-300 text-brand-red-500 focus:ring-brand-red-500">
                    <span class="font-semibold text-slate-700">Published</span>
                </label>
            </div>
        </div>

        <h4 class="mt-8 text-sm font-semibold text-slate-700">Metric rows</h4>
        <p class="text-xs text-slate-500">Up to {{ $maxRows }} rows. Leave a row blank to skip it.</p>

        <div class="mt-4 space-y-3">
            @for ($i = 0; $i < $maxRows; $i++)
                @php $row = $existingRows[$i] ?? ['label' => '', 'value' => '', 'tone' => 'red']; @endphp
                <div class="grid grid-cols-1 gap-3 rounded-xl border border-slate-200 p-3 md:grid-cols-[1fr_180px_140px]">
                    <input type="text" name="rows[{{ $i }}][label]" value="{{ old("rows.$i.label", $row['label'] ?? '') }}"
                           placeholder="Label (e.g. Total Reached)"
                           class="rounded-lg border border-slate-200 px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                    <input type="text" name="rows[{{ $i }}][value]" value="{{ old("rows.$i.value", $row['value'] ?? '') }}"
                           placeholder="Value (e.g. 71,000+)"
                           class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-mono shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                    <select name="rows[{{ $i }}][tone]"
                            class="rounded-lg border border-slate-200 px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                        @foreach (\App\Models\Achievement::ROW_TONES as $tone)
                            <option value="{{ $tone }}" @selected(old("rows.$i.tone", $row['tone'] ?? 'red') === $tone)>{{ ucfirst($tone) }}</option>
                        @endforeach
                    </select>
                </div>
            @endfor
        </div>
    </div>

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.achievements.index') }}" class="text-sm text-slate-500 hover:text-slate-800">← Back</a>
        <button type="submit" class="rounded-full bg-brand-red-500 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-red-600">{{ $submitLabel }}</button>
    </div>
</form>

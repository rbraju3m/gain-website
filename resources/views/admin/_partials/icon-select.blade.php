@php
    $name     = $name     ?? 'icon_key';
    $selected = $selected ?? null;
    $label    = $label    ?? 'Icon';
    $hint     = $hint     ?? null;
@endphp
<div>
    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $label }}</label>
    <div class="mt-2 flex items-center gap-3">
        <select name="{{ $name }}"
                class="flex-1 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            <option value="">— None —</option>
            @foreach (\App\Support\Icons::options() as $key => $optLabel)
                <option value="{{ $key }}" @selected(old($name, $selected) === $key)>{{ $optLabel }}</option>
            @endforeach
        </select>
        @if ($selected && $svg = \App\Support\Icons::svg($selected))
            <span class="grid h-9 w-9 place-items-center rounded-lg bg-slate-100 text-slate-700">
                <svg viewBox="0 0 24 24" class="h-5 w-5">{!! $svg !!}</svg>
            </span>
        @endif
    </div>
    @if ($hint)
        <p class="mt-1 text-xs text-slate-400">{{ $hint }}</p>
    @endif
</div>

@props([
    'name' => 'image',
    'currentUrl' => null,
    'label' => 'Image',
    'helpText' => 'JPG, PNG or WebP, up to 5 MB.',
    'removeName' => 'remove_image',
    'previewClass' => 'h-28 w-36',
    'accept' => 'image/jpeg,image/png,image/webp',
    'fit' => 'cover', // 'cover' | 'contain'
])
@php $fitClass = $fit === 'contain' ? 'object-contain' : 'object-cover'; @endphp

<div x-data="{
    preview: null,
    fileName: null,
    handleChange(e) {
        const f = e.target.files && e.target.files[0];
        if (! f) { this.preview = null; this.fileName = null; return; }
        this.fileName = f.name + ' · ' + (f.size / 1024 < 1024
            ? (f.size / 1024).toFixed(1) + ' KB'
            : (f.size / 1024 / 1024).toFixed(1) + ' MB');
        const reader = new FileReader();
        reader.onload = ev => { this.preview = ev.target.result; };
        reader.readAsDataURL(f);
    }
}">
    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $label }}</label>

    <div class="mt-2 flex flex-wrap items-start gap-4">
        {{-- Live / current preview --}}
        <div class="relative {{ $previewClass }} shrink-0 overflow-hidden rounded-lg bg-slate-50 ring-1 ring-slate-200">
            <template x-if="preview">
                <img :src="preview" alt="New image preview" class="h-full w-full {{ $fitClass }}">
            </template>
            <template x-if="!preview">
                @if ($currentUrl)
                    <img src="{{ $currentUrl }}" alt="Current image" class="h-full w-full {{ $fitClass }}">
                @else
                    <div class="grid h-full w-full place-items-center text-xs text-slate-400">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6 opacity-60"><path d="M4 4h16v16H4z"/><path d="m4 16 5-5 4 4 4-4 3 3"/><circle cx="8" cy="9" r="1.5"/></svg>
                    </div>
                @endif
            </template>
            <span x-show="preview" x-cloak
                  class="absolute right-1.5 top-1.5 rounded-full bg-brand-red-500 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white">
                Preview
            </span>
        </div>

        <div class="min-w-0 flex-1">
            <input type="file" name="{{ $name }}" accept="{{ $accept }}"
                   @change="handleChange($event)"
                   class="block w-full text-sm text-slate-600 file:mr-3 file:cursor-pointer file:rounded-lg file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200">
            <p class="mt-1.5 text-xs text-slate-400">{{ $helpText }}</p>
            <p x-show="fileName" x-cloak class="mt-1 truncate text-xs font-medium text-slate-700"
               x-text="'Selected: ' + fileName"></p>

            @if ($currentUrl)
                <label class="mt-3 inline-flex items-center gap-2 text-sm">
                    <input type="checkbox" name="{{ $removeName }}" value="1"
                           class="h-4 w-4 rounded border-slate-300 text-brand-red-500 focus:ring-brand-red-500">
                    <span class="text-slate-700">Remove current image</span>
                </label>
            @endif
        </div>
    </div>
</div>

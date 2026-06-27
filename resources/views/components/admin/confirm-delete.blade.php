@props([
    'action',
    'label' => 'Delete',
    'title' => 'Delete this item?',
    'message' => 'This action cannot be undone.',
])

<div x-data="{ open: false }" class="inline-block" @keydown.escape.window="open = false">
    <button type="button" @click="open = true"
            {{ $attributes->merge(['class' => 'text-sm text-slate-500 hover:text-red-600']) }}>
        {{ $label }}
    </button>

    {{-- Modal --}}
    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[70] flex items-center justify-center bg-slate-900/55 p-4 backdrop-blur-sm"
         @click.self="open = false">
        <div x-show="open" x-cloak
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
             class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-card ring-1 ring-black/5"
             role="dialog" aria-modal="true">

            <div class="flex items-start gap-4 px-6 pt-6">
                <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full bg-red-100 text-red-600">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                        <path d="M12 9v4M12 17h.01M10.3 3.86a1.5 1.5 0 0 1 2.6 0l7.9 13.67a1.5 1.5 0 0 1-1.3 2.25H3.69a1.5 1.5 0 0 1-1.3-2.25l7.9-13.67Z"/>
                    </svg>
                </span>
                <div class="flex-1">
                    <h3 class="font-display text-lg font-semibold text-slate-900">{{ $title }}</h3>
                    <p class="mt-1 text-sm text-slate-600">{{ $message }}</p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-2 border-t border-slate-100 bg-slate-50 px-6 py-4">
                <button type="button" @click="open = false"
                        class="rounded-full px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                    Cancel
                </button>
                <form method="POST" action="{{ $action }}">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-1.5 rounded-full bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path fill-rule="evenodd" d="M9 2a1 1 0 0 0-.894.553L7.382 4H4a1 1 0 1 0 0 2v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V6a1 1 0 1 0 0-2h-3.382l-.724-1.447A1 1 0 0 0 11 2H9Zm-3 5a1 1 0 1 1 2 0v7a1 1 0 1 1-2 0V7Zm5-1a1 1 0 0 0-1 1v7a1 1 0 1 0 2 0V7a1 1 0 0 0-1-1Z" clip-rule="evenodd"/></svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

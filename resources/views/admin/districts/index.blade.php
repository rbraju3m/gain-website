@extends('admin.layouts.admin')

@section('title', 'Map · Districts')
@section('breadcrumb', 'Map')

@section('content')
<form method="POST" action="{{ route('admin.districts.update-active') }}"
      x-data="{ search: '' }">
    @csrf
    @method('PATCH')

    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200 px-6 py-4">
            <div>
                <h2 class="text-base font-semibold text-slate-900">Active programme districts</h2>
                <p class="text-sm text-slate-500">
                    Tick a district to mark it as having an active programme. Public map
                    shows ticked districts as pulsing red dots; the rest are small grey dots.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <input type="search" x-model="search" placeholder="Search districts…"
                       class="w-56 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                <button type="submit" class="rounded-full bg-brand-red-500 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-red-600">
                    Save changes
                </button>
            </div>
        </div>

        <div class="divide-y divide-slate-200">
            @foreach ($divisions as $div)
                @php $divDistricts = $div->districts; @endphp
                <div class="px-6 py-5"
                     x-data="{
                        get filtered() {
                            const q = (search || '').trim().toLowerCase();
                            const cards = Array.from($el.querySelectorAll('[data-name]'));
                            cards.forEach(c => {
                                const match = q === '' || c.dataset.name.toLowerCase().includes(q);
                                c.classList.toggle('hidden', !match);
                            });
                            return null;
                        },
                        toggleAll(state) {
                            $el.querySelectorAll('input[type=checkbox]').forEach(cb => cb.checked = state);
                        }
                     }"
                     x-effect="filtered">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <h3 class="text-base font-semibold text-slate-900">{{ $div->name }} Division</h3>
                            <p class="text-xs text-slate-500">
                                {{ $divDistricts->where('is_active', true)->count() }} of {{ $divDistricts->count() }} currently active
                            </p>
                        </div>
                        <div class="flex items-center gap-2 text-xs">
                            <button type="button" @click="toggleAll(true)" class="rounded-full bg-green-50 px-3 py-1 font-semibold text-green-600 hover:bg-green-100">Tick all</button>
                            <button type="button" @click="toggleAll(false)" class="rounded-full bg-slate-100 px-3 py-1 font-semibold text-slate-600 hover:bg-slate-200">Clear</button>
                        </div>
                    </div>

                    <div class="mt-4 grid gap-2 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($divDistricts as $district)
                            <label data-name="{{ $district->name }}"
                                   class="flex items-center gap-3 rounded-lg border border-slate-200 px-3 py-2 text-sm transition hover:border-brand-red-300 hover:bg-brand-red-50">
                                <input type="checkbox" name="active[]" value="{{ $district->id }}"
                                       @checked($district->is_active)
                                       class="h-4 w-4 shrink-0 rounded border-slate-300 text-brand-red-500 focus:ring-brand-red-500">
                                <span class="font-medium text-slate-700">{{ $district->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex items-center justify-end border-t border-slate-200 px-6 py-4">
            <button type="submit" class="rounded-full bg-brand-red-500 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-red-600">
                Save changes
            </button>
        </div>
    </div>
</form>
@endsection

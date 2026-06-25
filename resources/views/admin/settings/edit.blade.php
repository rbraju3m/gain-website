@extends('admin.layouts.admin')

@section('title', 'Site settings')
@section('breadcrumb', 'Content')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data"
      class="space-y-6"
      x-data="{ tab: 'hero' }">
    @csrf
    @method('PATCH')

    {{-- Tabs --}}
    <div class="flex flex-wrap gap-2 border-b border-slate-200">
        @foreach ([
            'hero'   => 'Hero',
            'about'  => 'About',
            'cta'    => 'CTA',
            'footer' => 'Footer',
        ] as $k => $label)
            <button type="button" @click="tab = '{{ $k }}'"
                    :class="tab === '{{ $k }}' ? 'border-brand-red-500 text-brand-red-500' : 'border-transparent text-slate-500 hover:text-slate-800'"
                    class="-mb-px border-b-2 px-3 py-2 text-sm font-semibold transition">
                {{ $label }}
            </button>
        @endforeach
        <div class="ml-auto flex items-center">
            <button type="submit"
                    class="rounded-full bg-brand-red-500 px-5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-red-600">
                Save changes
            </button>
        </div>
    </div>

    {{-- ────────── Hero ────────── --}}
    <div x-show="tab === 'hero'" x-cloak class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-base font-semibold text-slate-900">Hero section</h3>
            <p class="mt-1 text-sm text-slate-500">The top of the homepage. Headline is rendered across 3 lines.</p>

            <div class="mt-6 grid gap-5 md:grid-cols-2">
                <x-admin.settings.field name="hero[badge]"  label="Badge text"     :value="setting('hero.badge')"/>
                <x-admin.settings.field name="hero[line1]"  label="Headline line 1" :value="setting('hero.line1')"/>

                <x-admin.settings.field name="hero[line2_prefix]" label="Line 2 — prefix" :value="setting('hero.line2_prefix')" hint="Plain text before the green accent word."/>
                <x-admin.settings.field name="hero[line2_accent]" label="Line 2 — accent (green)" :value="setting('hero.line2_accent')"/>
                <x-admin.settings.field name="hero[line2_suffix]" label="Line 2 — suffix" :value="setting('hero.line2_suffix')" hint="E.g. comma after the accent."/>
                <x-admin.settings.field name="hero[line3_prefix]" label="Line 3 — prefix" :value="setting('hero.line3_prefix')"/>
                <x-admin.settings.field name="hero[line3_accent]" label="Line 3 — accent (red)" :value="setting('hero.line3_accent')"/>
            </div>

            <div class="mt-5">
                <x-admin.settings.field name="hero[subhead]" label="Sub-headline" type="textarea" rows="3" :value="setting('hero.subhead')"/>
            </div>

            <div class="mt-5 grid gap-5 md:grid-cols-2">
                <x-admin.settings.field name="hero[cta_primary_label]"   label="Primary CTA label" :value="setting('hero.cta_primary_label')"/>
                <x-admin.settings.field name="hero[cta_primary_url]"     label="Primary CTA URL"   :value="setting('hero.cta_primary_url')"/>
                <x-admin.settings.field name="hero[cta_secondary_label]" label="Secondary CTA label" :value="setting('hero.cta_secondary_label')"/>
                <x-admin.settings.field name="hero[cta_secondary_url]"   label="Secondary CTA URL"   :value="setting('hero.cta_secondary_url')"/>
            </div>

            <div class="mt-5 grid gap-5 md:grid-cols-2">
                <x-admin.settings.field name="hero[success_value]" label="Success badge — value" :value="setting('hero.success_value')" hint="E.g. 98%"/>
                <x-admin.settings.field name="hero[success_label]" label="Success badge — label" :value="setting('hero.success_label')"/>
            </div>

            <div class="mt-5">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Hero image</label>
                @if (setting('hero.image_path'))
                    <img src="{{ asset('storage/'.setting('hero.image_path')) }}" alt="" class="mt-2 h-32 w-auto rounded-lg object-cover ring-1 ring-slate-200">
                @endif
                <input type="file" name="hero_image" accept="image/*" class="mt-2 block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200">
                <p class="mt-1 text-xs text-slate-400">JPG/PNG/WebP, up to 5 MB. Leave empty to keep current image.</p>
            </div>
        </div>
    </div>

    {{-- ────────── About ────────── --}}
    <div x-show="tab === 'about'" x-cloak class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-base font-semibold text-slate-900">About section</h3>

            <div class="mt-6 grid gap-5 md:grid-cols-2">
                <x-admin.settings.field name="about[tagline]" label="Tagline (small uppercase)" :value="setting('about.tagline')"/>
                <x-admin.settings.field name="about[line1]"   label="Headline line 1 prefix"     :value="setting('about.line1')"/>
                <x-admin.settings.field name="about[line1_accent]" label="Line 1 accent (red)"  :value="setting('about.line1_accent')"/>
                <x-admin.settings.field name="about[line2_accent]" label="Line 2 accent (red)"  :value="setting('about.line2_accent')"/>
                <x-admin.settings.field name="about[line2_suffix]" label="Line 2 suffix"        :value="setting('about.line2_suffix')"/>
                <x-admin.settings.field name="about[years_badge_value]" label="Years badge — value" :value="setting('about.years_badge_value')"/>
                <x-admin.settings.field name="about[years_badge_label]" label="Years badge — label" :value="setting('about.years_badge_label')"/>
            </div>

            <div class="mt-5 grid gap-5">
                <x-admin.settings.field name="about[paragraph_1]" label="Paragraph 1" type="textarea" rows="4" :value="setting('about.paragraph_1')"/>
                <x-admin.settings.field name="about[paragraph_2]" label="Paragraph 2" type="textarea" rows="4" :value="setting('about.paragraph_2')"/>
            </div>

            <div class="mt-5">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">About image</label>
                @if (setting('about.image_path'))
                    <img src="{{ asset('storage/'.setting('about.image_path')) }}" alt="" class="mt-2 h-32 w-auto rounded-lg object-cover ring-1 ring-slate-200">
                @endif
                <input type="file" name="about_image" accept="image/*" class="mt-2 block w-full text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200">
            </div>
        </div>
    </div>

    {{-- ────────── CTA ────────── --}}
    <div x-show="tab === 'cta'" x-cloak class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-base font-semibold text-slate-900">Call-to-action section</h3>

            <div class="mt-6 grid gap-5 md:grid-cols-2">
                <x-admin.settings.field name="cta[heading_line1]" label="Heading line 1" :value="setting('cta.heading_line1')"/>
                <x-admin.settings.field name="cta[heading_line2]" label="Heading line 2" :value="setting('cta.heading_line2')"/>
                <x-admin.settings.field name="cta[button_label]"  label="Button label"   :value="setting('cta.button_label')"/>
                <x-admin.settings.field name="cta[button_url]"    label="Button URL"     :value="setting('cta.button_url')"/>
            </div>

            <div class="mt-5">
                <x-admin.settings.field name="cta[subhead]" label="Sub-headline" type="textarea" rows="3" :value="setting('cta.subhead')"/>
            </div>

            <h4 class="mt-8 text-sm font-semibold text-slate-700">Donation tiers</h4>
            <p class="text-xs text-slate-500">Three cards under the headline.</p>
            @php $tiers = setting('cta.tiers') ?: []; @endphp
            <div class="mt-3 grid gap-4 md:grid-cols-3">
                @for ($i = 0; $i < 3; $i++)
                    @php $tier = $tiers[$i] ?? ['amount' => '', 'desc' => '', 'tone' => 'red']; @endphp
                    <div class="rounded-xl border border-slate-200 p-4">
                        <x-admin.settings.field name="cta[tiers][{{ $i }}][amount]" label="Amount" :value="$tier['amount']"/>
                        <div class="mt-3">
                            <x-admin.settings.field name="cta[tiers][{{ $i }}][desc]"   label="Description" :value="$tier['desc']"/>
                        </div>
                        <div class="mt-3">
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Color tone</label>
                            <select name="cta[tiers][{{ $i }}][tone]" class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                                @foreach (['red', 'green', 'orange'] as $tone)
                                    <option value="{{ $tone }}" @selected(old("cta.tiers.$i.tone", $tier['tone'] ?? '') === $tone)>{{ ucfirst($tone) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    {{-- ────────── Footer ────────── --}}
    <div x-show="tab === 'footer'" x-cloak class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-base font-semibold text-slate-900">Footer</h3>

            <div class="mt-6 grid gap-5">
                <x-admin.settings.field name="footer[tagline]" label="Tagline" type="textarea" rows="3" :value="setting('footer.tagline')"/>
                <x-admin.settings.field name="footer[address]" label="Address" type="textarea" rows="3" :value="setting('footer.address')" hint="Newlines render as <br>."/>
            </div>

            <div class="mt-5 grid gap-5 md:grid-cols-2">
                <x-admin.settings.field name="footer[phone]" label="Phone" :value="setting('footer.phone')"/>
                <x-admin.settings.field name="footer[email]" label="Email" type="email" :value="setting('footer.email')"/>
                <x-admin.settings.field name="footer[social][facebook]" label="Facebook URL" :value="setting('footer.social.facebook')"/>
                <x-admin.settings.field name="footer[social][twitter]"  label="Twitter / X URL" :value="setting('footer.social.twitter')"/>
                <x-admin.settings.field name="footer[social][linkedin]" label="LinkedIn URL" :value="setting('footer.social.linkedin')"/>
                <x-admin.settings.field name="footer[copyright]" label="Copyright line" :value="setting('footer.copyright')" hint="Shown after © 2026."/>
            </div>
        </div>
    </div>
</form>
@endsection

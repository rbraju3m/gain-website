@extends('admin.layouts.admin')

@section('title', 'Dashboard')
@section('breadcrumb', 'Home')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
        <h2 class="font-display text-2xl font-bold text-slate-900">
            Welcome, {{ auth()->user()->name }}.
        </h2>
        <p class="mt-2 max-w-2xl text-sm text-slate-500">
            This is the Gain admin panel. Each item in the sidebar manages a section of the public homepage.
            Items marked <em>soon</em> aren't wired up yet — they'll come online phase by phase.
        </p>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <a href="{{ url('/') }}" target="_blank"
               class="group rounded-xl border border-slate-200 p-5 transition hover:border-brand-red-500 hover:shadow-sm">
                <div class="text-xs font-semibold uppercase tracking-wider text-slate-400">Public site</div>
                <div class="mt-2 text-lg font-semibold text-slate-900 group-hover:text-brand-red-500">
                    View homepage →
                </div>
                <p class="mt-1 text-xs text-slate-500">Opens the live site in a new tab.</p>
            </a>

            <div class="rounded-xl border border-slate-200 p-5">
                <div class="text-xs font-semibold uppercase tracking-wider text-slate-400">Phase 1</div>
                <div class="mt-2 text-lg font-semibold text-green-600">Admin shell ✓</div>
                <p class="mt-1 text-xs text-slate-500">You're seeing it. Next up: Site Settings.</p>
            </div>

            <div class="rounded-xl border border-slate-200 p-5">
                <div class="text-xs font-semibold uppercase tracking-wider text-slate-400">Stack</div>
                <div class="mt-2 text-sm text-slate-700">
                    Laravel 11 · Breeze · Spatie Media Library
                </div>
            </div>
        </div>
    </div>
@endsection

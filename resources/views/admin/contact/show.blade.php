@extends('admin.layouts.admin')

@section('title', 'Message · ' . $message->name)
@section('breadcrumb', 'Messages')

@section('content')
<div class="mx-auto max-w-3xl space-y-4">

    <a href="{{ route('admin.contact.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-brand-red-500">
        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M17 10a.75.75 0 0 1-.75.75H5.6l4.18 3.96a.75.75 0 1 1-1.08 1.04l-5.5-5.75a.75.75 0 0 1 0-1.04l5.5-5.75a.75.75 0 1 1 1.08 1.04L5.6 9.25h10.65A.75.75 0 0 1 17 10Z"/></svg>
        Back to inbox
    </a>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">{{ $message->subject ?: '(no subject)' }}</h2>
                    <p class="mt-1 text-sm text-slate-500">From <span class="font-medium text-slate-800">{{ $message->name }}</span> &lt;<a href="mailto:{{ $message->email }}" class="text-brand-red-500 hover:underline">{{ $message->email }}</a>&gt;</p>
                    @if ($message->phone)
                        <p class="text-sm text-slate-500">Phone: <a href="tel:{{ preg_replace('/[^\d+]/', '', $message->phone) }}" class="text-slate-700 hover:text-brand-red-500">{{ $message->phone }}</a></p>
                    @endif
                </div>
                <div class="text-right text-xs text-slate-500">
                    <div>{{ $message->created_at->format('M j, Y · g:ia') }}</div>
                    <div class="mt-0.5">{{ $message->created_at->diffForHumans() }}</div>
                </div>
            </div>
        </div>

        <div class="px-6 py-5">
            <pre class="whitespace-pre-wrap break-words font-sans text-sm leading-relaxed text-slate-800">{{ $message->message }}</pre>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4 text-xs text-slate-500">
            <div>
                @if ($message->ip_address) IP {{ $message->ip_address }} · @endif
                @if ($message->read_at) Read {{ $message->read_at->diffForHumans() }} @endif
            </div>
            <div class="flex items-center gap-3">
                <a href="mailto:{{ $message->email }}?subject={{ rawurlencode('Re: ' . ($message->subject ?: 'Your message')) }}"
                   class="inline-flex items-center gap-1.5 rounded-full bg-brand-red-500 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-red-600">
                    Reply by email
                </a>
                <form method="POST" action="{{ route('admin.contact.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-sm text-slate-500 hover:text-red-600">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

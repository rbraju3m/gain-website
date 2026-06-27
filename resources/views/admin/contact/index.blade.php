@extends('admin.layouts.admin')

@section('title', 'Contact inbox')
@section('breadcrumb', 'Messages')

@section('content')
<div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-6 py-4">
        <div>
            <h2 class="text-base font-semibold text-slate-900">Contact inbox</h2>
            <p class="text-sm text-slate-500">
                {{ $messages->total() }} {{ Str::plural('message', $messages->total()) }}
                @if ($unreadCount) <span class="ml-1 inline-flex items-center gap-1 rounded-full bg-brand-red-50 px-2 py-0.5 text-xs font-semibold text-brand-red-500"><span class="h-1.5 w-1.5 rounded-full bg-brand-red-500"></span> {{ $unreadCount }} unread</span> @endif
            </p>
        </div>
    </div>

    @if ($messages->isEmpty())
        <div class="px-6 py-12 text-center text-sm text-slate-500">
            No messages yet. The public form on the homepage will deliver here.
        </div>
    @else
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">From</th>
                    <th class="px-6 py-3">Subject &amp; preview</th>
                    <th class="px-6 py-3">Received</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($messages as $msg)
                    <tr class="hover:bg-slate-50 {{ $msg->isUnread() ? 'bg-brand-red-50/30' : '' }}">
                        <td class="px-6 py-3">
                            @if ($msg->isUnread())
                                <span class="inline-flex items-center gap-1 rounded-full bg-brand-red-100 px-2.5 py-0.5 text-xs font-semibold text-brand-red-600">
                                    <span class="h-1.5 w-1.5 rounded-full bg-brand-red-500"></span> New
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-500">
                                    Read
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-3">
                            <a href="{{ route('admin.contact.show', $msg) }}" class="font-semibold text-slate-900 hover:text-brand-red-500">
                                {{ $msg->name }}
                            </a>
                            <div class="text-xs text-slate-500">{{ $msg->email }}</div>
                        </td>
                        <td class="px-6 py-3">
                            <div class="font-medium text-slate-800">{{ $msg->subject ?: '(no subject)' }}</div>
                            <div class="text-xs text-slate-500">{{ Str::limit($msg->message, 90) }}</div>
                        </td>
                        <td class="px-6 py-3 whitespace-nowrap text-slate-600">
                            {{ $msg->created_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-3 text-right">
                            <a href="{{ route('admin.contact.show', $msg) }}" class="text-sm font-semibold text-brand-red-500 hover:text-brand-red-600">Open</a>
                            <form method="POST" action="{{ route('admin.contact.destroy', $msg) }}" class="inline" onsubmit="return confirm('Delete this message?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="ml-3 text-sm text-slate-500 hover:text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="border-t border-slate-200 px-6 py-3">
            {{ $messages->links() }}
        </div>
    @endif
</div>
@endsection

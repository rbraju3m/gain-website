@extends('admin.layouts.admin')

@section('title', 'Users')
@section('breadcrumb', 'Overview')

@section('content')
<div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-6 py-4">
        <div>
            <h2 class="text-base font-semibold text-slate-900">Users</h2>
            <p class="text-sm text-slate-500">{{ $users->total() }} {{ Str::plural('user', $users->total()) }} — admins can sign in to this panel.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <form method="GET" class="flex flex-wrap items-center gap-2">
                <x-admin.search-box placeholder="Search name or email…" :value="$q" />
                <select name="role" onchange="this.form.submit()"
                        class="rounded-full border border-slate-200 bg-white py-2 pl-3 pr-8 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                    <option value="">All roles</option>
                    <option value="admin" @selected($role === 'admin')>Admin</option>
                    <option value="user"  @selected($role === 'user')>User</option>
                </select>
            </form>
            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center gap-1.5 rounded-full bg-brand-red-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-red-600">
                + New user
            </a>
        </div>
    </div>

    @if ($users->isEmpty())
        <div class="px-6 py-12 text-center text-sm text-slate-500">
            @if (filled($q) || filled($role))
                No users match your filter.
                <a href="{{ route('admin.users.index') }}" class="font-semibold text-brand-red-500">Clear</a>.
            @else
                No users yet. <a href="{{ route('admin.users.create') }}" class="font-semibold text-brand-red-500">Create the first one</a>.
            @endif
        </div>
    @else
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-6 py-3">User</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Role</th>
                    <th class="px-6 py-3">Joined</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($users as $u)
                    @php $isSelf = $u->id === auth()->id(); @endphp
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-3">
                                <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-brand-red-100 text-sm font-bold text-brand-red-500">
                                    {{ Str::of($u->name)->substr(0, 1)->upper() }}
                                </span>
                                <div>
                                    <a href="{{ route('admin.users.edit', $u) }}" class="font-semibold text-slate-900 hover:text-brand-red-500">{{ $u->name }}</a>
                                    @if ($isSelf)
                                        <span class="ml-1 inline-flex rounded-full bg-brand-cream px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider text-brand-red-500">You</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-3 text-slate-600">
                            <a href="mailto:{{ $u->email }}" class="hover:text-brand-red-500">{{ $u->email }}</a>
                        </td>
                        <td class="px-6 py-3">
                            @if ($u->isAdmin())
                                <span class="inline-flex items-center gap-1 rounded-full bg-brand-red-50 px-2.5 py-0.5 text-xs font-semibold text-brand-red-600">
                                    <svg viewBox="0 0 20 20" fill="currentColor" class="h-3 w-3"><path d="M10 2 4 4v5c0 3.5 2.4 6.5 6 7 3.6-.5 6-3.5 6-7V4l-6-2Z"/></svg>
                                    Admin
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-500">User</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-slate-600 whitespace-nowrap">{{ $u->created_at->format('M j, Y') }}</td>
                        <td class="px-6 py-3 text-right">
                            <a href="{{ route('admin.users.edit', $u) }}" class="text-sm font-semibold text-brand-red-500 hover:text-brand-red-600">Edit</a>
                            @if (! $isSelf)
                                <x-admin.confirm-delete :action="route('admin.users.destroy', $u)"
                                                        title="Delete this user?"
                                                        :message="'“' . $u->name . '” (' . $u->email . ') will lose access to the admin and be permanently removed.'"
                                                        class="ml-3 text-sm text-slate-500 hover:text-red-600" />
                            @else
                                <span class="ml-3 text-sm text-slate-300" title="You can't delete your own account">Delete</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($users->hasPages())
            <div class="border-t border-slate-200 px-6 py-3">{{ $users->links() }}</div>
        @endif
    @endif
</div>
@endsection

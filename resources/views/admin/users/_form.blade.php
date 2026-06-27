@php
    $submitLabel = $submitLabel ?? 'Save';
    $isSelf = $user->exists && $user->id === auth()->id();
@endphp
<form method="POST" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}"
      class="space-y-6"
      x-data="{ show: false }">
    @csrf
    @if ($user->exists) @method('PATCH') @endif

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-5 md:grid-cols-2">
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Name</label>
                <input type="text" name="name" required value="{{ old('name', $user->name) }}"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Email</label>
                <input type="email" name="email" required value="{{ old('email', $user->email) }}"
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                <p class="mt-1 text-xs text-slate-400">Used to sign in.</p>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Role</label>
                <select name="role" required
                        @if ($isSelf) onchange="if (this.value !== 'admin') { alert(`You can't remove your own admin role.`); this.value = 'admin'; }" @endif
                        class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                    <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin (full panel access)</option>
                    <option value="user"  @selected(old('role', $user->role ?? 'user') === 'user')>User (no panel access)</option>
                </select>
                @if ($isSelf)
                    <p class="mt-1 text-xs text-amber-600">You can't change your own role.</p>
                @endif
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">
                    @if ($user->exists) New password <span class="ml-1 font-normal normal-case text-slate-400">(leave blank to keep current)</span>
                    @else Password @endif
                </label>
                <div class="relative mt-2">
                    <input :type="show ? 'text' : 'password'" name="password" autocomplete="new-password"
                           @if (! $user->exists) required @endif
                           class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 pr-10 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 grid w-10 place-items-center text-slate-400 hover:text-brand-red-500" :aria-label="show ? 'Hide password' : 'Show password'">
                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4"><path d="M10 4a6 6 0 0 0-6 6 6 6 0 0 0 12 0 6 6 0 0 0-6-6Zm0 10a4 4 0 1 1 0-8 4 4 0 0 1 0 8Zm0-6a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/></svg>
                    </button>
                </div>
                <p class="mt-1 text-xs text-slate-400">At least 8 characters, with letters and numbers.</p>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Confirm password</label>
                <input type="password" name="password_confirmation" autocomplete="new-password"
                       @if (! $user->exists) required @endif
                       class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm focus:border-brand-red-500 focus:outline-none focus:ring-1 focus:ring-brand-red-500">
            </div>
        </div>
    </div>

    <x-admin.form-actions :back-to="route('admin.users.index')" :submit-label="$submitLabel" />
</form>

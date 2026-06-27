<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $q    = $request->string('q')->toString();
        $role = $request->string('role')->toString();

        $users = User::query()
            ->when($q !== '', fn ($qb) => $qb->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
            }))
            ->when($role !== '', fn ($qb) => $qb->where('role', $role))
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'q', 'role'));
    }

    public function create(): View
    {
        $user = new User(['role' => 'user']);
        return view('admin.users.create', compact('user'));
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['email_verified_at'] = now();

        $user = User::create($data);

        return redirect()->route('admin.users.index')
            ->with('status', "User “{$user->name}” created.");
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        // Safety: an admin can't demote themselves out of admin (would lock
        // them out of the admin area on the next request).
        if ($user->id === $request->user()->id && ($data['role'] ?? null) !== 'admin') {
            return back()->withErrors(['role' => "You can't remove your own admin role."]);
        }

        // Only overwrite password if a new one was actually typed.
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('status', "User “{$user->name}” saved.");
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return redirect()->route('admin.users.index')
                ->withErrors(['user' => "You can't delete your own account."]);
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('status', "User “{$name}” deleted.");
    }
}

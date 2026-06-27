<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(\Illuminate\Http\Request $request): View
    {
        $q = $request->string('q')->toString();
        $messages = ContactMessage::query()
            ->when($q !== '', fn ($qb) => $qb->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%")
                  ->orWhere('subject', 'like', "%{$q}%")
                  ->orWhere('message', 'like', "%{$q}%");
            }))
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();
        $unreadCount = ContactMessage::unread()->count();

        return view('admin.contact.index', compact('messages', 'unreadCount', 'q'));
    }

    public function show(ContactMessage $contact): View
    {
        $contact->markRead();

        return view('admin.contact.show', ['message' => $contact]);
    }

    public function destroy(ContactMessage $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()
            ->route('admin.contact.index')
            ->with('status', 'Message deleted.');
    }
}

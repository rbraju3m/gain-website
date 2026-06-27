<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(): View
    {
        $messages = ContactMessage::orderByDesc('id')->paginate(20);
        $unreadCount = ContactMessage::unread()->count();

        return view('admin.contact.index', compact('messages', 'unreadCount'));
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

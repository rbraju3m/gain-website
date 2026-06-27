<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\NewsArticle;
use App\Models\Partner;
use App\Models\Programme;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'programmes'         => Programme::count(),
            'programmes_live'    => Programme::where('is_published', true)->count(),
            'news'               => NewsArticle::count(),
            'news_published'     => NewsArticle::whereNotNull('published_at')->where('published_at', '<=', now())->count(),
            'partners'           => Partner::count(),
            'testimonials'       => Testimonial::count(),
            'contacts_total'     => ContactMessage::count(),
            'contacts_unread'    => ContactMessage::unread()->count(),
        ];

        $recentMessages = ContactMessage::orderByDesc('id')->take(5)->get();
        $recentNews     = NewsArticle::orderByDesc('id')->take(5)->get();

        return view('admin.dashboard.index', compact('stats', 'recentMessages', 'recentNews'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Service::published()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->orderBy('category')
            ->distinct()
            ->pluck('category');

        $active = $request->string('category')->toString();

        $services = Service::published()
            ->ordered()
            ->with('media')
            ->when($active !== '', fn ($q) => $q->where('category', $active))
            ->paginate(9)
            ->withQueryString();

        return view('services.index', compact('services', 'categories', 'active'));
    }

    public function show(Service $service): View
    {
        abort_unless($service->is_published, 404);

        $related = Service::published()
            ->ordered()
            ->where('id', '!=', $service->id)
            ->with('media')
            ->take(3)
            ->get();

        return view('services.show', compact('service', 'related'));
    }
}

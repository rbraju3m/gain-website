<?php

namespace App\Http\Controllers;

use App\Models\Programme;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgrammeController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Programme::published()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->orderBy('category')
            ->distinct()
            ->pluck('category');

        $active = $request->string('category')->toString();

        $programmes = Programme::published()
            ->ordered()
            ->with('media')
            ->when($active !== '', fn ($q) => $q->where('category', $active))
            ->paginate(9)
            ->withQueryString();

        return view('programmes.index', compact('programmes', 'categories', 'active'));
    }

    public function show(Programme $programme): View
    {
        abort_unless($programme->is_published, 404);

        $related = Programme::published()
            ->ordered()
            ->where('id', '!=', $programme->id)
            ->with('media')
            ->take(3)
            ->get();

        return view('programmes.show', compact('programme', 'related'));
    }
}

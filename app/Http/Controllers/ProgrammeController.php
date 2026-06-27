<?php

namespace App\Http\Controllers;

use App\Models\Programme;
use Illuminate\View\View;

class ProgrammeController extends Controller
{
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

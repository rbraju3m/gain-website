<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Programme\ProgrammeRequest;
use App\Models\Programme;

class ProgrammeController extends Controller
{
    public function index()
    {
        $programmes = Programme::ordered()->get();
        return view('admin.programmes.index', compact('programmes'));
    }

    public function create()
    {
        $programme = new Programme(['is_published' => true, 'sort_order' => Programme::max('sort_order') + 1]);
        return view('admin.programmes.create', compact('programme'));
    }

    public function store(ProgrammeRequest $request)
    {
        $programme = Programme::create($request->safe()->except(['image', 'remove_image']));
        $this->syncImage($programme, $request);

        return redirect()->route('admin.programmes.index')
            ->with('status', "Programme “{$programme->title}” created.");
    }

    public function edit(Programme $programme)
    {
        return view('admin.programmes.edit', compact('programme'));
    }

    public function update(ProgrammeRequest $request, Programme $programme)
    {
        $programme->update($request->safe()->except(['image', 'remove_image']));
        $this->syncImage($programme, $request);

        return redirect()->route('admin.programmes.index')
            ->with('status', "Programme “{$programme->title}” saved.");
    }

    public function destroy(Programme $programme)
    {
        $title = $programme->title;
        $programme->delete();

        return redirect()->route('admin.programmes.index')
            ->with('status', "Programme “{$title}” deleted.");
    }

    private function syncImage(Programme $programme, ProgrammeRequest $request): void
    {
        if ($request->boolean('remove_image')) {
            $programme->clearMediaCollection('image');
        }
        if ($request->hasFile('image')) {
            $programme->clearMediaCollection('image');
            $programme->addMediaFromRequest('image')->toMediaCollection('image');
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImpactStat\ImpactStatRequest;
use App\Models\ImpactStat;

class ImpactStatController extends Controller
{
    public function index()
    {
        $stats = ImpactStat::ordered()->get();
        return view('admin.impact.index', compact('stats'));
    }

    public function create()
    {
        $stat = new ImpactStat([
            'tone'         => 'red',
            'is_published' => true,
            'sort_order'   => ImpactStat::max('sort_order') + 1,
        ]);
        return view('admin.impact.create', compact('stat'));
    }

    public function store(ImpactStatRequest $request)
    {
        $stat = ImpactStat::create($request->validated());
        return redirect()->route('admin.impact.index')->with('status', "“{$stat->label}” added.");
    }

    public function edit(ImpactStat $impact)
    {
        return view('admin.impact.edit', ['stat' => $impact]);
    }

    public function update(ImpactStatRequest $request, ImpactStat $impact)
    {
        $impact->update($request->validated());
        return redirect()->route('admin.impact.index')->with('status', "“{$impact->label}” saved.");
    }

    public function destroy(ImpactStat $impact)
    {
        $label = $impact->label;
        $impact->delete();
        return redirect()->route('admin.impact.index')->with('status', "“{$label}” deleted.");
    }
}

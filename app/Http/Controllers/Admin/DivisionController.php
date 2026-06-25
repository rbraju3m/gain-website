<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Division\DivisionRequest;
use App\Models\Division;

class DivisionController extends Controller
{
    // Divisions are a fixed 8-row set — only index / edit / update.

    public function index()
    {
        $divisions = Division::ordered()->withCount(['districts as active_districts_count' => fn ($q) => $q->where('is_active', true)])->get();
        return view('admin.divisions.index', compact('divisions'));
    }

    public function edit(Division $division)
    {
        return view('admin.divisions.edit', compact('division'));
    }

    public function update(DivisionRequest $request, Division $division)
    {
        $division->update($request->validated());
        return redirect()->route('admin.divisions.index')
            ->with('status', "Division “{$division->name}” saved.");
    }
}

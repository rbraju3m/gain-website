<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\District\DistrictBulkUpdateRequest;
use App\Models\Division;

class DistrictController extends Controller
{
    public function index()
    {
        $divisions = Division::ordered()->with('districts')->get();
        return view('admin.districts.index', compact('divisions'));
    }

    public function updateActive(DistrictBulkUpdateRequest $request)
    {
        $activeIds = array_map('intval', $request->validated()['active'] ?? []);

        // Set every district's is_active based on whether its id is in the
        // posted "active" array. Done in two queries so the operation is
        // O(2) regardless of how many districts exist.
        \App\Models\District::query()->whereIn('id', $activeIds)->update(['is_active' => true]);
        \App\Models\District::query()->whereNotIn('id', $activeIds)->update(['is_active' => false]);

        return redirect()->route('admin.districts.index')
            ->with('status', count($activeIds) . ' districts marked active.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\District\DistrictBulkUpdateRequest;
use App\Models\District;
use App\Models\Division;
use Illuminate\Support\Facades\Cache;

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

        // Two query-builder updates: O(2) regardless of district count.
        // NB: query-builder update() does not fire Eloquent events, so we
        // bust the map cache by hand here (HasHomepageCache only catches
        // saved/deleted on individual model instances).
        District::query()->whereIn('id', $activeIds)->update(['is_active' => true]);
        District::query()->whereNotIn('id', $activeIds)->update(['is_active' => false]);

        Cache::forget(Division::CACHE_KEY);

        return redirect()->route('admin.districts.index')
            ->with('status', count($activeIds) . ' districts marked active.');
    }
}

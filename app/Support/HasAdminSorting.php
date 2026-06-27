<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Reusable POST /sort handler for admin controllers whose models have a
 * sort_order column. Expects ?order=[id1, id2, ...] in the JSON body.
 *
 * Concrete controllers must implement:
 *   - sortableModelClass(): string  // the FQCN of the Eloquent model
 *
 * Bulk query-builder updates skip Eloquent events, so this also forgets
 * any HasHomepageCache keys the model declares (see CLAUDE.md).
 */
trait HasAdminSorting
{
    public function sort(Request $request)
    {
        $data = $request->validate([
            'order'   => ['required', 'array'],
            'order.*' => ['integer', 'min:1'],
        ]);

        $model = $this->sortableModelClass();

        DB::transaction(function () use ($model, $data) {
            foreach ($data['order'] as $i => $id) {
                $model::where('id', $id)->update(['sort_order' => $i + 1]);
            }
        });

        // Bulk updates don't fire model events — bust caches manually.
        if (method_exists($model, 'homepageCacheKeys')) {
            foreach ((new $model)->homepageCacheKeys() as $key) {
                Cache::forget($key);
            }
        }

        return response()->json(['ok' => true]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryYear\GalleryYearRequest;
use App\Models\GalleryYear;
use App\Support\HasAdminSorting;
use Illuminate\Http\Request;

class GalleryYearController extends Controller
{
    use HasAdminSorting;

    protected function sortableModelClass(): string { return GalleryYear::class; }

    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $years = GalleryYear::ordered()
            ->withCount('images')
            ->when($q !== '', fn ($qb) => $qb->where(function ($qb) use ($q) {
                $qb->where('title', 'like', "%{$q}%")
                   ->orWhere('year', 'like', "%{$q}%");
            }))
            ->paginate(20)
            ->withQueryString();
        return view('admin.gallery-years.index', compact('years', 'q'));
    }

    public function create()
    {
        $year = new GalleryYear([
            'is_published' => true,
            'sort_order'   => GalleryYear::max('sort_order') + 1,
            'year'         => (int) now()->format('Y'),
        ]);
        return view('admin.gallery-years.create', compact('year'));
    }

    public function store(GalleryYearRequest $request)
    {
        $data = $request->validated();
        $year = GalleryYear::create($data);

        return redirect()->route('admin.gallery-years.index')
            ->with('status', "Gallery year “{$year->year}” created.");
    }

    public function edit(GalleryYear $galleryYear)
    {
        return view('admin.gallery-years.edit', ['year' => $galleryYear]);
    }

    public function update(GalleryYearRequest $request, GalleryYear $galleryYear)
    {
        $galleryYear->update($request->validated());

        return redirect()->route('admin.gallery-years.index')
            ->with('status', "Gallery year “{$galleryYear->year}” saved.");
    }

    public function destroy(GalleryYear $galleryYear)
    {
        $year = $galleryYear->year;
        $galleryYear->delete();

        return redirect()->route('admin.gallery-years.index')
            ->with('status', "Gallery year “{$year}” deleted along with its images.");
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryImage\GalleryImageRequest;
use App\Models\GalleryImage;
use App\Models\GalleryYear;
use App\Support\HasAdminSorting;
use App\Support\SyncsSingleFileMedia;
use Illuminate\Http\Request;

class GalleryImageController extends Controller
{
    use HasAdminSorting, SyncsSingleFileMedia;

    protected function sortableModelClass(): string { return GalleryImage::class; }

    public function index(Request $request)
    {
        $q         = $request->string('q')->toString();
        $yearId    = $request->integer('year_id') ?: null;
        $allYears  = GalleryYear::ordered()->get();

        $images = GalleryImage::with(['year', 'media'])
            ->when($yearId, fn ($qb) => $qb->where('gallery_year_id', $yearId))
            ->when($q !== '', fn ($qb) => $qb->where('title', 'like', "%{$q}%"))
            ->orderBy('gallery_year_id')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(24)
            ->withQueryString();

        return view('admin.gallery-images.index', compact('images', 'allYears', 'yearId', 'q'));
    }

    public function create(Request $request)
    {
        $allYears = GalleryYear::ordered()->get();
        if ($allYears->isEmpty()) {
            return redirect()->route('admin.gallery-years.create')
                ->with('status', 'Create a gallery year first, then come back to add images.');
        }

        $image = new GalleryImage([
            'is_published'    => true,
            'sort_order'      => GalleryImage::max('sort_order') + 1,
            'gallery_year_id' => $request->integer('year_id') ?: $allYears->first()->id,
        ]);

        return view('admin.gallery-images.create', compact('image', 'allYears'));
    }

    public function store(GalleryImageRequest $request)
    {
        $data  = $request->safe()->except(['image', 'remove_image']);
        $image = GalleryImage::create($data);
        $this->syncSingleFileMedia($image, $request);

        return redirect()->route('admin.gallery-images.index', ['year_id' => $image->gallery_year_id])
            ->with('status', "Image “{$image->title}” added.");
    }

    public function edit(GalleryImage $galleryImage)
    {
        $allYears = GalleryYear::ordered()->get();
        return view('admin.gallery-images.edit', ['image' => $galleryImage, 'allYears' => $allYears]);
    }

    public function update(GalleryImageRequest $request, GalleryImage $galleryImage)
    {
        $data = $request->safe()->except(['image', 'remove_image']);
        $galleryImage->update($data);
        $this->syncSingleFileMedia($galleryImage, $request);

        return redirect()->route('admin.gallery-images.index', ['year_id' => $galleryImage->gallery_year_id])
            ->with('status', "Image “{$galleryImage->title}” saved.");
    }

    public function destroy(GalleryImage $galleryImage)
    {
        $yearId = $galleryImage->gallery_year_id;
        $title  = $galleryImage->title;
        $galleryImage->delete();

        return redirect()->route('admin.gallery-images.index', ['year_id' => $yearId])
            ->with('status', "Image “{$title}” deleted.");
    }
}

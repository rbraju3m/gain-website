<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HeroSlide\HeroSlideRequest;
use App\Models\HeroSlide;
use App\Support\HasAdminSorting;
use App\Support\SyncsSingleFileMedia;
use Illuminate\Http\Request;

class HeroSlideController extends Controller
{
    use HasAdminSorting, SyncsSingleFileMedia;

    protected function sortableModelClass(): string { return HeroSlide::class; }

    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $slides = HeroSlide::ordered()
            ->with('media')
            ->when($q !== '', fn ($qb) => $qb->where(function ($qb) use ($q) {
                $qb->where('badge', 'like', "%{$q}%")
                   ->orWhere('line1', 'like', "%{$q}%")
                   ->orWhere('line2_accent', 'like', "%{$q}%")
                   ->orWhere('line3_accent', 'like', "%{$q}%");
            }))
            ->paginate(20)
            ->withQueryString();
        return view('admin.hero-slides.index', compact('slides', 'q'));
    }

    public function create()
    {
        $slide = new HeroSlide(['is_published' => true, 'sort_order' => HeroSlide::max('sort_order') + 1]);
        return view('admin.hero-slides.create', compact('slide'));
    }

    public function store(HeroSlideRequest $request)
    {
        $data = $request->safe()->except(['image', 'remove_image']);
        $slide = HeroSlide::create($data);
        $this->syncSingleFileMedia($slide, $request);

        return redirect()->route('admin.hero-slides.index')
            ->with('status', 'Hero slide created.');
    }

    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero-slides.edit', ['slide' => $heroSlide]);
    }

    public function update(HeroSlideRequest $request, HeroSlide $heroSlide)
    {
        $data = $request->safe()->except(['image', 'remove_image']);
        $heroSlide->update($data);
        $this->syncSingleFileMedia($heroSlide, $request);

        return redirect()->route('admin.hero-slides.index')
            ->with('status', 'Hero slide saved.');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        $heroSlide->delete();

        return redirect()->route('admin.hero-slides.index')
            ->with('status', 'Hero slide deleted.');
    }
}
